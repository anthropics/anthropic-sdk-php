<?php

declare(strict_types=1);

namespace Tests\Lib\Credentials;

use Anthropic\Client;
use Anthropic\Core\Util;
use Anthropic\Lib\Credentials\AccessToken;
use Anthropic\Lib\Credentials\AccessTokenProvider;
use Anthropic\Lib\Credentials\CredentialResult;
use Anthropic\Lib\Credentials\TokenCache;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Mock\Client as MockClient;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;

/**
 * @internal
 *
 * @coversNothing
 */
class ClientCredentialsTest extends TestCase
{
    private MockClient $transporter;

    /** @var array<string,string|false> */
    private array $savedEnv = [];

    protected function setUp(): void
    {
        $this->transporter = new MockClient;

        $mockRsp = Psr17FactoryDiscovery::findResponseFactory()
            ->createResponse()
            ->withStatus(200)
            ->withHeader('Content-Type', 'application/json')
            ->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream(json_encode([], flags: Util::JSON_ENCODE_FLAGS) ?: ''))
        ;

        $this->transporter->setDefaultResponse($mockRsp);

        // Save and clear relevant env vars.
        foreach (['ANTHROPIC_API_KEY', 'ANTHROPIC_AUTH_TOKEN'] as $var) {
            $this->savedEnv[$var] = getenv($var);
            putenv($var);
        }
    }

    protected function tearDown(): void
    {
        foreach ($this->savedEnv as $var => $value) {
            if (false === $value) {
                putenv($var);
            } else {
                putenv("{$var}={$value}");
            }
        }
    }

    public function testCredentialsInjectBearerHeader(): void
    {
        $credentials = $this->makeCredentials('my-oauth-token');

        $client = new Client(
            requestOptions: ['transporter' => $this->transporter],
            credentials: $credentials,
        );

        $client->messages->create(1024, [], 'claude-haiku-4-5');
        $request = $this->getLastRequest();

        $this->assertSame('Bearer my-oauth-token', $request->getHeaderLine('Authorization'));
    }

    public function testOAuthBetaHeaderAppended(): void
    {
        $credentials = $this->makeCredentials('tok');

        $client = new Client(
            requestOptions: ['transporter' => $this->transporter],
            credentials: $credentials,
        );

        $client->messages->create(1024, [], 'claude-haiku-4-5');
        $request = $this->getLastRequest();

        $betaHeader = $request->getHeaderLine('anthropic-beta');
        $this->assertStringContainsString('oauth-2025-04-20', $betaHeader);
    }

    public function testOAuthBetaHeaderMergedWithExistingBetas(): void
    {
        $credentials = $this->makeCredentials('tok');

        $client = new Client(
            requestOptions: ['transporter' => $this->transporter],
            credentials: $credentials,
        );

        // Use the beta service which sets its own anthropic-beta header.
        $client->beta->messages->create(
            maxTokens: 1024,
            messages: [['role' => 'user', 'content' => 'hi']],
            model: 'claude-haiku-4-5',
        );
        $request = $this->getLastRequest();

        $betaHeader = $request->getHeaderLine('anthropic-beta');
        $this->assertStringContainsString('oauth-2025-04-20', $betaHeader);
    }

    public function testExtraHeadersFromCredentialResult(): void
    {
        $inner = new class() implements AccessTokenProvider {
            public function fetchToken(): AccessToken
            {
                return new AccessToken('tok');
            }
        };

        $credentials = new CredentialResult(
            provider: new TokenCache($inner),
            extraHeaders: ['anthropic-workspace-id' => 'wrkspc_01test'],
        );

        $client = new Client(
            requestOptions: ['transporter' => $this->transporter],
            credentials: $credentials,
        );

        $client->messages->create(1024, [], 'claude-haiku-4-5');
        $request = $this->getLastRequest();

        $this->assertSame('wrkspc_01test', $request->getHeaderLine('anthropic-workspace-id'));
    }

    public function test401TriggersTokenRefresh(): void
    {
        $callCount = 0;
        $inner = new class($callCount) implements AccessTokenProvider {
            public function __construct(private int &$callCount) {}

            public function fetchToken(): AccessToken
            {
                ++$this->callCount;

                return new AccessToken('tok_v'.$this->callCount, time() + 3600);
            }
        };

        $credentials = new CredentialResult(provider: new TokenCache($inner));

        // First response is 401, second is 200.
        $response401 = Psr17FactoryDiscovery::findResponseFactory()
            ->createResponse()
            ->withStatus(401)
            ->withHeader('Content-Type', 'application/json')
            ->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream('{"error":"unauthorized"}'))
        ;

        $response200 = Psr17FactoryDiscovery::findResponseFactory()
            ->createResponse()
            ->withStatus(200)
            ->withHeader('Content-Type', 'application/json')
            ->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream(json_encode([], flags: Util::JSON_ENCODE_FLAGS) ?: ''))
        ;

        $this->transporter->addResponse($response401);
        $this->transporter->addResponse($response200);

        $client = new Client(
            requestOptions: ['transporter' => $this->transporter],
            credentials: $credentials,
        );

        $client->messages->create(1024, [], 'claude-haiku-4-5');

        // Token should have been fetched twice: once initially, once after 401 invalidation.
        $this->assertSame(2, $callCount);
    }

    public function testNoCredentialsUsesApiKey(): void
    {
        putenv('ANTHROPIC_API_KEY=sk-ant-test-key');

        $client = new Client(
            requestOptions: ['transporter' => $this->transporter],
        );

        $client->messages->create(1024, [], 'claude-haiku-4-5');
        $request = $this->getLastRequest();

        $this->assertSame('sk-ant-test-key', $request->getHeaderLine('x-api-key'));
        $this->assertSame('', $request->getHeaderLine('Authorization'));
    }

    private function makeCredentials(string $token): CredentialResult
    {
        $inner = new class($token) implements AccessTokenProvider {
            public function __construct(private readonly string $token) {}

            public function fetchToken(): AccessToken
            {
                return new AccessToken($this->token, time() + 3600);
            }
        };

        return new CredentialResult(provider: new TokenCache($inner));
    }

    private function getLastRequest(): RequestInterface
    {
        $request = $this->transporter->getLastRequest();
        assert($request instanceof RequestInterface);

        return $request;
    }
}
