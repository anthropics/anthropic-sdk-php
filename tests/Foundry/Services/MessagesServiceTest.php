<?php

namespace Tests\Foundry\Services;

use Anthropic\Foundry\Client;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Mock\Client as MockClient;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;

/**
 * @internal
 */
#[CoversNothing]
final class MessagesServiceTest extends TestCase
{
    private MockClient $transporter;

    protected function setUp(): void
    {
        $this->transporter = new MockClient;
    }

    /**
     * @param \Closure(Client, string|null): mixed $call
     */
    #[DataProvider('messagesCalls')]
    public function testUserProfileIdIsSentAsHeaderAndNotInBody(\Closure $call, string $contentType): void
    {
        $call($this->makeClient($contentType), 'uprof_123');
        $request = $this->getLastRequest();

        $this->assertSame('uprof_123', $request->getHeaderLine('anthropic-user-profile-id'));
        $body = json_decode((string) $request->getBody(), associative: true);
        $this->assertIsArray($body);
        $this->assertArrayNotHasKey('userProfileID', $body);
    }

    /**
     * @param \Closure(Client, string|null): mixed $call
     */
    #[DataProvider('messagesCalls')]
    public function testUserProfileIdHeaderIsOmittedWhenNotGiven(\Closure $call, string $contentType): void
    {
        $call($this->makeClient($contentType), null);

        $this->assertFalse($this->getLastRequest()->hasHeader('anthropic-user-profile-id'));
    }

    /**
     * @return iterable<string, array{\Closure(Client, string|null): mixed, string}>
     */
    public static function messagesCalls(): iterable
    {
        yield 'create' => [static fn (Client $client, ?string $userProfileID) => $client->messages->create(
            maxTokens: 1,
            messages: [],
            model: 'claude-haiku-4-5',
            userProfileID: $userProfileID,
        ), 'application/json'];

        yield 'createStream' => [static fn (Client $client, ?string $userProfileID) => $client->messages->createStream(
            maxTokens: 1,
            messages: [],
            model: 'claude-haiku-4-5',
            userProfileID: $userProfileID,
        ), 'text/event-stream'];

        yield 'countTokens' => [static fn (Client $client, ?string $userProfileID) => $client->messages->countTokens(
            messages: [],
            model: 'claude-haiku-4-5',
            userProfileID: $userProfileID,
        ), 'application/json'];

        $params = static fn (?string $userProfileID): array => [
            'maxTokens' => 1,
            'messages' => [],
            'model' => 'claude-haiku-4-5',
            ...(null === $userProfileID ? [] : ['userProfileID' => $userProfileID]),
        ];

        yield 'raw create' => [static fn (Client $client, ?string $userProfileID) => $client->messages->raw->create($params($userProfileID)), 'application/json'];

        yield 'raw createStream' => [static fn (Client $client, ?string $userProfileID) => $client->messages->raw->createStream($params($userProfileID)), 'text/event-stream'];

        yield 'raw countTokens' => [static fn (Client $client, ?string $userProfileID) => $client->messages->raw->countTokens(
            array_diff_key($params($userProfileID), ['maxTokens' => 1]),
        ), 'application/json'];
    }

    private function makeClient(string $contentType): Client
    {
        $this->transporter->setDefaultResponse(
            Psr17FactoryDiscovery::findResponseFactory()
                ->createResponse(200)
                ->withHeader('Content-Type', $contentType)
                ->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream('application/json' === $contentType ? '{}' : ''))
        );

        return Client::withCredentials(
            apiKey: 'test-key',
            baseUrl: 'https://foundry.example.test/anthropic',
            requestOptions: ['transporter' => $this->transporter, 'streamingTransporter' => $this->transporter],
        );
    }

    private function getLastRequest(): RequestInterface
    {
        $request = $this->transporter->getLastRequest();
        assert($request instanceof RequestInterface);

        return $request;
    }
}
