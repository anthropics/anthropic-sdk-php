<?php

declare(strict_types=1);

namespace Anthropic\Lib\Credentials;

use Anthropic\Core\Exceptions\AnthropicException;
use Anthropic\Core\Util;

final class DefaultCredentials
{
    /**
     * Resolve credentials by precedence. Returns null when the existing
     * API key path should be used, or when no credentials source is found.
     *
     * Resolution order:
     *  1. ANTHROPIC_API_KEY set            → null (use existing path)
     *  2. ANTHROPIC_AUTH_TOKEN set          → EnvToken
     *  3. ANTHROPIC_PROFILE set             → CredentialsFile for that profile
     *  4. OIDC env vars all set             → WorkloadIdentityCredentials
     *  5. Active profile on disk            → CredentialsFile (named by active_config, otherwise `default`)
     *  6. Nothing                           → null
     *
     * ANTHROPIC_CONFIG_DIR says where profiles are read from. It does not select one.
     *
     * @throws AnthropicException when ANTHROPIC_PROFILE names a profile that is missing or invalid
     */
    public static function resolve(): ?CredentialResult
    {
        // 1. ANTHROPIC_API_KEY set — use the existing API key flow.
        $apiKey = Util::getenv('ANTHROPIC_API_KEY');
        if (!is_null($apiKey) && '' !== $apiKey) {
            return null;
        }

        // 2. Static auth token.
        $authToken = Util::getenv('ANTHROPIC_AUTH_TOKEN');
        if (!is_null($authToken) && '' !== $authToken) {
            return new CredentialResult(
                provider: new TokenCache(new EnvToken),
            );
        }

        // 3. The profile named by ANTHROPIC_PROFILE.
        $profile = Util::getenv('ANTHROPIC_PROFILE');
        if (!is_null($profile) && '' !== $profile) {
            return (new CredentialsFile(profile: $profile))->resolve() ?? throw new AnthropicException(
                "ANTHROPIC_PROFILE names the profile `{$profile}`, which is missing or invalid. Check its config and credentials files, or unset ANTHROPIC_PROFILE.",
            );
        }

        // 4. Workload identity from env vars.
        $result = self::tryWorkloadIdentityFromEnv();
        if (!is_null($result)) {
            return $result;
        }

        // 5. The active profile, or nothing.
        return self::tryActiveProfile();
    }

    private static function tryActiveProfile(): ?CredentialResult
    {
        try {
            return (new CredentialsFile)->resolve();
        } catch (\Throwable $e) {
            $configDir = Util::getenv('ANTHROPIC_CONFIG_DIR');
            if (!is_null($configDir) && '' !== $configDir) {
                throw $e;
            }

            return null;
        }
    }

    private static function tryWorkloadIdentityFromEnv(): ?CredentialResult
    {
        $federationRule = Util::getenv('ANTHROPIC_FEDERATION_RULE_ID');
        $organizationId = Util::getenv('ANTHROPIC_ORGANIZATION_ID');

        if (is_null($federationRule) || '' === $federationRule
            || is_null($organizationId) || '' === $organizationId
        ) {
            return null;
        }

        $identityProvider = self::resolveIdentityTokenProvider();
        if (is_null($identityProvider)) {
            return null;
        }

        $serviceAccountId = Util::getenv('ANTHROPIC_SERVICE_ACCOUNT_ID');
        if ('' === $serviceAccountId) {
            $serviceAccountId = null;
        }

        // Coerce empty string to null so a defaulted-but-empty CI variable
        // doesn't put `"workspace_id": ""` on the wire.
        $workspaceId = Util::getenv('ANTHROPIC_WORKSPACE_ID');
        if ('' === $workspaceId) {
            $workspaceId = null;
        }

        $provider = new WorkloadIdentityCredentials(
            identityProvider: $identityProvider,
            federationRuleId: $federationRule,
            organizationId: $organizationId,
            serviceAccountId: $serviceAccountId,
            workspaceId: $workspaceId,
        );

        return new CredentialResult(
            provider: new TokenCache($provider),
        );
    }

    private static function resolveIdentityTokenProvider(): ?IdentityTokenProvider
    {
        $tokenFile = Util::getenv('ANTHROPIC_IDENTITY_TOKEN_FILE');
        if (!is_null($tokenFile) && '' !== $tokenFile) {
            return new IdentityTokenFile($tokenFile);
        }

        $token = Util::getenv('ANTHROPIC_IDENTITY_TOKEN');
        if (!is_null($token) && '' !== $token) {
            return new IdentityTokenLiteral($token);
        }

        return null;
    }
}
