<?php

declare(strict_types=1);

namespace Anthropic\Beta\Vaults\Credentials\CredentialUpdateParams;

use Anthropic\Beta\Vaults\Credentials\ManagedAgentsEnvironmentVariableUpdateParams;
use Anthropic\Beta\Vaults\Credentials\ManagedAgentsMCPOAuthUpdateParams;
use Anthropic\Beta\Vaults\Credentials\ManagedAgentsStaticBearerUpdateParams;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Updated authentication details for a credential.
 *
 * @phpstan-import-type ManagedAgentsMCPOAuthUpdateParamsShape from \Anthropic\Beta\Vaults\Credentials\ManagedAgentsMCPOAuthUpdateParams
 * @phpstan-import-type ManagedAgentsStaticBearerUpdateParamsShape from \Anthropic\Beta\Vaults\Credentials\ManagedAgentsStaticBearerUpdateParams
 * @phpstan-import-type ManagedAgentsEnvironmentVariableUpdateParamsShape from \Anthropic\Beta\Vaults\Credentials\ManagedAgentsEnvironmentVariableUpdateParams
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
}
