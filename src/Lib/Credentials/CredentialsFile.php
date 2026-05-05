<?php

declare(strict_types=1);

namespace Anthropic\Lib\Credentials;

use Anthropic\Core\Util;

final class CredentialsFile
{
    private const DEFAULT_CONFIG_DIR_PARTS = ['.config', 'anthropic'];
    private const ACTIVE_CONFIG_FILE = 'active_config';
    private const CONFIGS_DIR = 'configs';
    private const CREDENTIALS_DIR = 'credentials';

    public function __construct(
        private readonly ?string $configDir = null,
        private readonly ?string $profile = null,
    ) {}

    /**
     * Resolve credentials from the profile-based config/credentials file system.
     *
     * @return CredentialResult|null returns null if no valid profile is found
     */
    public function resolve(): ?CredentialResult
    {
        $configDir = $this->resolveConfigDir();
        $profile = $this->resolveProfile($configDir);

        if (null === $profile) {
            return null;
        }

        self::validateProfileName($profile);

        $configPath = $configDir.DIRECTORY_SEPARATOR.self::CONFIGS_DIR.DIRECTORY_SEPARATOR.$profile.'.json';
        $credentialsPath = $configDir.DIRECTORY_SEPARATOR.self::CREDENTIALS_DIR.DIRECTORY_SEPARATOR.$profile.'.json';

        $config = self::readJsonFile($configPath);
        if (null === $config) {
            return null;
        }

        $auth = $config['authentication'] ?? null;
        if (!is_array($auth)) {
            return null;
        }

        /** @var array<string,mixed> $auth */
        $baseUrl = is_string($config['base_url'] ?? null) ? $config['base_url'] : 'https://api.anthropic.com';
        $extraHeaders = [];

        $type = $auth['type'] ?? null;

        $workspaceId = $config['workspace_id'] ?? null;
        // For federation profiles workspace_id is sent in the jwt-bearer exchange body, not as a request header (the minted token is already workspace-scoped, so the header would be ignored).
        if ('oidc_federation' !== $type && is_string($workspaceId) && '' !== $workspaceId) {
            $extraHeaders['anthropic-workspace-id'] = $workspaceId;
        }

        $organizationId = $config['organization_id'] ?? null;

        switch ($type) {
            case 'oidc_federation':
                $provider = $this->buildOidcFederationProvider($auth, $organizationId, $workspaceId, $baseUrl);

                break;

            case 'user_oauth':
                $provider = $this->buildUserOAuthProvider($auth, $credentialsPath, $baseUrl);

                break;

            default:
                return null;
        }

        if (null === $provider) {
            return null;
        }

        return new CredentialResult(
            provider: new TokenCache($provider),
            extraHeaders: $extraHeaders,
        );
    }

    /**
     * @param array<string,mixed> $auth
     */
    private function buildOidcFederationProvider(
        array $auth,
        mixed $organizationId,
        mixed $workspaceId,
        string $baseUrl,
    ): ?AccessTokenProvider {
        $federationRuleId = $auth['federation_rule_id'] ?? null;
        if (!is_string($federationRuleId) || '' === $federationRuleId) {
            return null;
        }

        if (!is_string($organizationId) || '' === $organizationId) {
            return null;
        }

        $serviceAccountId = $auth['service_account_id'] ?? null;
        if (!is_string($serviceAccountId) || '' === $serviceAccountId) {
            $serviceAccountId = null;
        }

        // workspace_id lives at the top-level config (alongside base_url and
        // organization_id), not under the authentication block — it is the same
        // key used for the anthropic-workspace-id header on non-federation
        // profiles. Here it is forwarded into the jwt-bearer exchange body.
        if (!is_string($workspaceId) || '' === $workspaceId) {
            $workspaceId = null;
        }

        $identityProvider = $this->buildIdentityTokenProvider($auth);
        if (null === $identityProvider) {
            return null;
        }

        return new WorkloadIdentityCredentials(
            identityProvider: $identityProvider,
            federationRuleId: $federationRuleId,
            organizationId: $organizationId,
            serviceAccountId: $serviceAccountId,
            workspaceId: $workspaceId,
            tokenEndpointBaseUrl: $baseUrl,
        );
    }

