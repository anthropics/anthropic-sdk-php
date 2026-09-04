<?php

namespace Tests\Core;

use Anthropic\Core\BaseClient;
use Anthropic\Core\Exceptions\APIConnectionException;
use Anthropic\Core\Exceptions\APIStatusException;
use Anthropic\Core\FileParam;
use Anthropic\Core\Implementation\StreamingHttpClient;
use Anthropic\RequestOptions;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\NoSeekStream;
use Http\Client\Exception\NetworkException;
use Http\Client\Exception\RequestException;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Mock\Client as MockClient;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Records retry sleeps instead of sleeping and exposes the retry delay computation.
 */
class RetryTestClient extends BaseClient
{
    /** @var list<float> */
    public array $sleeps = [];

    public function delay(int $retryCount, ?ResponseInterface $rsp): float
    {
        return $this->retryDelay($this->options, retryCount: $retryCount, rsp: $rsp);
    }

    protected function sleep(float $seconds): void
    {
        $this->sleeps[] = $seconds;
    }
}

/**
 * Reads each request body to the end, as a real client does when it writes the body to the socket.
 */
class BodyReadingMockClient extends MockClient
{
    /** @var list<string> */
    public array $sent = [];

    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        $this->sent[] = $request->getBody()->getContents();

        return parent::sendRequest($request);
    }
}

/**
 * @internal
 *
 * @coversNothing
 */
#[CoversNothing]
class RetryTest extends TestCase
{
    #[Test]
    public function testRetriesRetryableStatusThenSucceeds(): void
    {
        [$client, $transporter] = $this->buildClient();
        $transporter->addResponse($this->response(503)->withHeader('retry-after-ms', '1500'));
        $transporter->addResponse($this->response(200));

        $client->request('GET', '/');

        $requests = $transporter->getRequests();
        $this->assertCount(2, $requests);
        // Some generated SDKs omit the X-Stainless-Retry-Count header entirely.
        if ($requests[0]->hasHeader('x-stainless-retry-count')) {
            $this->assertSame('0', $requests[0]->getHeaderLine('x-stainless-retry-count'));
            $this->assertSame('1', $requests[1]->getHeaderLine('x-stainless-retry-count'));
        }
        $this->assertSame([1.5], $client->sleeps);
    }

    #[Test]
    public function testRetriesEachRetryableStatus(): void
    {
        foreach ([408, 409, 429, 500, 503, 599] as $status) {
            [$client, $transporter] = $this->buildClient();
            $transporter->addResponse($this->response($status));
            $transporter->addResponse($this->response(200));

            $client->request('GET', '/');

            $this->assertCount(2, $transporter->getRequests(), "status {$status}");
            $this->assertCount(1, $client->sleeps, "status {$status}");
        }
    }

    #[Test]
    public function testDoesNotRetryNonRetryableStatus(): void
    {
        foreach ([400, 401, 403, 404, 422] as $status) {
            [$client, $transporter] = $this->buildClient();
            $transporter->addResponse($this->response($status));
            $transporter->addResponse($this->response(200));

            try {
                $client->request('GET', '/');
                $this->fail("status {$status} should raise");
            } catch (APIStatusException $e) {
                $this->assertSame($status, $e->status);
            }

            $this->assertCount(1, $transporter->getRequests(), "status {$status}");
            $this->assertSame([], $client->sleeps);
        }
    }

