<?php

namespace Tests\Foundry\Services;

use Anthropic\Client as FirstPartyClient;
use Anthropic\Foundry\Client;
use Anthropic\Messages\MessageCountTokensParams;
use Anthropic\Messages\MessageCreateParams;
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
     * @param \Closure(Client, string|null, string|null=): mixed $call
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
     * @param \Closure(Client, string|null, string|null=): mixed $call
     */
    #[DataProvider('messagesCalls')]
    public function testUserProfileIdHeaderIsOmittedWhenNotGiven(\Closure $call, string $contentType): void
    {
        $call($this->makeClient($contentType), null);

        $this->assertFalse($this->getLastRequest()->hasHeader('anthropic-user-profile-id'));
    }

    /**
     * @param \Closure(Client, string|null, string|null=): mixed $call
     */
    #[DataProvider('messagesCalls')]
    public function testWorkspaceIdIsSentAsHeaderAndNotInBody(\Closure $call, string $contentType): void
    {
        $call($this->makeClient($contentType), null, 'wrkspc_123');

        $this->assertSame('wrkspc_123', $this->getLastRequest()->getHeaderLine('anthropic-workspace-id'));
        $this->assertArrayNotHasKey('workspaceID', $this->getLastRequestBody());
    }

    /**
     * @param \Closure(Client, string|null, string|null=): mixed $call
     */
    #[DataProvider('messagesCalls')]
    public function testWorkspaceIdHeaderIsOmittedWhenNotGiven(\Closure $call, string $contentType): void
    {
        $call($this->makeClient($contentType), null);

        $this->assertFalse($this->getLastRequest()->hasHeader('anthropic-workspace-id'));
    }

    /**
     * @return iterable<string, array{\Closure(Client, string|null, string|null=): mixed, string}>
     */
    public static function messagesCalls(): iterable
    {
        yield 'create' => [static fn (Client $client, ?string $userProfileID, ?string $workspaceID = null) => $client->messages->create(
            maxTokens: 1,
            messages: [],
            model: 'claude-haiku-4-5',
            userProfileID: $userProfileID,
            workspaceID: $workspaceID,
        ), 'application/json'];

        yield 'createStream' => [static fn (Client $client, ?string $userProfileID, ?string $workspaceID = null) => $client->messages->createStream(
            maxTokens: 1,
            messages: [],
            model: 'claude-haiku-4-5',
            userProfileID: $userProfileID,
            workspaceID: $workspaceID,
        ), 'text/event-stream'];

        yield 'countTokens' => [static fn (Client $client, ?string $userProfileID, ?string $workspaceID = null) => $client->messages->countTokens(
            messages: [],
            model: 'claude-haiku-4-5',
            userProfileID: $userProfileID,
            workspaceID: $workspaceID,
        ), 'application/json'];

        $params = static fn (?string $userProfileID, ?string $workspaceID): array => [
            'maxTokens' => 1,
            'messages' => [],
            'model' => 'claude-haiku-4-5',
            ...(null === $userProfileID ? [] : ['userProfileID' => $userProfileID]),
            ...(null === $workspaceID ? [] : ['workspaceID' => $workspaceID]),
        ];

        yield 'raw create' => [static fn (Client $client, ?string $userProfileID, ?string $workspaceID = null) => $client->messages->raw->create($params($userProfileID, $workspaceID)), 'application/json'];

        yield 'raw createStream' => [static fn (Client $client, ?string $userProfileID, ?string $workspaceID = null) => $client->messages->raw->createStream($params($userProfileID, $workspaceID)), 'text/event-stream'];

        yield 'raw countTokens' => [static fn (Client $client, ?string $userProfileID, ?string $workspaceID = null) => $client->messages->raw->countTokens(
            array_diff_key($params($userProfileID, $workspaceID), ['maxTokens' => 1]),
        ), 'application/json'];
    }

    /**
     * @param \Closure(FirstPartyClient|Client): mixed $call
     */
    #[DataProvider('rawCallsWithEveryParam')]
    public function testSendsNoBodyFieldTheFirstPartyServiceKeepsOutOfTheBody(\Closure $call): void
    {
        $call(new FirstPartyClient(
            apiKey: 'test-key',
            baseUrl: 'https://api.example.test',
            requestOptions: ['transporter' => $this->transporter],
        ));
        $firstParty = $this->getLastRequestBody();

        $call($this->makeClient('application/json'));

        $this->assertSame(
            [],
            array_values(array_diff(array_keys($this->getLastRequestBody()), array_keys($firstParty))),
            'A header param reached the request body: add it to HEADER_PARAMS in Anthropic\Foundry\Services\MessagesRawService.',
        );
    }

    /**
     * @return iterable<string, array{\Closure(FirstPartyClient|Client): mixed}>
     */
    public static function rawCallsWithEveryParam(): iterable
    {
        yield 'create' => [static fn (FirstPartyClient|Client $client) => $client->messages->raw->create(self::everyParam(MessageCreateParams::class))];

        yield 'countTokens' => [static fn (FirstPartyClient|Client $client) => $client->messages->raw->countTokens(self::everyParam(MessageCountTokensParams::class))];
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

    /**
     * @param class-string $paramsClass
     *
     * @return array<string,mixed>
     */
    private static function everyParam(string $paramsClass): array
    {
        return array_fill_keys(array_map(
            static fn (\ReflectionProperty $property): string => $property->getName(),
            (new \ReflectionClass($paramsClass))->getProperties(\ReflectionProperty::IS_PUBLIC),
        ), 'x');
    }

    /**
     * @return array<mixed>
     */
    private function getLastRequestBody(): array
    {
        $body = json_decode((string) $this->getLastRequest()->getBody(), associative: true);
        $this->assertIsArray($body);

        return $body;
    }

    private function getLastRequest(): RequestInterface
    {
        $request = $this->transporter->getLastRequest();
        assert($request instanceof RequestInterface);

        return $request;
    }
}
