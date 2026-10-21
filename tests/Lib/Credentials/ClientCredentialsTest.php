<?php

declare(strict_types=1);

namespace Tests\Lib\Credentials;

use Anthropic\Client;
use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Util;
use Anthropic\Lib\Credentials\AccessToken;
use Anthropic\Lib\Credentials\AccessTokenProvider;
use Anthropic\Lib\Credentials\CredentialResult;
use Anthropic\Lib\Credentials\StaticToken;
use Anthropic\Lib\Credentials\TokenCache;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Mock\Client as MockClient;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;

/**
 * @internal
 *
 * @coversNothing
 */
class ClientCredentialsTest extends TestCase
{
    private const ENV_KEY_AND_TOKEN_WARNING = 'Anthropic: ANTHROPIC_API_KEY and ANTHROPIC_AUTH_TOKEN are both set. Using ANTHROPIC_API_KEY.';

    private MockClient $transporter;

    /** @var array<string,string|false> */
    private array $savedEnv = [];

    private ?string $configDir = null;

    private bool $savedWarnedOfEnvKeyAndToken;

    protected function setUp(): void
    {
        $this->transporter = new MockClient;

        $warned = new \ReflectionProperty(Client::class, 'warnedOfEnvKeyAndToken');
        $this->savedWarnedOfEnvKeyAndToken = (bool) $warned->getValue();
        $warned->setValue(null, false);

        $mockRsp = Psr17FactoryDiscovery::findResponseFactory()
            ->createResponse()
            ->withStatus(200)
            ->withHeader('Content-Type', 'application/json')
            ->withBody(Psr17FactoryDiscovery::findStreamFactory()->createStream(json_encode([], flags: Util::JSON_ENCODE_FLAGS) ?: ''))
        ;

        $this->transporter->setDefaultResponse($mockRsp);

        // Save and clear relevant env vars.
        foreach (['ANTHROPIC_API_KEY', 'ANTHROPIC_AUTH_TOKEN', 'ANTHROPIC_BASE_URL', 'ANTHROPIC_CONFIG_DIR', 'ANTHROPIC_PROFILE', 'ANTHROPIC_FEDERATION_RULE_ID', 'ANTHROPIC_ORGANIZATION_ID', 'ANTHROPIC_IDENTITY_TOKEN'] as $var) {
            $this->savedEnv[$var] = getenv($var);
            putenv($var);
        }
    }

