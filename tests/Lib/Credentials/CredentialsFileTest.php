<?php

declare(strict_types=1);

namespace Tests\Lib\Credentials;

use Anthropic\Lib\Credentials\CredentialsFile;
use Anthropic\Lib\Credentials\ExternallyRotatedToken;
use Anthropic\Lib\Credentials\TokenCache;
use Anthropic\Lib\Credentials\WorkloadIdentityCredentials;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversNothing
 */
class CredentialsFileTest extends TestCase
{
    private string $configDir;

    protected function setUp(): void
    {
        $this->configDir = sys_get_temp_dir().DIRECTORY_SEPARATOR.'anthropic_cf_test_'.uniqid();
        mkdir($this->configDir.DIRECTORY_SEPARATOR.'configs', 0700, true);
        mkdir($this->configDir.DIRECTORY_SEPARATOR.'credentials', 0700, true);
    }

    protected function tearDown(): void
    {
        foreach (['configs', 'credentials'] as $sub) {
            $dir = $this->configDir.DIRECTORY_SEPARATOR.$sub;
            foreach (glob($dir.DIRECTORY_SEPARATOR.'*') ?: [] as $file) {
                @unlink($file);
            }
            @rmdir($dir);
        }
        @rmdir($this->configDir);
    }

    public function testOidcFederationProfilePropagatesWorkspaceId(): void
    {
        $this->writeProfile('test-profile', [
            'base_url' => 'https://api.anthropic.com',
            'organization_id' => 'org_x',
            'workspace_id' => 'wrkspc_x',
            'authentication' => [
                'type' => 'oidc_federation',
                'federation_rule_id' => 'fdrl_x',
                'service_account_id' => 'svac_x',
                'identity_token' => ['source' => 'literal', 'token' => 'jwt'],
            ],
        ]);

        $result = (new CredentialsFile(configDir: $this->configDir, profile: 'test-profile'))->resolve();

        $this->assertNotNull($result);
        $this->assertInstanceOf(TokenCache::class, $result->provider);

        $inner = (new \ReflectionProperty(TokenCache::class, 'inner'))->getValue($result->provider);
        $this->assertInstanceOf(WorkloadIdentityCredentials::class, $inner);
        $this->assertSame(
            'wrkspc_x',
            (new \ReflectionProperty(WorkloadIdentityCredentials::class, 'workspaceId'))->getValue($inner),
        );

        // Federation profiles must NOT emit the anthropic-workspace-id header:
        // workspace_id is sent in the jwt-bearer exchange body and the minted
        // token is already workspace-scoped.
        $this->assertArrayNotHasKey('anthropic-workspace-id', $result->extraHeaders);
    }

    public function testNonFederationProfileEmitsWorkspaceIdHeader(): void
    {
        $this->writeProfile('test-profile', [
            'base_url' => 'https://api.anthropic.com',
            'workspace_id' => 'wrkspc_x',
            'authentication' => ['type' => 'user_oauth'],
        ]);
        $this->writeCredentials('test-profile', ['access_token' => 'tok']);

        $result = (new CredentialsFile(configDir: $this->configDir, profile: 'test-profile'))->resolve();

        $this->assertNotNull($result);
        $this->assertInstanceOf(TokenCache::class, $result->provider);

        $inner = (new \ReflectionProperty(TokenCache::class, 'inner'))->getValue($result->provider);
        $this->assertInstanceOf(ExternallyRotatedToken::class, $inner);

        // Non-federation profiles still send workspace_id as a request header.
        $this->assertArrayHasKey('anthropic-workspace-id', $result->extraHeaders);
        $this->assertSame('wrkspc_x', $result->extraHeaders['anthropic-workspace-id']);
    }

    public function testOidcFederationProfileWithoutWorkspaceId(): void
    {
        $this->writeProfile('test-profile', [
            'organization_id' => 'org_x',
            'authentication' => [
                'type' => 'oidc_federation',
                'federation_rule_id' => 'fdrl_x',
                'identity_token' => ['source' => 'literal', 'token' => 'jwt'],
            ],
        ]);

        $result = (new CredentialsFile(configDir: $this->configDir, profile: 'test-profile'))->resolve();

        $this->assertNotNull($result);

        $inner = (new \ReflectionProperty(TokenCache::class, 'inner'))->getValue($result->provider);
        $this->assertInstanceOf(WorkloadIdentityCredentials::class, $inner);
        $this->assertNull(
            (new \ReflectionProperty(WorkloadIdentityCredentials::class, 'workspaceId'))->getValue($inner),
        );
    }

    /**
     * @param array<string,mixed> $config
     */
    private function writeProfile(string $name, array $config): void
    {
        $path = $this->configDir.DIRECTORY_SEPARATOR.'configs'.DIRECTORY_SEPARATOR.$name.'.json';
        file_put_contents($path, json_encode($config, JSON_THROW_ON_ERROR));
    }

    /**
     * @param array<string,mixed> $credentials
     */
    private function writeCredentials(string $name, array $credentials): void
    {
        $path = $this->configDir.DIRECTORY_SEPARATOR.'credentials'.DIRECTORY_SEPARATOR.$name.'.json';
        file_put_contents($path, json_encode($credentials, JSON_THROW_ON_ERROR));
        @chmod($path, 0600);
    }
}
