<?php

namespace Tests\Core;

use Anthropic\Core\BaseClient;
use Anthropic\Core\Exceptions\APIConnectionException;
use Anthropic\RequestOptions;
use GuzzleHttp\Psr7\NoSeekStream;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Mock\Client as MockClient;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * @internal
 *
 * @coversNothing
 */
#[CoversNothing]
class RedirectTest extends TestCase
{
    #[Test]
    public function testSameOriginRedirectKeepsCredentialsMethodAndBody(): void
    {
        [$client, $transporter] = $this->buildClient();
        $transporter->addResponse($this->response(307)->withHeader('Location', '/v2/things'));
        $transporter->addResponse($this->response(200));

        $client->request('POST', '/things', headers: ['Authorization' => 'Bearer secret', 'Content-Type' => 'application/json'], body: ['name' => 'x']);

        $requests = $transporter->getRequests();
        $this->assertCount(2, $requests);
        $this->assertSame('http://localhost/v2/things', (string) $requests[1]->getUri());
        $this->assertSame('POST', $requests[1]->getMethod());
        $this->assertSame('Bearer secret', $requests[1]->getHeaderLine('Authorization'));
        $this->assertSame('{"name":"x"}', (string) $requests[1]->getBody());
    }

    #[Test]
    public function testCrossOriginRedirectDropsCredentials(): void
    {
        foreach (['http://elsewhere.example/things', 'https://localhost/things', 'http://localhost:8443/things'] as $location) {
            [$client, $transporter] = $this->buildClient();
            $transporter->addResponse($this->response(302)->withHeader('Location', $location));
            $transporter->addResponse($this->response(200));

            $client->request('GET', '/things', headers: ['Authorization' => 'Bearer secret', 'Cookie' => 'session=1', 'X-Trace' => 'keep']);

            $requests = $transporter->getRequests();
            $this->assertCount(2, $requests, $location);
            $this->assertSame('Bearer secret', $requests[0]->getHeaderLine('Authorization'), $location);
            $this->assertSame($location, (string) $requests[1]->getUri(), $location);
            $this->assertFalse($requests[1]->hasHeader('Authorization'), $location);
            $this->assertFalse($requests[1]->hasHeader('Cookie'), $location);
            $this->assertSame('keep', $requests[1]->getHeaderLine('X-Trace'), $location);
        }
    }

    #[Test]
    public function testCrossOriginRedirectDropsPerAttemptCredentials(): void
    {
        [$client, $transporter] = $this->buildClient(signEachAttempt: true);
        $transporter->addResponse($this->response(302)->withHeader('Location', 'http://elsewhere.example/x'));
        $transporter->addResponse($this->response(200));

        $client->request('GET', '/things', headers: ['Cookie' => 'session=1']);

        $requests = $transporter->getRequests();
        $this->assertCount(2, $requests);
        $this->assertSame('Bearer per-attempt', $requests[0]->getHeaderLine('Authorization'));
        $this->assertSame('http://elsewhere.example/x', (string) $requests[1]->getUri());
        $this->assertFalse($requests[1]->hasHeader('Authorization'));
        $this->assertFalse($requests[1]->hasHeader('Cookie'));
    }

    #[Test]
    public function testSameOriginRedirectKeepsPerAttemptCredentials(): void
    {
        [$client, $transporter] = $this->buildClient(signEachAttempt: true);
        $transporter->addResponse($this->response(307)->withHeader('Location', '/v2/x'));
        $transporter->addResponse($this->response(200));

        $client->request('GET', '/things');

        $requests = $transporter->getRequests();
        $this->assertCount(2, $requests);
        $this->assertSame('http://localhost/v2/x', (string) $requests[1]->getUri());
        $this->assertSame('Bearer per-attempt', $requests[0]->getHeaderLine('Authorization'));
        $this->assertSame('Bearer per-attempt', $requests[1]->getHeaderLine('Authorization'));
    }