    protected function tearDown(): void
    {
        (new \ReflectionProperty(Client::class, 'warnedOfEnvKeyAndToken'))->setValue(null, $this->savedWarnedOfEnvKeyAndToken);

        foreach ($this->savedEnv as $var => $value) {
            if (false === $value) {
                putenv($var);
            } else {
                putenv("{$var}={$value}");
            }
        }

        if (null !== $this->configDir) {
            foreach ([...glob($this->configDir.'/*/*') ?: [], ...glob($this->configDir.'/active_config') ?: []] as $file) {
                @unlink($file);
            }
            @rmdir($this->configDir.'/configs');
            @rmdir($this->configDir.'/credentials');
            @rmdir($this->configDir);
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

    public function testPerRequestWorkspaceIDOverridesCredentialHeader(): void
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

        $client->messages->create(1024, [], 'claude-haiku-4-5', workspaceID: 'wrkspc_02override');
        $request = $this->getLastRequest();

        $this->assertSame(['wrkspc_02override'], $request->getHeader('anthropic-workspace-id'));
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

        $this->assertSame('Bearer sk-ant-test-key', $request->getHeaderLine('Authorization'));
        $this->assertSame('', $request->getHeaderLine('x-api-key'));
    }

    /**
     * @param list<string> $env
     * @param array{apiKey?: string, authToken?: string, credentials?: CredentialResult} $args
     * @param list<string> $expected
     * @param list<string> $expectedWarnings
     */
    #[DataProvider('credentialPrecedenceProvider')]
    public function testCredentialPrecedence(array $env, array $args, array $expected, array $expectedWarnings = []): void
    {
        $this->writeProfile('active', 'active-profile-token');
        $this->writeProfile('named', 'named-profile-token');
        file_put_contents($this->configDir.'/active_config', 'active');
        array_map(putenv(...), $env);

        $warnings = $this->captureErrorLog(function () use ($args): void {
            $client = new Client(...$args, requestOptions: ['transporter' => $this->transporter]);
            $client->messages->create(1024, [], 'claude-haiku-4-5');
        });

        $this->assertSame($expected, $this->getLastRequest()->getHeader('Authorization'));
        $this->assertSame($expectedWarnings, $warnings);
    }

    /** @return iterable<string,array{0: list<string>, 1: array{apiKey?: string, authToken?: string, credentials?: CredentialResult}, 2: list<string>, 3?: list<string>}> */
    public static function credentialPrecedenceProvider(): iterable
    {
        $key = 'ANTHROPIC_API_KEY=env-key';
        $token = 'ANTHROPIC_AUTH_TOKEN=env-token';
        $profile = 'ANTHROPIC_PROFILE=named';

        yield 'the env key comes first' => [[$key, $token, $profile], [], ['Bearer env-key'], [self::ENV_KEY_AND_TOKEN_WARNING]];

        yield 'the env key alone' => [[$key, $profile], [], ['Bearer env-key']];

        yield 'the env key with an empty env token' => [[$key, 'ANTHROPIC_AUTH_TOKEN='], [], ['Bearer env-key']];

        yield 'then the env token' => [[$token, $profile], [], ['Bearer env-token']];

        yield 'the env token with an empty env key' => [['ANTHROPIC_API_KEY=', $token], [], ['Bearer env-token']];

        yield 'then the env profile' => [
            [$profile, 'ANTHROPIC_FEDERATION_RULE_ID=fdrl_01test', 'ANTHROPIC_ORGANIZATION_ID=org-uuid-test', 'ANTHROPIC_IDENTITY_TOKEN=jwt'],
            [],
            ['Bearer named-profile-token'],
        ];

        yield 'the active profile when nothing else is set' => [[], [], ['Bearer active-profile-token']];

        yield 'a passed key ignores the environment' => [[$key, $token, $profile], ['apiKey' => 'key'], ['Bearer key']];

        yield 'a passed token ignores the environment' => [[$key, $token, $profile], ['authToken' => 'token'], ['Bearer token']];

        yield 'passed credentials ignore the environment' => [
            [$key, $token, $profile],
            ['credentials' => new CredentialResult(new StaticToken('provider-token'))],
            ['Bearer provider-token'],
        ];

        yield 'an empty key ignores the env token' => [[$token], ['apiKey' => ''], []];

        yield 'an empty token ignores the profiles' => [[$profile], ['authToken' => ''], []];
    }

    public function testEnvKeyDropsEnvTokenAndWarnsOncePerProcess(): void
    {
        putenv('ANTHROPIC_API_KEY=env-key');
        putenv('ANTHROPIC_AUTH_TOKEN=env-token');

        $clients = [];
        $warnings = $this->captureErrorLog(function () use (&$clients): void {
            $clients[] = new Client(requestOptions: ['transporter' => $this->transporter]);
            $clients[] = new Client(requestOptions: ['transporter' => $this->transporter]);
        });

        $this->assertSame(['env-key', 'env-key'], array_column($clients, 'apiKey'));
        $this->assertSame(['', ''], array_column($clients, 'authToken'));
        $this->assertSame([self::ENV_KEY_AND_TOKEN_WARNING], $warnings);
    }

    public function testEnvKeyInTheEnvSuperglobalComesBeforeTheEnvToken(): void
    {
        $_ENV['ANTHROPIC_API_KEY'] = 'superglobal-key';
        putenv('ANTHROPIC_AUTH_TOKEN=env-token');

        try {
            $warnings = $this->captureErrorLog(function (): void {
                $client = new Client(requestOptions: ['transporter' => $this->transporter]);
                $client->messages->create(1024, [], 'claude-haiku-4-5');
            });
        } finally {
            unset($_ENV['ANTHROPIC_API_KEY']);
        }

        $this->assertSame(['Bearer superglobal-key'], $this->getLastRequest()->getHeader('Authorization'));
        $this->assertSame([self::ENV_KEY_AND_TOKEN_WARNING], $warnings);
    }

    public function testMissingEnvProfileThrows(): void
    {
        $this->writeProfile('active', 'active-profile-token');
        file_put_contents($this->configDir.'/active_config', 'active');
        putenv('ANTHROPIC_PROFILE=missing');

        $this->expectException(AnthropicException::class);
        $this->expectExceptionMessage('ANTHROPIC_PROFILE names the profile `missing`, which is missing or invalid.');

        new Client(requestOptions: ['transporter' => $this->transporter]);
    }

    public function testSubclassReadsNoProfile(): void
    {
        $this->writeProfile('named', 'named-profile-token');
        putenv('ANTHROPIC_PROFILE=named');

        $client = new class(requestOptions: ['transporter' => $this->transporter]) extends Client {};
        $client->messages->create(1024, [], 'claude-haiku-4-5');

        $this->assertFalse($this->getLastRequest()->hasHeader('Authorization'));
    }

    /** @param array{apiKey?: string, authToken?: string, credentials?: CredentialResult} $args */
    #[DataProvider('twoCredentialsProvider')]
    public function testTwoCredentialsAreRejected(array $args, string $received): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Pass at most one of `apiKey`, `authToken`, or `credentials`. Received {$received}.");

        new Client(...$args, requestOptions: ['transporter' => $this->transporter]);
    }

