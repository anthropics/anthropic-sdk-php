<?php

declare(strict_types=1);

namespace Anthropic\Lib\Credentials;

use Anthropic\Core\Util;

final class DefaultCredentials
{
    /**
     * Resolve credentials by precedence. Returns null when the existing
     * X-Api-Key path should be used, or when no credentials source is found.
     *
     * Resolution order:
     *  1. ANTHROPIC_API_KEY set            → null (use existing path)
     *  2. ANTHROPIC_AUTH_TOKEN set          → EnvToken
     *  3. Profile config on disk            → CredentialsFile
     *  4. OIDC env vars all set             → WorkloadIdentityCredentials
     *  5. Nothing                           → null
     */
    public static function resolve(): ?CredentialResult
    {
        // 1. API key takes highest precedence — use existing X-Api-Key flow.
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

        // 3. Profile-based config file.
        $result = self::tryCredentialsFile();
        if (!is_null($result)) {
            return $result;
        }

        // 4. Workload identity from env vars.
        $result = self::tryWorkloadIdentityFromEnv();
        if (!is_null($result)) {
            return $result;
        }

        // 5. Nothing found.
        return null;
    }

    private static function tryCredentialsFile(): ?CredentialResult
    {
        $profile = Util::getenv('ANTHROPIC_PROFILE');
        $configDir = Util::getenv('ANTHROPIC_CONFIG_DIR');
        $hasExplicitConfig = (!is_null($profile) && '' !== $profile)
            || (!is_null($configDir) && '' !== $configDir);

        $credFile = new CredentialsFile(
            configDir: (!is_null($configDir) && '' !== $configDir) ? $configDir : null,
            profile: (!is_null($profile) && '' !== $profile) ? $profile : null,
        );

        try {
            $result = $credFile->resolve();
        } catch (\Throwable $e) {
            // If explicit env vars were set, propagate errors.
            if ($hasExplicitConfig) {
                throw $e;
            }

            // Otherwise, silently fall through to the next tier.
            return null;
        }

        return $result;
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

        $provider = new WorkloadIdentityCredentials(
            identityProvider: $identityProvider,
            federationRuleId: $federationRule,
            organizationId: $organizationId,
            serviceAccountId: $serviceAccountId,
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