    #[Test]
    public function testCrossOriginRedirectDoesNotInheritQueryOrUserInfo(): void
    {
        [$client, $transporter] = $this->buildClient('http://user:pass@localhost');
        $transporter->addResponse($this->response(302)->withHeader('Location', 'http://elsewhere.example/x'));
        $transporter->addResponse($this->response(200));

        $client->request('GET', '/things', query: ['api_key' => 'secret']);

        $requests = $transporter->getRequests();
        $this->assertCount(2, $requests);
        $this->assertSame('http://user:pass@localhost/things?api_key=secret', (string) $requests[0]->getUri());
        $this->assertSame('http://elsewhere.example/x', (string) $requests[1]->getUri());
        $this->assertSame('', $requests[1]->getUri()->getUserInfo());
        $this->assertSame('', $requests[1]->getUri()->getQuery());
    }

    #[Test]
    public function testRelativeRedirectResolvesAgainstRequestUri(): void
    {
        $cases = [
            // A reference with a path replaces path and query (RFC 3986 5.2.2).
            '/v2/things?page=2' => 'http://localhost/v2/things?page=2',
            '/v2/things' => 'http://localhost/v2/things',
            'other' => 'http://localhost/nested/other',
            '../up' => 'http://localhost/up',
            // A query-only reference keeps the path but still replaces the query.
            '?page=3' => 'http://localhost/nested/things?page=3',
            '#part' => 'http://localhost/nested/things?api_key=secret#part',
            // Only "scheme://" or "//" changes the authority; a ':' after the first '/' is plain path.
            '//elsewhere.example/y' => 'http://elsewhere.example/y',
            'HTTPS://Elsewhere.Example/y' => 'https://elsewhere.example/y',
            'elsewhere.example/y' => 'http://localhost/nested/elsewhere.example/y',
            './elsewhere.example:8080/y' => 'http://localhost/nested/elsewhere.example:8080/y',
            'a/b:80/c?d=1#e' => 'http://localhost/nested/a/b:80/c?d=1#e',
        ];
        foreach ($cases as $location => $expected) {
            [$client, $transporter] = $this->buildClient();
            $transporter->addResponse($this->response(307)->withHeader('Location', $location));
            $transporter->addResponse($this->response(200));

            $client->request('GET', '/nested/things', query: ['api_key' => 'secret']);

            $requests = $transporter->getRequests();
            $this->assertCount(2, $requests, $location);
            $this->assertSame('http://localhost/nested/things?api_key=secret', (string) $requests[0]->getUri(), $location);
            $this->assertSame($expected, (string) $requests[1]->getUri(), $location);
        }
    }

    #[Test]
    public function testRejectsNonHttpOrUnparseableLocation(): void
    {
        $locations = [
            'file:///etc/passwd', 'ftp://elsewhere.example/x', 'gopher://localhost:70/1', 'http:///missing-host',
            // A first segment containing ':' is a scheme (RFC 3986 section 4.2), so none of these names an http(s) host to re-send the body to.
            'elsewhere.example:8080/x', 'localhost:8080/x', 'https:/x', 'https:elsewhere.example/x', 'https:\\\elsewhere.example\x', 'mailto:someone@elsewhere.example',
        ];
        foreach ($locations as $location) {
            [$client, $transporter] = $this->buildClient();
            $transporter->addResponse($this->response(307)->withHeader('Location', $location));
            $transporter->addResponse($this->response(200));

            try {
                $client->request('POST', '/things', headers: ['Content-Type' => 'application/json'], body: ['name' => 'x']);
                $this->fail("{$location} should not be followed");
            } catch (APIConnectionException) {
                $this->assertCount(1, $transporter->getRequests(), $location);
            }
        }
    }