    /**
     * @param array<string,mixed> $auth
     */
    private function buildIdentityTokenProvider(array $auth): ?IdentityTokenProvider
    {
        $identityToken = $auth['identity_token'] ?? null;
        if (!is_array($identityToken)) {
            return null;
        }

        $source = $identityToken['source'] ?? null;

        if ('file' === $source) {
            $path = $identityToken['path'] ?? null;
            if (!is_string($path) || '' === $path) {
                return null;
            }

            return new IdentityTokenFile($path);
        }

        if ('literal' === $source || 'env' === $source) {
            // For literal, the token is inline; for env, read from env var.
            if ('env' === $source) {
                $envVar = $identityToken['env_var'] ?? 'ANTHROPIC_IDENTITY_TOKEN';
                $token = Util::getenv(is_string($envVar) ? $envVar : 'ANTHROPIC_IDENTITY_TOKEN');
            } else {
                $token = $identityToken['token'] ?? null;
            }

            if (!is_string($token) || '' === $token) {
                return null;
            }

            return new IdentityTokenLiteral($token);
        }

        return null;
    }

    /**
     * @param array<string,mixed> $auth
     */
    private function buildUserOAuthProvider(
        array $auth,
        string $credentialsPath,
        string $baseUrl,
    ): ?AccessTokenProvider {
        $credentials = self::readJsonFile($credentialsPath);
        if (null === $credentials) {
            return null;
        }

        self::warnIfInsecurePermissions($credentialsPath);

        $clientId = $auth['client_id'] ?? null;

        if (is_string($clientId) && '' !== $clientId) {
            // Refresh-token based OAuth: rotate tokens via the token endpoint.
            $refreshToken = $credentials['refresh_token'] ?? null;
            if (!is_string($refreshToken) || '' === $refreshToken) {
                return null;
            }

            return new RefreshTokenProvider(
                clientId: $clientId,
                refreshToken: $refreshToken,
                credentialsFilePath: $credentialsPath,
                tokenEndpointBaseUrl: $baseUrl,
            );
        }

        // Externally rotated: re-read the credentials file on each call.
        return new ExternallyRotatedToken($credentialsPath);
    }

    private function resolveConfigDir(): string
    {
        if (null !== $this->configDir) {
            return $this->configDir;
        }

        $envDir = Util::getenv('ANTHROPIC_CONFIG_DIR');
        if (null !== $envDir && '' !== $envDir) {
            return $envDir;
        }

        $home = self::getHomeDir();

        return $home.DIRECTORY_SEPARATOR.implode(DIRECTORY_SEPARATOR, self::DEFAULT_CONFIG_DIR_PARTS);
    }

    private function resolveProfile(string $configDir): ?string
    {
        if (null !== $this->profile) {
            return $this->profile;
        }

        $envProfile = Util::getenv('ANTHROPIC_PROFILE');
        if (null !== $envProfile && '' !== $envProfile) {
            return $envProfile;
        }

        $activeConfigPath = $configDir.DIRECTORY_SEPARATOR.self::ACTIVE_CONFIG_FILE;
        $content = @file_get_contents($activeConfigPath);
        if (false === $content) {
            return null;
        }

        $profile = trim($content);

        return '' !== $profile ? $profile : null;
    }

    private static function validateProfileName(string $profile): void
    {
        if (str_contains($profile, '/') || str_contains($profile, '\\') || str_contains($profile, '..')) {
            throw new \InvalidArgumentException("Invalid profile name: {$profile}");
        }
    }

    /**
     * @return array<string,mixed>|null
     */
    private static function readJsonFile(string $path): ?array
    {
        $content = @file_get_contents($path);
        if (false === $content) {
            return null;
        }

        try {
            /** @var array<string,mixed>|scalar|null $data */
            $data = json_decode($content, associative: true, flags: JSON_THROW_ON_ERROR);

            return is_array($data) ? $data : null;
        } catch (\JsonException) {
            return null;
        }
    }

    private static function warnIfInsecurePermissions(string $path): void
    {
        if ('\\' === DIRECTORY_SEPARATOR) {
            return; // Skip on Windows.
        }

        $perms = @fileperms($path);
        if (false === $perms) {
            return;
        }

        // Warn if world or group readable (0o004 and 0o040, respectively)
        if ($perms & 0044) {
            trigger_error(
                "Credentials file {$path} is world-readable. Consider running: chmod 600 {$path}",
                E_USER_WARNING,
            );
        }
    }

    private static function getHomeDir(): string
    {
        if ('\\' === DIRECTORY_SEPARATOR) {
            $appdata = Util::getenv('APPDATA');
            if (null !== $appdata && '' !== $appdata) {
                return $appdata.DIRECTORY_SEPARATOR.'Anthropic';
            }
        }

        $home = Util::getenv('HOME') ?? ($_SERVER['HOME'] ?? null);
        if (is_string($home) && '' !== $home) {
            return $home;
        }

        throw new \RuntimeException('Unable to determine home directory');
    }
}
