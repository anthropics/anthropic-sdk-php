<?php

declare(strict_types=1);

namespace Anthropic\Beta\Vaults\Credentials\CredentialUpdateParams;

use Anthropic\Beta\Vaults\Credentials\CredentialUpdateParams\Auth\Type;
use Anthropic\Beta\Vaults\Credentials\ManagedAgentsEnvironmentVariableUpdateParams;
use Anthropic\Beta\Vaults\Credentials\ManagedAgentsInjectionLocationUpdateParams;
use Anthropic\Beta\Vaults\Credentials\ManagedAgentsLimitedCredentialNetworkingParams;
use Anthropic\Beta\Vaults\Credentials\ManagedAgentsMCPOAuthRefreshUpdateParams;
use Anthropic\Beta\Vaults\Credentials\ManagedAgentsMCPOAuthUpdateParams;
use Anthropic\Beta\Vaults\Credentials\ManagedAgentsStaticBearerUpdateParams;
use Anthropic\Beta\Vaults\Credentials\ManagedAgentsUnrestrictedCredentialNetworkingParams;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Updated authentication details for a credential.
 *
 * @phpstan-import-type ManagedAgentsMCPOAuthUpdateParamsShape from \Anthropic\Beta\Vaults\Credentials\ManagedAgentsMCPOAuthUpdateParams
 * @phpstan-import-type ManagedAgentsStaticBearerUpdateParamsShape from \Anthropic\Beta\Vaults\Credentials\ManagedAgentsStaticBearerUpdateParams
 * @phpstan-import-type ManagedAgentsEnvironmentVariableUpdateParamsShape from \Anthropic\Beta\Vaults\Credentials\ManagedAgentsEnvironmentVariableUpdateParams
 * @phpstan-import-type ManagedAgentsMCPOAuthRefreshUpdateParamsShape from \Anthropic\Beta\Vaults\Credentials\ManagedAgentsMCPOAuthRefreshUpdateParams
 * @phpstan-import-type ManagedAgentsInjectionLocationUpdateParamsShape from \Anthropic\Beta\Vaults\Credentials\ManagedAgentsInjectionLocationUpdateParams
 * @phpstan-import-type ManagedAgentsCredentialNetworkingParamsShape from \Anthropic\Beta\Vaults\Credentials\ManagedAgentsCredentialNetworkingParams
 *
 * @phpstan-type AuthVariants = ManagedAgentsMCPOAuthUpdateParams|ManagedAgentsStaticBearerUpdateParams|ManagedAgentsEnvironmentVariableUpdateParams
 * @phpstan-type AuthShape = AuthVariants|ManagedAgentsMCPOAuthUpdateParamsShape|ManagedAgentsStaticBearerUpdateParamsShape|ManagedAgentsEnvironmentVariableUpdateParamsShape
 */
final class Auth implements ConverterSource
{
    use SdkUnion;

    public static function discriminator(): string
    {
        return 'type';
    }

    /**
     * @return list<string|Converter|ConverterSource>|array<string,string|Converter|ConverterSource>
     */
    public static function variants(): array
    {
        return [
            'mcp_oauth' => ManagedAgentsMCPOAuthUpdateParams::class,
            'static_bearer' => ManagedAgentsStaticBearerUpdateParams::class,
            'environment_variable' => ManagedAgentsEnvironmentVariableUpdateParams::class,
        ];
    }

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @param ManagedAgentsMCPOAuthRefreshUpdateParams|ManagedAgentsMCPOAuthRefreshUpdateParamsShape|null $refresh
     * @param ManagedAgentsInjectionLocationUpdateParams|ManagedAgentsInjectionLocationUpdateParamsShape|null $injectionLocation
     * @param ManagedAgentsCredentialNetworkingParamsShape|null $networking
     *
     * @return ($type is Type::MCP_OAUTH|'mcp_oauth' ? ManagedAgentsMCPOAuthUpdateParams : ($type is Type::STATIC_BEARER|'static_bearer' ? ManagedAgentsStaticBearerUpdateParams : ($type is Type::ENVIRONMENT_VARIABLE|'environment_variable' ? ManagedAgentsEnvironmentVariableUpdateParams : ManagedAgentsMCPOAuthUpdateParams|ManagedAgentsStaticBearerUpdateParams|ManagedAgentsEnvironmentVariableUpdateParams)))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        ?string $accessToken = null,
        ?\DateTimeInterface $expiresAt = null,
        ManagedAgentsMCPOAuthRefreshUpdateParams|array|null $refresh = null,
        ?string $token = null,
        ManagedAgentsInjectionLocationUpdateParams|array|null $injectionLocation = null,
        ManagedAgentsUnrestrictedCredentialNetworkingParams|array|ManagedAgentsLimitedCredentialNetworkingParams|null $networking = null,
        ?string $secretValue = null,
    ): ManagedAgentsMCPOAuthUpdateParams|ManagedAgentsStaticBearerUpdateParams|ManagedAgentsEnvironmentVariableUpdateParams {
        return match ($type) {
            Type::MCP_OAUTH, 'mcp_oauth' => ManagedAgentsMCPOAuthUpdateParams::with(
                type: 'mcp_oauth',
                accessToken: $accessToken,
                expiresAt: $expiresAt,
                refresh: $refresh,
            ),
            Type::STATIC_BEARER, 'static_bearer' => ManagedAgentsStaticBearerUpdateParams::with(
                type: 'static_bearer',
                token: $token
            ),
            Type::ENVIRONMENT_VARIABLE, 'environment_variable' => ManagedAgentsEnvironmentVariableUpdateParams::with(
                type: 'environment_variable',
                injectionLocation: $injectionLocation,
                networking: $networking,
                secretValue: $secretValue,
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
