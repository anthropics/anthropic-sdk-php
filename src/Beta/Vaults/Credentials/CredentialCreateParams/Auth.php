<?php

declare(strict_types=1);

namespace Anthropic\Beta\Vaults\Credentials\CredentialCreateParams;

use Anthropic\Beta\Vaults\Credentials\ManagedAgentsMCPOAuthCreateParams;
use Anthropic\Beta\Vaults\Credentials\ManagedAgentsStaticBearerCreateParams;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Authentication details for creating a credential.
 *
 * @phpstan-import-type ManagedAgentsMCPOAuthCreateParamsShape from \Anthropic\Beta\Vaults\Credentials\ManagedAgentsMCPOAuthCreateParams
 * @phpstan-import-type ManagedAgentsStaticBearerCreateParamsShape from \Anthropic\Beta\Vaults\Credentials\ManagedAgentsStaticBearerCreateParams
 *
 * @phpstan-type AuthVariants = ManagedAgentsMCPOAuthCreateParams|ManagedAgentsStaticBearerCreateParams
 * @phpstan-type AuthShape = AuthVariants|ManagedAgentsMCPOAuthCreateParamsShape|ManagedAgentsStaticBearerCreateParamsShape
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
        ];
    }
}
