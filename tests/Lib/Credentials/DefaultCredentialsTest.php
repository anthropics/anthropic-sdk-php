<?php

declare(strict_types=1);

namespace Tests\Lib\Credentials;

use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Lib\Credentials\DefaultCredentials;
use Anthropic\Lib\Credentials\TokenCache;
use Anthropic\Lib\Credentials\WorkloadIdentityCredentials;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversNothing
 */
class DefaultCredentialsTest extends TestCase
{
    private const ENV_VARS = [
        'ANTHROPIC_API_KEY',
        'ANTHROPIC_AUTH_TOKEN',
        'ANTHROPIC_PROFILE',
        'ANTHROPIC_CONFIG_DIR',
        'ANTHROPIC_IDENTITY_TOKEN_FILE',
        'ANTHROPIC_IDENTITY_TOKEN',
        'ANTHROPIC_FEDERATION_RULE_ID',
        'ANTHROPIC_ORGANIZATION_ID',
        'ANTHROPIC_SERVICE_ACCOUNT_ID',
        'ANTHROPIC_WORKSPACE_ID',
    ];

    private const FEDERATION_ENV = [
        'ANTHROPIC_FEDERATION_RULE_ID=fdrl_01test',
        'ANTHROPIC_ORGANIZATION_ID=org-uuid-test',
        'ANTHROPIC_IDENTITY_TOKEN=literal-jwt-here',
    ];

    /** @var array<string,string|false> */
    private array $savedEnv = [];

    private mixed $savedHome;

    private ?string $home = null;

    protected function setUp(): void
    {
        $this->savedHome = $_ENV['HOME'] ?? null;

        foreach (self::ENV_VARS as $var) {
            $this->savedEnv[$var] = getenv($var);
            putenv($var);
        }
        // Point config dir at a non-existent path to avoid picking up
        // real credentials from ~/.config/anthropic/ on the test machine.
        putenv('ANTHROPIC_CONFIG_DIR=/tmp/anthropic_test_nonexistent_'.uniqid());
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

        if (null === $this->savedHome) {
            unset($_ENV['HOME']);
        } else {
            $_ENV['HOME'] = $this->savedHome;
        }

        if (null !== $this->home) {
            $configDir = $this->home.'/.config/anthropic';
            foreach ([...glob($configDir.'/*/*') ?: [], ...glob($configDir.'/active_config') ?: []] as $file) {
                @unlink($file);
            }
            foreach (['/.config/anthropic/configs', '/.config/anthropic/credentials', '/.config/anthropic', '/.config', ''] as $dir) {
                @rmdir($this->home.$dir);
            }
        }
    }

    public function testReturnsNullWhenApiKeySet(): void
    {
        putenv('ANTHROPIC_API_KEY=sk-ant-test');

        $result = DefaultCredentials::resolve();

        $this->assertNull($result);
    }

    public function testReturnsEnvTokenForAuthToken(): void
    {
        putenv('ANTHROPIC_AUTH_TOKEN=my-bearer-token');

        $result = DefaultCredentials::resolve();

        $this->assertNotNull($result);
        $this->assertInstanceOf(TokenCache::class, $result->provider);

        $token = $result->provider->fetchToken();
        $this->assertSame('my-bearer-token', $token->token);
    }

    public function testReturnsNullWhenNothingConfigured(): void
    {
        $result = DefaultCredentials::resolve();

        $this->assertNull($result);
    }

    public function testApiKeyTakesPrecedenceOverAuthToken(): void
    {
        putenv('ANTHROPIC_API_KEY=sk-ant-key');
        putenv('ANTHROPIC_AUTH_TOKEN=my-bearer');

        $result = DefaultCredentials::resolve();

        $this->assertNull($result, 'resolve() should return null when ANTHROPIC_API_KEY is set');
    }

    public function testWorkloadIdentityFromEnvVarsWithTokenFile(): void
    {
        $tmpFile = tempnam(sys_get_temp_dir(), 'jwt_');
        file_put_contents($tmpFile, 'test-oidc-jwt');

        try {
            putenv('ANTHROPIC_IDENTITY_TOKEN_FILE='.$tmpFile);
            putenv('ANTHROPIC_FEDERATION_RULE_ID=fdrl_01test');
            putenv('ANTHROPIC_ORGANIZATION_ID=org-uuid-test');

            $result = DefaultCredentials::resolve();

            $this->assertNotNull($result);
            $this->assertInstanceOf(TokenCache::class, $result->provider);
        } finally {
            @unlink($tmpFile);
        }
    }