    #[Test]
    public function testEmptyOrNonJsonErrorBodyStillRaisesStatusException(): void
    {
        foreach (['' => null, 'upstream timeout' => 'upstream timeout', '{"error":"conflict"}' => ['error' => 'conflict']] as $raw => $body) {
            [$client, $transporter] = $this->buildClient(maxRetries: 0);
            $transporter->addResponse(
                Psr17FactoryDiscovery::findResponseFactory()->createResponse(409)
                    ->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream((string) $raw))
            );

            try {
                $client->request('GET', '/');
                $this->fail("body '{$raw}' should raise");
            } catch (APIStatusException $e) {
                $this->assertSame(409, $e->status, "body '{$raw}'");
                $this->assertSame($body, $e->body, "body '{$raw}'");
                $this->assertStringContainsString('409', $e->getMessage(), "body '{$raw}'");
            }
        }
    }

    #[Test]
    public function testNonSeekableErrorBodyIsDecodedOnce(): void
    {
        // A streamed error body cannot be rewound, so a second read would yield an empty body.
        [$client, $transporter] = $this->buildClient(maxRetries: 0);
        $transporter->addResponse(
            Psr17FactoryDiscovery::findResponseFactory()->createResponse(400)
                ->withBody(new NoSeekStream(Psr17FactoryDiscovery::findStreamFactory()->createStream('{"error":"bad"}')))
        );

        try {
            $client->request('GET', '/');
            $this->fail('should raise');
        } catch (APIStatusException $e) {
            $this->assertSame(400, $e->status);
            $this->assertSame(['error' => 'bad'], $e->body);
            $this->assertStringContainsString('"error": "bad"', $e->getMessage());
        }
    }

    #[Test]
    public function testStopsAfterMaxRetries(): void
    {
        [$client, $transporter] = $this->buildClient(maxRetries: 2);
        for ($i = 0; $i < 4; ++$i) {
            $transporter->addResponse($this->response(500));
        }

        try {
            $client->request('GET', '/');
            $this->fail('should raise after exhausting retries');
        } catch (APIStatusException $e) {
            $this->assertSame(500, $e->status);
        }

        $requests = $transporter->getRequests();
        $this->assertCount(3, $requests);
        // Some generated SDKs omit the X-Stainless-Retry-Count header entirely.
        if ($requests[0]->hasHeader('x-stainless-retry-count')) {
            $this->assertSame(['0', '1', '2'], array_map(static fn ($r) => $r->getHeaderLine('x-stainless-retry-count'), $requests));
        }
        $this->assertCount(2, $client->sleeps);
    }

    #[Test]
    public function testMaxRetriesZeroDisablesRetries(): void
    {
        [$client, $transporter] = $this->buildClient(maxRetries: 0);
        $transporter->addResponse($this->response(429));
        $transporter->addResponse($this->response(200));

        $this->expectException(APIStatusException::class);

        try {
            $client->request('GET', '/');
        } finally {
            $this->assertCount(1, $transporter->getRequests());
        }
    }

    #[Test]
    public function testRetriesConnectionErrors(): void
    {
        [$client, $transporter] = $this->buildClient();
        $req = Psr17FactoryDiscovery::findRequestFactory()->createRequest('GET', 'http://localhost');
        $transporter->addException(new NetworkException('connection reset by peer', $req));
        $transporter->addException(new RequestException('transfer closed with outstanding read data remaining', $req));
        $transporter->addResponse($this->response(200));

        $client->request('GET', '/');

        $this->assertCount(3, $transporter->getRequests());
        $this->assertCount(2, $client->sleeps);
    }

    #[Test]
    public function testConnectionErrorSurfacesAfterMaxRetries(): void
    {
        [$client, $transporter] = $this->buildClient(maxRetries: 1);
        $req = Psr17FactoryDiscovery::findRequestFactory()->createRequest('GET', 'http://localhost');
        $boom = new NetworkException('connection refused', $req);
        $transporter->setDefaultException($boom);

        try {
            $client->request('GET', '/');
            $this->fail('should raise APIConnectionException');
        } catch (APIConnectionException $e) {
            $this->assertSame($boom, $e->getPrevious());
        }

        $this->assertCount(2, $transporter->getRequests());
        $this->assertCount(1, $client->sleeps);
    }

    #[Test]
    public function testShouldRetryHeaderOverridesStatus(): void
    {
        [$client, $transporter] = $this->buildClient();
        $transporter->addResponse($this->response(400)->withHeader('x-should-retry', 'true'));
        $transporter->addResponse($this->response(200));

        $client->request('GET', '/');
        $this->assertCount(2, $transporter->getRequests());

        [$client, $transporter] = $this->buildClient();
        $transporter->addResponse($this->response(500)->withHeader('x-should-retry', 'false'));
        $transporter->addResponse($this->response(200));

        try {
            $client->request('GET', '/');
            $this->fail('x-should-retry: false must not be retried');
        } catch (APIStatusException $e) {
            $this->assertSame(500, $e->status);
        }
        $this->assertCount(1, $transporter->getRequests());
        $this->assertSame([], $client->sleeps);
    }

    #[Test]
    public function testRetryAfterHeaders(): void
    {
        [$client] = $this->buildClient(initialRetryDelay: 0.5, maxRetryDelay: 8.0);

        // retry-after-ms takes precedence and is in milliseconds
        $rsp = $this->response(429)->withHeader('retry-after-ms', '1500')->withHeader('retry-after', '3');
        $this->assertSame(1.5, $client->delay(0, $rsp));

        // numeric retry-after is in seconds (floats tolerated) and is honored as sent, however large
        $this->assertSame(2.0, $client->delay(0, $this->response(429)->withHeader('retry-after', '2')));
        $this->assertSame(0.25, $client->delay(0, $this->response(429)->withHeader('retry-after', '0.25')));
        $this->assertSame(60.0, $client->delay(0, $this->response(429)->withHeader('retry-after', '60')));
        $this->assertSame(120.0, $client->delay(0, $this->response(429)->withHeader('retry-after', '120')));
        $this->assertSame(120000.0, $client->delay(0, $this->response(429)->withHeader('retry-after', '120000')));
        $this->assertSame(60.001, $client->delay(0, $this->response(429)->withHeader('retry-after-ms', '60001')));
        $this->assertSame(300.0, $client->delay(0, $this->response(429)->withHeader('retry-after-ms', '300000')));

        // an HTTP-date retry-after in the future waits until then
        $future = gmdate('D, d M Y H:i:s', time() + 30).' GMT';
        $delay = $client->delay(0, $this->response(429)->withHeader('retry-after', $future));
        $this->assertGreaterThanOrEqual(28.0, $delay);
        $this->assertLessThanOrEqual(31.0, $delay);
        $farFuture = gmdate('D, d M Y H:i:s', time() + 600).' GMT';
        $delay = $client->delay(0, $this->response(429)->withHeader('retry-after', $farFuture));
        $this->assertGreaterThanOrEqual(598.0, $delay);
        $this->assertLessThanOrEqual(601.0, $delay);

        // past dates, zero, negative or unparseable values fall back to the computed backoff
        $past = gmdate('D, d M Y H:i:s', time() - 30).' GMT';
        foreach ([$past, '0', '-3', 'soon'] as $value) {
            $delay = $client->delay(0, $this->response(429)->withHeader('retry-after', $value));
            $this->assertGreaterThanOrEqual(0.375, $delay, "retry-after: {$value}");
            $this->assertLessThanOrEqual(0.5, $delay, "retry-after: {$value}");
        }
        foreach (['0', '-100'] as $value) {
            $delay = $client->delay(0, $this->response(429)->withHeader('retry-after-ms', $value));
            $this->assertGreaterThanOrEqual(0.375, $delay, "retry-after-ms: {$value}");
            $this->assertLessThanOrEqual(0.5, $delay, "retry-after-ms: {$value}");
        }
    }

    #[Test]
    public function testExponentialBackoffWithJitter(): void
    {
        [$client] = $this->buildClient(initialRetryDelay: 0.5, maxRetryDelay: 8.0);

        // delay = min(initialRetryDelay * 2^retryCount, maxRetryDelay) * jitter, with jitter in [0.75, 1.0]
        $expected = [
            0 => [0.375, 0.5],
            1 => [0.75, 1.0],
            2 => [1.5, 2.0],
            3 => [3.0, 4.0],
            4 => [6.0, 8.0],
            5 => [6.0, 8.0],
            10 => [6.0, 8.0],
        ];
        foreach ($expected as $retryCount => [$min, $max]) {
            for ($i = 0; $i < 20; ++$i) {
                $delay = $client->delay($retryCount, null);
                $this->assertGreaterThanOrEqual($min, $delay, "retryCount {$retryCount}");
                $this->assertLessThanOrEqual($max, $delay, "retryCount {$retryCount}");
            }
        }
    }

    #[Test]
    public function testClosesResponseBodyBeforeRetrying(): void
    {
        [$client, $transporter] = $this->buildClient();
        $first = $this->response(503);
        $transporter->addResponse($first);
        $transporter->addResponse($this->response(200));

        $client->request('GET', '/');

        $this->assertCount(2, $transporter->getRequests());
        $this->assertFalse($first->getBody()->isReadable());
    }

    #[Test]
    public function testStreamingErrorStatusIsNotRetriedAsConnectionError(): void
    {
        foreach ([400, 401, 403, 404, 422] as $status) {
            [$guzzle, $queue] = $this->guzzleClient([$this->response($status), $this->response(200)]);
            [$client] = $this->buildClient(streamingTransporter: new StreamingHttpClient($guzzle));

            try {
                $client->request('POST', '/', headers: ['Accept' => 'text/event-stream']);
                $this->fail("streamed status {$status} should raise");
            } catch (APIStatusException $e) {
                $this->assertSame($status, $e->status);
            }

            // One attempt: only the error response was consumed.
            $this->assertCount(1, $queue, "streamed status {$status}");
            $this->assertSame([], $client->sleeps, "streamed status {$status}");
        }
    }

    #[Test]
    public function testStreamingRetryableStatusIsRetried(): void
    {
        [$guzzle, $queue] = $this->guzzleClient([$this->response(503), $this->response(200)]);
        [$client] = $this->buildClient(streamingTransporter: new StreamingHttpClient($guzzle));

        $client->request('POST', '/', headers: ['Accept' => 'text/event-stream']);

        $this->assertCount(0, $queue);
        $this->assertCount(1, $client->sleeps);
    }

    #[Test]
    public function testRetriedMultipartUploadStaysWellFormed(): void
    {
        [$client, $transporter] = $this->buildClient();
        $transporter->addResponse($this->response(503));
        $transporter->addResponse($this->response(200));

        $file = fopen('php://temp', 'r+');
        assert(false !== $file);
        fwrite($file, 'hello,world');
        rewind($file);

        $client->request(
            'POST',
            '/files',
            headers: ['Content-Type' => 'multipart/form-data'],
            body: ['purpose' => 'test', 'file' => FileParam::fromResource($file, filename: 'data.csv', contentType: 'text/csv')],
        );

        $requests = $transporter->getRequests();
        $this->assertCount(2, $requests);

        $boundaries = [];
        foreach ($requests as $i => $req) {
            $contentType = $req->getHeaderLine('Content-Type');
            $this->assertSame(1, preg_match_all('/boundary=/', $contentType), "attempt {$i}: {$contentType}");
            $this->assertSame(1, preg_match('/^multipart\/form-data; boundary=(\S+)$/', $contentType, $m), "attempt {$i}: {$contentType}");
            $boundaries[] = $boundary = $m[1];

            $body = (string) $req->getBody();
            $this->assertStringStartsWith("--{$boundary}\r\n", $body, "attempt {$i}");
            $this->assertStringEndsWith("--{$boundary}--\r\n", $body, "attempt {$i}");
            $this->assertStringContainsString("name=\"purpose\"\r\n", $body, "attempt {$i}");
            $this->assertStringContainsString("name=\"file\"; filename=\"data.csv\"\r\nContent-Type: text/csv\r\n\r\nhello,world\r\n", $body, "attempt {$i}");
        }
        $this->assertNotSame($boundaries[0], $boundaries[1]);
    }

    #[Test]
    public function testRetrySendsStreamBodyFromTheStart(): void
    {
        $resource = fopen('php://temp', 'r+');
        assert(false !== $resource);
        fwrite($resource, 'payload');
        rewind($resource);

        foreach (['stream' => Psr17FactoryDiscovery::findStreamFactory()->createStream('payload'), 'resource' => $resource] as $kind => $body) {
            [$client, $transporter] = $this->buildClient();
            $transporter->addException(new NetworkException('connection reset by peer', Psr17FactoryDiscovery::findRequestFactory()->createRequest('POST', '/')));
            $transporter->addResponse($this->response(503));
            $transporter->addResponse($this->response(200));

            $client->request('POST', '/files', headers: ['Content-Type' => 'application/octet-stream'], body: $body);

            $this->assertSame(['payload', 'payload', 'payload'], $transporter->sent, $kind);
        }
    }

    #[Test]
    public function testConsumedNonSeekableBodyIsNotRetried(): void
    {
        $body = fn () => new NoSeekStream(Psr17FactoryDiscovery::findStreamFactory()->createStream('payload'));

        [$client, $transporter] = $this->buildClient();
        $transporter->addResponse($this->response(503));
        $transporter->addResponse($this->response(200));

        try {
            $client->request('POST', '/files', headers: ['Content-Type' => 'application/octet-stream'], body: $body());
            $this->fail('a drained body that cannot be rewound must not be retried');
        } catch (APIStatusException $e) {
            $this->assertSame(503, $e->status);
        }
        $this->assertSame(['payload'], $transporter->sent);
        $this->assertSame([], $client->sleeps);

        [$client, $transporter] = $this->buildClient();
        $transporter->addException(new NetworkException('connection reset by peer', Psr17FactoryDiscovery::findRequestFactory()->createRequest('POST', '/')));
        $transporter->addResponse($this->response(200));

        try {
            $client->request('POST', '/files', headers: ['Content-Type' => 'application/octet-stream'], body: $body());
            $this->fail('a drained body that cannot be rewound must not be retried');
        } catch (APIConnectionException) {
        }
        $this->assertSame(['payload'], $transporter->sent);
        $this->assertSame([], $client->sleeps);
    }

    /**
     * @return array{RetryTestClient, BodyReadingMockClient}
     */
    private function buildClient(int $maxRetries = 2, float $initialRetryDelay = 0.5, float $maxRetryDelay = 8.0, ?ClientInterface $streamingTransporter = null): array
    {
        $transporter = new BodyReadingMockClient;

        $options = RequestOptions::with(
            maxRetries: $maxRetries,
            initialRetryDelay: $initialRetryDelay,
            maxRetryDelay: $maxRetryDelay,
            transporter: $transporter,
            streamingTransporter: $streamingTransporter,
            uriFactory: Psr17FactoryDiscovery::findUriFactory(),
            requestFactory: Psr17FactoryDiscovery::findRequestFactory(),
            streamFactory: Psr17FactoryDiscovery::findStreamFactory(),
        );

        $client = new RetryTestClient(headers: [], baseUrl: 'http://localhost', options: $options);

        return [$client, $transporter];
    }

    /**
     * A Guzzle client (what the SDK's default streaming transport wraps) with its stock middleware
     * stack, answering from a queue of canned responses; what is left in the queue tells how many
     * attempts were made.
     *
     * @param list<ResponseInterface> $responses
     *
     * @return array{GuzzleClient, MockHandler}
     */
    private function guzzleClient(array $responses): array
    {
        $queue = new MockHandler($responses);

        return [new GuzzleClient(['handler' => HandlerStack::create($queue)]), $queue];
    }

    private function response(int $status): ResponseInterface
    {
        return Psr17FactoryDiscovery::findResponseFactory()->createResponse($status)
            ->withHeader('Content-Type', 'application/json')
            ->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream('{}'))
        ;
    }
}