    #[Test]
    public function testSeeOtherRefetchesWithBodylessGet(): void
    {
        foreach ([[303, 'POST'], [303, 'PUT'], [301, 'POST'], [302, 'DELETE']] as [$status, $method]) {
            [$client, $transporter] = $this->buildClient();
            $transporter->addResponse($this->response($status)->withHeader('Location', '/result'));
            $transporter->addResponse($this->response(200));

            $client->request($method, '/jobs', headers: ['Content-Type' => 'application/json'], body: ['name' => 'x']);

            $requests = $transporter->getRequests();
            $this->assertCount(2, $requests, "{$status} {$method}");
            $this->assertSame($method, $requests[0]->getMethod(), "{$status} {$method}");
            $this->assertSame('{"name":"x"}', (string) $requests[0]->getBody(), "{$status} {$method}");
            $this->assertSame('GET', $requests[1]->getMethod(), "{$status} {$method}");
            $this->assertSame('http://localhost/result', (string) $requests[1]->getUri(), "{$status} {$method}");
            $this->assertSame('', (string) $requests[1]->getBody(), "{$status} {$method}");
            $this->assertFalse($requests[1]->hasHeader('Content-Type'), "{$status} {$method}");
            $this->assertFalse($requests[1]->hasHeader('Content-Length'), "{$status} {$method}");
        }
    }

    #[Test]
    public function testPermanentRedirectOfGetStaysGet(): void
    {
        [$client, $transporter] = $this->buildClient();
        $transporter->addResponse($this->response(301)->withHeader('Location', '/moved'));
        $transporter->addResponse($this->response(200));

        $client->request('GET', '/old', headers: ['Authorization' => 'Bearer secret']);

        $requests = $transporter->getRequests();
        $this->assertCount(2, $requests);
        $this->assertSame('GET', $requests[1]->getMethod());
        $this->assertSame('Bearer secret', $requests[1]->getHeaderLine('Authorization'));
    }

    #[Test]
    public function testRedirectThatResendsANonSeekableBodyIsNotFollowed(): void
    {
        $body = fn () => new NoSeekStream(Psr17FactoryDiscovery::findStreamFactory()->createStream('payload'));

        // A 307 sends the body again and a non-seekable one cannot be replayed.
        [$client, $transporter] = $this->buildClient();
        $transporter->addResponse($this->response(307)->withHeader('Location', '/v2/files'));
        $transporter->addResponse($this->response(200));

        try {
            $client->request('POST', '/files', headers: ['Content-Type' => 'application/octet-stream'], body: $body());
            $this->fail('307 should not be followed');
        } catch (APIConnectionException) {
        }
        $this->assertCount(1, $transporter->getRequests());

        // A 303 drops the body, so it is still followed.
        [$client, $transporter] = $this->buildClient();
        $transporter->addResponse($this->response(303)->withHeader('Location', '/v2/files'));
        $transporter->addResponse($this->response(200));

        $client->request('POST', '/files', headers: ['Content-Type' => 'application/octet-stream'], body: $body());
        $this->assertCount(2, $transporter->getRequests());
    }

    /**
     * @return array{BaseClient, MockClient}
     */
    private function buildClient(string $baseUrl = 'http://localhost', bool $signEachAttempt = false): array
    {
        $transporter = new MockClient;

        $options = RequestOptions::with(
            maxRetries: 0,
            transporter: $transporter,
            uriFactory: Psr17FactoryDiscovery::findUriFactory(),
            requestFactory: Psr17FactoryDiscovery::findRequestFactory(),
            streamFactory: Psr17FactoryDiscovery::findStreamFactory(),
        );

        $client = new class(headers: [], baseUrl: $baseUrl, options: $options) extends BaseClient {
            public bool $signEachAttempt = false;

            protected function transformRequest(RequestInterface $request): RequestInterface
            {
                return $this->signEachAttempt ? $request->withHeader('Authorization', 'Bearer per-attempt') : $request;
            }
        };
        $client->signEachAttempt = $signEachAttempt;

        return [$client, $transporter];
    }

    private function response(int $status): ResponseInterface
    {
        return Psr17FactoryDiscovery::findResponseFactory()->createResponse($status)
            ->withHeader('Content-Type', 'application/json')
            ->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream('{}'))
        ;
    }
}