    /** @return iterable<string,array{array{apiKey?: string, authToken?: string, credentials?: CredentialResult},string}> */
    public static function twoCredentialsProvider(): iterable
    {
        $credentials = new CredentialResult(new StaticToken('provider-token'));

        yield 'key and token' => [['apiKey' => 'key', 'authToken' => 'token'], '`apiKey`, `authToken`'];

        yield 'key and credentials' => [['apiKey' => 'key', 'credentials' => $credentials], '`apiKey`, `credentials`'];

        yield 'token and credentials' => [['authToken' => 'token', 'credentials' => $credentials], '`authToken`, `credentials`'];

        yield 'all three' => [
            ['apiKey' => 'key', 'authToken' => 'token', 'credentials' => $credentials],
            '`apiKey`, `authToken`, `credentials`',
        ];

        yield 'empty strings' => [['apiKey' => '', 'authToken' => ''], '`apiKey`, `authToken`'];
    }

    public function testProfileBaseUrlUsedWhenNoExplicitBaseUrl(): void
    {
        $this->writeProfile('staging', 'tok_profile', baseUrl: 'https://profile.example.com');
        putenv('ANTHROPIC_PROFILE=staging');

        $client = new Client(requestOptions: ['transporter' => $this->transporter]);

        $this->assertSame('profile.example.com', $this->requestHost($client));
        $this->assertSame('Bearer tok_profile', $this->getLastRequest()->getHeaderLine('Authorization'));
    }

    public function testEnvBaseUrlTakesPrecedenceOverProfileBaseUrl(): void
    {
        putenv('ANTHROPIC_BASE_URL=https://env.example.com');

        $client = new Client(
            requestOptions: ['transporter' => $this->transporter],
            credentials: $this->makeCredentials('tok', baseUrl: 'https://profile.example.com'),
        );

        $this->assertSame('env.example.com', $this->requestHost($client));
    }

    public function testExplicitBaseUrlTakesPrecedenceOverEnvAndProfileBaseUrl(): void
    {
        putenv('ANTHROPIC_BASE_URL=https://env.example.com');

        $client = new Client(
            baseUrl: 'https://explicit.example.com',
            requestOptions: ['transporter' => $this->transporter],
            credentials: $this->makeCredentials('tok', baseUrl: 'https://profile.example.com'),
        );

        $this->assertSame('explicit.example.com', $this->requestHost($client));
    }

    public function testDefaultBaseUrlWhenProfileHasNone(): void
    {
        $client = new Client(
            requestOptions: ['transporter' => $this->transporter],
            credentials: $this->makeCredentials('tok'),
        );

        $this->assertSame('api.anthropic.com', $this->requestHost($client));
    }

    /** @return list<string> */
    private function captureErrorLog(\Closure $run): array
    {
        $log = tempnam(sys_get_temp_dir(), 'anthropic_client_cred_test_');
        $this->assertIsString($log);
        $previous = ini_set('error_log', $log);

        try {
            $run();
        } finally {
            ini_set('error_log', false === $previous ? '' : $previous);
            $lines = file($log, FILE_IGNORE_NEW_LINES) ?: [];
            @unlink($log);
        }

        return array_map(static fn (string $line): string => preg_replace('/^\[[^]]*] /', '', $line) ?? $line, $lines);
    }

    private function writeProfile(string $name, string $accessToken, ?string $baseUrl = null): void
    {
        if (null === $this->configDir) {
            $this->configDir = sys_get_temp_dir().'/anthropic_client_cred_test_'.uniqid();
            mkdir($this->configDir.'/configs', 0700, true);
            mkdir($this->configDir.'/credentials', 0700, true);
            putenv("ANTHROPIC_CONFIG_DIR={$this->configDir}");
        }

        file_put_contents($this->configDir."/configs/{$name}.json", json_encode([
            'base_url' => $baseUrl,
            'authentication' => ['type' => 'user_oauth'],
        ]));
        file_put_contents($this->configDir."/credentials/{$name}.json", json_encode(['access_token' => $accessToken]));
        chmod($this->configDir."/credentials/{$name}.json", 0600);
    }

    private function makeCredentials(string $token, ?string $baseUrl = null): CredentialResult
    {
        $inner = new class($token) implements AccessTokenProvider {
            public function __construct(private readonly string $token) {}

            public function fetchToken(): AccessToken
            {
                return new AccessToken($this->token, time() + 3600);
            }
        };

        return new CredentialResult(provider: new TokenCache($inner), baseUrl: $baseUrl);
    }

    private function requestHost(Client $client): string
    {
        $client->messages->create(1024, [], 'claude-haiku-4-5');

        return $this->getLastRequest()->getUri()->getHost();
    }

    private function getLastRequest(): RequestInterface
    {
        $request = $this->transporter->getLastRequest();
        assert($request instanceof RequestInterface);

        return $request;
    }
}
