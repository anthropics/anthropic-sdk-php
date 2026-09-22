<?php

declare(strict_types=1);

namespace Anthropic\Beta\Vaults\Credentials\CredentialCreateParams;

use Anthropic\Beta\Vaults\Credentials\CredentialCreateParams\Auth\Type;
use Anthropic\Beta\Vaults\Credentials\ManagedAgentsEnvironmentVariableCreateParams;
use Anthropic\Beta\Vaults\Credentials\ManagedAgentsInjectionLocationParams;
use Anthropic\Beta\Vaults\Credentials\ManagedAgentsLimitedCredentialNetworkingParams;
use Anthropic\Beta\Vaults\Credentials\ManagedAgentsMCPOAuthCreateParams;
use Anthropic\Beta\Vaults\Credentials\ManagedAgentsMCPOAuthRefreshParams;
use Anthropic\Beta\Vaults\Credentials\ManagedAgentsStaticBearerCreateParams;
use Anthropic\Beta\Vaults\Credentials\ManagedAgentsUnrestrictedCredentialNetworkingParams;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Authentication details for creating a credential.
 *
 * @phpstan-import-type ManagedAgentsMCPOAuthCreateParamsShape from \Anthropic\Beta\Vaults\Credentials\ManagedAgentsMCPOAuthCreateParams
 * @phpstan-import-type ManagedAgentsStaticBearerCreateParamsShape from \Anthropic\Beta\Vaults\Credentials\ManagedAgentsStaticBearerCreateParams
 * @phpstan-import-type ManagedAgentsEnvironmentVariableCreateParamsShape from \Anthropic\Beta\Vaults\Credentials\ManagedAgentsEnvironmentVariableCreateParams
 * @phpstan-import-type ManagedAgentsMCPOAuthRefreshParamsShape from \Anthropic\Beta\Vaults\Credentials\ManagedAgentsMCPOAuthRefreshParams
 * @phpstan-import-type ManagedAgentsCredentialNetworkingParamsShape from \Anthropic\Beta\Vaults\Credentials\ManagedAgentsCredentialNetworkingParams
 * @phpstan-import-type ManagedAgentsInjectionLocationParamsShape from \Anthropic\Beta\Vaults\Credentials\ManagedAgentsInjectionLocationParams
 *
 * @phpstan-type AuthVariants = ManagedAgentsMCPOAuthCreateParams|ManagedAgentsStaticBearerCreateParams|ManagedAgentsEnvironmentVariableCreateParams
 * @phpstan-type AuthShape = AuthVariants|ManagedAgentsMCPOAuthCreateParamsShape|ManagedAgentsStaticBearerCreateParamsShape|ManagedAgentsEnvironmentVariableCreateParamsShape
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
            'mcp_oauth' => ManagedAgentsMCPOAuthCreateParams::class,
            'static_bearer' => ManagedAgentsStaticBearerCreateParams::class,
            'environment_variable' => ManagedAgentsEnvironmentVariableCreateParams::class,
        ];
    }

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @param ManagedAgentsMCPOAuthRefreshParams|ManagedAgentsMCPOAuthRefreshParamsShape|null $refresh
     * @param ManagedAgentsCredentialNetworkingParamsShape|null $networking
     * @param ManagedAgentsInjectionLocationParams|ManagedAgentsInjectionLocationParamsShape|null $injectionLocation
     *
     * @return ($type is Type::MCP_OAUTH|'mcp_oauth' ? ManagedAgentsMCPOAuthCreateParams : ($type is Type::STATIC_BEARER|'static_bearer' ? ManagedAgentsStaticBearerCreateParams : ($type is Type::ENVIRONMENT_VARIABLE|'environment_variable' ? ManagedAgentsEnvironmentVariableCreateParams : ManagedAgentsMCPOAuthCreateParams|ManagedAgentsStaticBearerCreateParams|ManagedAgentsEnvironmentVariableCreateParams)))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        ?string $accessToken = null,
        ?string $mcpServerURL = null,
        ?\DateTimeInterface $expiresAt = null,
        ManagedAgentsMCPOAuthRefreshParams|array|null $refresh = null,
        ?string $token = null,
        ManagedAgentsUnrestrictedCredentialNetworkingParams|array|ManagedAgentsLimitedCredentialNetworkingParams|null $networking = null,
        ?string $secretName = null,
        ?string $secretValue = null,
        ManagedAgentsInjectionLocationParams|array|null $injectionLocation = null,
    ): ManagedAgentsMCPOAuthCreateParams|ManagedAgentsStaticBearerCreateParams|ManagedAgentsEnvironmentVariableCreateParams {
        return match ($type) {
            Type::MCP_OAUTH, 'mcp_oauth' => ManagedAgentsMCPOAuthCreateParams::with(
                type: 'mcp_oauth',
                accessToken: $accessToken ?? throw new \ArgumentCountError('$accessToken is required'),
                mcpServerURL: $mcpServerURL ?? throw new \ArgumentCountError('$mcpServerURL is required'),
                expiresAt: $expiresAt,
                refresh: $refresh,
            ),
            Type::STATIC_BEARER, 'static_bearer' => ManagedAgentsStaticBearerCreateParams::with(
                type: 'static_bearer',
                token: $token ?? throw new \ArgumentCountError('$token is required'),
                mcpServerURL: $mcpServerURL ?? throw new \ArgumentCountError('$mcpServerURL is required'),
            ),
            Type::ENVIRONMENT_VARIABLE, 'environment_variable' => ManagedAgentsEnvironmentVariableCreateParams::with(
                type: 'environment_variable',
                networking: $networking ?? throw new \ArgumentCountError('$networking is required'),
                secretName: $secretName ?? throw new \ArgumentCountError('$secretName is required'),
                secretValue: $secretValue ?? throw new \ArgumentCountError('$secretValue is required'),
                injectionLocation: $injectionLocation,
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
