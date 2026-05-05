<?php

declare(strict_types=1);

namespace Tests\Lib\Credentials;

use Anthropic\Lib\Credentials\DefaultCredentials;
use Anthropic\Lib\Credentials\TokenCache;
use Anthropic\Lib\Credentials\WorkloadIdentityCredentials;
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

    /** @var array<string,string|false> */
    private array $savedEnv = [];

    protected function setUp(): void
    {
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

        $this->assertNull($result, 'API key should win, returning null so the X-Api-Key path is used');
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
}