    public function testWorkloadIdentityFromEnvVarsWithLiteralToken(): void
    {
        putenv('ANTHROPIC_IDENTITY_TOKEN=literal-jwt-here');
        putenv('ANTHROPIC_FEDERATION_RULE_ID=fdrl_01test');
        putenv('ANTHROPIC_ORGANIZATION_ID=org-uuid-test');

        $result = DefaultCredentials::resolve();

        $this->assertNotNull($result);
        $this->assertInstanceOf(TokenCache::class, $result->provider);
    }

    public function testWorkloadIdentityWorkspaceIdEnv(): void
    {
        putenv('ANTHROPIC_IDENTITY_TOKEN=literal-jwt-here');
        putenv('ANTHROPIC_FEDERATION_RULE_ID=fdrl_01test');
        putenv('ANTHROPIC_ORGANIZATION_ID=org-uuid-test');
        putenv('ANTHROPIC_WORKSPACE_ID=wrkspc_01abc');

        $result = DefaultCredentials::resolve();

        $this->assertNotNull($result);
        $this->assertInstanceOf(TokenCache::class, $result->provider);

        $inner = (new \ReflectionProperty(TokenCache::class, 'inner'))->getValue($result->provider);
        $this->assertInstanceOf(WorkloadIdentityCredentials::class, $inner);
        $this->assertSame(
            'wrkspc_01abc',
            (new \ReflectionProperty(WorkloadIdentityCredentials::class, 'workspaceId'))->getValue($inner),
        );
    }

    public function testWorkloadIdentityWorkspaceIdEnvEmptyTreatedUnset(): void
    {
        // ANTHROPIC_WORKSPACE_ID="" (a defaulted-but-empty CI variable) is
        // treated as unset — never put `"workspace_id": ""` on the wire.
        putenv('ANTHROPIC_IDENTITY_TOKEN=literal-jwt-here');
        putenv('ANTHROPIC_FEDERATION_RULE_ID=fdrl_01test');
        putenv('ANTHROPIC_ORGANIZATION_ID=org-uuid-test');
        putenv('ANTHROPIC_WORKSPACE_ID=');

        $result = DefaultCredentials::resolve();

        $this->assertNotNull($result);
        $this->assertInstanceOf(TokenCache::class, $result->provider);

        $inner = (new \ReflectionProperty(TokenCache::class, 'inner'))->getValue($result->provider);
        $this->assertInstanceOf(WorkloadIdentityCredentials::class, $inner);
        $this->assertNull(
            (new \ReflectionProperty(WorkloadIdentityCredentials::class, 'workspaceId'))->getValue($inner),
        );
    }

    public function testWorkloadIdentityRequiresAllEnvVars(): void
    {
        // Missing ANTHROPIC_ORGANIZATION_ID.
        putenv('ANTHROPIC_IDENTITY_TOKEN=jwt');
        putenv('ANTHROPIC_FEDERATION_RULE_ID=fdrl_01test');

        $result = DefaultCredentials::resolve();

        $this->assertNull($result);
    }

    public function testWorkloadIdentityRequiresIdentityToken(): void
    {
        // No identity token source configured.
        putenv('ANTHROPIC_FEDERATION_RULE_ID=fdrl_01test');
        putenv('ANTHROPIC_ORGANIZATION_ID=org-uuid');

        $result = DefaultCredentials::resolve();

        $this->assertNull($result);
    }

    #[DataProvider('activeProfileProvider')]
    public function testFederationComesBeforeTheActiveProfile(bool $configDirInEnv, ?string $activeConfig): void
    {
        $this->writeProfiles($configDirInEnv, ['default', 'active'], $activeConfig);
        array_map(putenv(...), self::FEDERATION_ENV);

        $result = DefaultCredentials::resolve();

        $this->assertNotNull($result);
        $this->assertInstanceOf(TokenCache::class, $result->provider);
        $this->assertInstanceOf(
            WorkloadIdentityCredentials::class,
            (new \ReflectionProperty(TokenCache::class, 'inner'))->getValue($result->provider),
        );
    }

