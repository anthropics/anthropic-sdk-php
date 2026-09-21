<?php

declare(strict_types=1);

namespace Anthropic\Beta\Vaults\Credentials\ManagedAgentsCredential;

use Anthropic\Beta\Vaults\Credentials\ManagedAgentsCredential\Auth\Type;
use Anthropic\Beta\Vaults\Credentials\ManagedAgentsEnvironmentVariableAuthResponse;
use Anthropic\Beta\Vaults\Credentials\ManagedAgentsInjectionLocationResponse;
use Anthropic\Beta\Vaults\Credentials\ManagedAgentsLimitedCredentialNetworkingResponse;
use Anthropic\Beta\Vaults\Credentials\ManagedAgentsMCPOAuthAuthResponse;
use Anthropic\Beta\Vaults\Credentials\ManagedAgentsMCPOAuthRefreshResponse;
use Anthropic\Beta\Vaults\Credentials\ManagedAgentsStaticBearerAuthResponse;
use Anthropic\Beta\Vaults\Credentials\ManagedAgentsUnrestrictedCredentialNetworkingResponse;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Authentication details for a credential.
 *
 * @phpstan-import-type ManagedAgentsMCPOAuthAuthResponseShape from \Anthropic\Beta\Vaults\Credentials\ManagedAgentsMCPOAuthAuthResponse
 * @phpstan-import-type ManagedAgentsStaticBearerAuthResponseShape from \Anthropic\Beta\Vaults\Credentials\ManagedAgentsStaticBearerAuthResponse
 * @phpstan-import-type ManagedAgentsEnvironmentVariableAuthResponseShape from \Anthropic\Beta\Vaults\Credentials\ManagedAgentsEnvironmentVariableAuthResponse
 * @phpstan-import-type ManagedAgentsMCPOAuthRefreshResponseShape from \Anthropic\Beta\Vaults\Credentials\ManagedAgentsMCPOAuthRefreshResponse
 * @phpstan-import-type ManagedAgentsInjectionLocationResponseShape from \Anthropic\Beta\Vaults\Credentials\ManagedAgentsInjectionLocationResponse
 * @phpstan-import-type NetworkingShape from \Anthropic\Beta\Vaults\Credentials\ManagedAgentsEnvironmentVariableAuthResponse\Networking
 *
 * @phpstan-type AuthVariants = ManagedAgentsMCPOAuthAuthResponse|ManagedAgentsStaticBearerAuthResponse|ManagedAgentsEnvironmentVariableAuthResponse
 * @phpstan-type AuthShape = AuthVariants|ManagedAgentsMCPOAuthAuthResponseShape|ManagedAgentsStaticBearerAuthResponseShape|ManagedAgentsEnvironmentVariableAuthResponseShape
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
            'mcp_oauth' => ManagedAgentsMCPOAuthAuthResponse::class,
            'static_bearer' => ManagedAgentsStaticBearerAuthResponse::class,
            'environment_variable' => ManagedAgentsEnvironmentVariableAuthResponse::class,
        ];
    }

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @param ManagedAgentsMCPOAuthRefreshResponse|ManagedAgentsMCPOAuthRefreshResponseShape|null $refresh
     * @param ManagedAgentsInjectionLocationResponse|ManagedAgentsInjectionLocationResponseShape|null $injectionLocation
     * @param NetworkingShape|null $networking
     *
     * @return ($type is Type::MCP_OAUTH|'mcp_oauth' ? ManagedAgentsMCPOAuthAuthResponse : ($type is Type::STATIC_BEARER|'static_bearer' ? ManagedAgentsStaticBearerAuthResponse : ($type is Type::ENVIRONMENT_VARIABLE|'environment_variable' ? ManagedAgentsEnvironmentVariableAuthResponse : ManagedAgentsMCPOAuthAuthResponse|ManagedAgentsStaticBearerAuthResponse|ManagedAgentsEnvironmentVariableAuthResponse)))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        ?string $mcpServerURL = null,
        ?\DateTimeInterface $expiresAt = null,
        ManagedAgentsMCPOAuthRefreshResponse|array|null $refresh = null,
        ManagedAgentsInjectionLocationResponse|array|null $injectionLocation = null,
        ManagedAgentsUnrestrictedCredentialNetworkingResponse|array|ManagedAgentsLimitedCredentialNetworkingResponse|null $networking = null,
        ?string $secretName = null,
    ): ManagedAgentsMCPOAuthAuthResponse|ManagedAgentsStaticBearerAuthResponse|ManagedAgentsEnvironmentVariableAuthResponse {
        return match ($type) {
            Type::MCP_OAUTH, 'mcp_oauth' => ManagedAgentsMCPOAuthAuthResponse::with(
                type: 'mcp_oauth',
                mcpServerURL: $mcpServerURL ?? throw new \ArgumentCountError('$mcpServerURL is required'),
                expiresAt: $expiresAt,
                refresh: $refresh,
            ),
            Type::STATIC_BEARER, 'static_bearer' => ManagedAgentsStaticBearerAuthResponse::with(
                type: 'static_bearer',
                mcpServerURL: $mcpServerURL ?? throw new \ArgumentCountError('$mcpServerURL is required'),
            ),
            Type::ENVIRONMENT_VARIABLE, 'environment_variable' => ManagedAgentsEnvironmentVariableAuthResponse::with(
                type: 'environment_variable',
                injectionLocation: $injectionLocation ?? throw new \ArgumentCountError('$injectionLocation is required'),
                networking: $networking ?? throw new \ArgumentCountError('$networking is required'),
                secretName: $secretName ?? throw new \ArgumentCountError('$secretName is required'),
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
