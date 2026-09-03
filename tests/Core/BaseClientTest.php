<?php

namespace Tests\Core;

use Anthropic\Core\BaseClient;
use Anthropic\Core\Exceptions\APIStatusException;
use Anthropic\RequestOptions;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Mock\Client as MockClient;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;

/**
 * @internal
 *
 * @coversNothing
 *
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
#[CoversNothing]
class BaseClientTest extends TestCase
{
    #[Test]
    public function testExtraBodyParamsMergeIntoBody(): void
    {
        [$client, $transporter] = $this->buildClient();

        $client->request(
            'POST',
            '/',
            headers: ['Content-Type' => 'application/json'],
            body: (object) ['a' => 1, 'b' => 1],
            options: ['extraBodyParams' => ['b' => 2]],
        );

        // A body with no fields set is still a map: the extras are not dropped.
        $client->request(
            'POST',
            '/',
            headers: ['Content-Type' => 'application/json'],
            body: (object) [],
            options: ['extraBodyParams' => ['b' => 2]],
        );

        [$full, $empty] = $transporter->getRequests();
        $this->assertSame(['a' => 1, 'b' => 2], json_decode((string) $full->getBody(), associative: true));
        $this->assertSame(['b' => 2], json_decode((string) $empty->getBody(), associative: true));
    }

    #[Test]
    public function testRequestOptionsOnlyOverrideWhatTheySet(): void
    {
        [$client, $transporter] = $this->buildClient(['maxRetries' => 3, 'maxRetryDelay' => 0.0], status: 500);

        try {
            $client->request('GET', '/', options: RequestOptions::with(extraHeaders: ['X-Custom' => '1']));
            $this->fail('expected an APIStatusException');
        } catch (APIStatusException) {
        }
        // client-level maxRetries survives request options that leave it unset
        $this->assertCount(4, $transporter->getRequests());

        [$client, $transporter] = $this->buildClient(['maxRetries' => 3, 'maxRetryDelay' => 0.0], status: 500);

        try {
            $client->request('GET', '/', options: ['maxRetries' => 0]);
            $this->fail('expected an APIStatusException');
        } catch (APIStatusException) {
        }
        $this->assertCount(1, $transporter->getRequests());
    }

    #[Test]
    public function testTransformRequestRunsOnEveryAttemptWithTheFinalRequest(): void
    {
        [, $transporter, $requestOptions] = $this->buildClient(['maxRetries' => 2, 'maxRetryDelay' => 0.0], status: 500);

        $client = new class(headers: ['Content-Type' => 'application/json'], baseUrl: 'http://localhost', options: $requestOptions) extends BaseClient {
            /** @var list<string> */
            public array $seenBodies = [];

            protected function transformRequest(RequestInterface $request): RequestInterface
            {
                $this->seenBodies[] = (string) $request->getBody();

                return $request->withHeader('X-Attempt', (string) count($this->seenBodies));
            }
        };

        try {
            $client->request('POST', '/', body: ['a' => 1]);
            $this->fail('expected an APIStatusException');
        } catch (APIStatusException) {
        }

        $this->assertSame(['{"a":1}', '{"a":1}', '{"a":1}'], $client->seenBodies);
        $this->assertSame(['1', '2', '3'], array_map(static fn ($r) => $r->getHeaderLine('X-Attempt'), $transporter->getRequests()));
    }

    /**
     * @param RequestOpts $options client-level request options
     *
     * @return array{BaseClient, MockClient, RequestOptions}
     */
    private function buildClient(RequestOptions|array|null $options = null, int $status = 200): array
    {
        $transporter = new MockClient;
        $responseFactory = Psr17FactoryDiscovery::findResponseFactory();
        $streamFactory = Psr17FactoryDiscovery::findStreamFactory();
        $transporter->setDefaultResponse(
            $responseFactory->createResponse($status)
                ->withHeader('Content-Type', 'application/json')
                ->withBody($streamFactory->createStream('{}')),
        );

        $requestOptions = RequestOptions::parse(
            RequestOptions::with(
                transporter: $transporter,
                uriFactory: Psr17FactoryDiscovery::findUriFactory(),
                requestFactory: Psr17FactoryDiscovery::findRequestFactory(),
                streamFactory: $streamFactory,
            ),
            $options,
        );

        $client = new class(headers: [], baseUrl: 'http://localhost', options: $requestOptions) extends BaseClient {};

        return [$client, $transporter, $requestOptions];
    }
}