    /** @return iterable<string,array{bool,string|null}> */
    public static function activeProfileProvider(): iterable
    {
        yield 'a leftover default profile' => [false, null];

        yield 'named by active_config' => [false, 'active'];

        yield 'named by active_config in the env config dir' => [true, 'active'];

        yield 'one that fails to load from the env config dir' => [true, '../active'];
    }

    /** @param list<string> $env */
    #[DataProvider('profileProvider')]
    public function testProfileIsUsed(array $env, string $expectedToken): void
    {
        $this->writeProfiles(false, ['active', 'named'], 'active');
        array_map(putenv(...), $env);

        $result = DefaultCredentials::resolve();

        $this->assertNotNull($result);
        $this->assertSame($expectedToken, $result->provider->fetchToken()->token);
    }

    /** @return iterable<string,array{list<string>,string}> */
    public static function profileProvider(): iterable
    {
        yield 'the env profile before federation' => [['ANTHROPIC_PROFILE=named', ...self::FEDERATION_ENV], 'named-profile-token'];

        yield 'the active profile without federation' => [[], 'active-profile-token'];

        yield 'the active profile with an empty env profile' => [['ANTHROPIC_PROFILE='], 'active-profile-token'];
    }

    public function testDefaultProfileIsUsedWithoutActiveConfig(): void
    {
        $this->writeProfiles(false, ['default'], null);

        $result = DefaultCredentials::resolve();

        $this->assertNotNull($result);
        $this->assertSame('default-profile-token', $result->provider->fetchToken()->token);
    }

    /** @param list<string> $env */
    #[DataProvider('unusableNamedProfileProvider')]
    public function testUnusableNamedProfileThrows(array $env, string $profile): void
    {
        $configDir = $this->writeProfiles(true, ['active'], 'active');
        file_put_contents($configDir.'/configs/broken.json', '{');
        putenv("ANTHROPIC_PROFILE={$profile}");
        array_map(putenv(...), $env);

        $this->expectException(AnthropicException::class);
        $this->expectExceptionMessage("ANTHROPIC_PROFILE names the profile `{$profile}`, which is missing or invalid.");

        DefaultCredentials::resolve();
    }

    /** @return iterable<string,array{list<string>,string}> */
    public static function unusableNamedProfileProvider(): iterable
    {
        yield 'missing' => [[], 'missing'];

        yield 'missing, with federation' => [self::FEDERATION_ENV, 'missing'];

        yield 'broken' => [[], 'broken'];
    }

    public function testActiveProfileErrorPropagatesWithConfigDir(): void
    {
        $this->writeProfiles(true, ['active'], '../active');

        $this->expectException(\InvalidArgumentException::class);

        DefaultCredentials::resolve();
    }

    public function testActiveProfileErrorIsSwallowedWithoutConfigDir(): void
    {
        $this->writeProfiles(false, ['active'], '../active');

        $this->assertNull(DefaultCredentials::resolve());
    }

    /** @param list<string> $names */
    private function writeProfiles(bool $configDirInEnv, array $names, ?string $activeConfig): string
    {
        $this->home = sys_get_temp_dir().'/anthropic_default_cred_test_'.uniqid();
        $configDir = $this->home.'/.config/anthropic';
        mkdir($configDir.'/configs', 0700, true);
        mkdir($configDir.'/credentials', 0700, true);

        if ($configDirInEnv) {
            putenv("ANTHROPIC_CONFIG_DIR={$configDir}");
        } else {
            putenv('ANTHROPIC_CONFIG_DIR');
            $_ENV['HOME'] = $this->home;
        }

        foreach ($names as $name) {
            file_put_contents($configDir."/configs/{$name}.json", json_encode(['authentication' => ['type' => 'user_oauth']]));
            file_put_contents($configDir."/credentials/{$name}.json", json_encode(['access_token' => "{$name}-profile-token"]));
            chmod($configDir."/credentials/{$name}.json", 0600);
        }

        if (null !== $activeConfig) {
            file_put_contents($configDir.'/active_config', $activeConfig);
        }

        return $configDir;
    }
}
