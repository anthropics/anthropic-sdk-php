<?php

declare(strict_types=1);

namespace Anthropic\Beta\Vaults\Credentials\ManagedAgentsCredential;

use Anthropic\Beta\Vaults\Credentials\ManagedAgentsMCPOAuthAuthResponse;
use Anthropic\Beta\Vaults\Credentials\ManagedAgentsStaticBearerAuthResponse;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Authentication details for a credential.
 *
 * @phpstan-import-type ManagedAgentsMCPOAuthAuthResponseShape from \Anthropic\Beta\Vaults\Credentials\ManagedAgentsMCPOAuthAuthResponse
 * @phpstan-import-type ManagedAgentsStaticBearerAuthResponseShape from \Anthropic\Beta\Vaults\Credentials\ManagedAgentsStaticBearerAuthResponse
 *
 * @phpstan-type AuthVariants = ManagedAgentsMCPOAuthAuthResponse|ManagedAgentsStaticBearerAuthResponse
 * @phpstan-type AuthShape = AuthVariants|ManagedAgentsMCPOAuthAuthResponseShape|ManagedAgentsStaticBearerAuthResponseShape
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
        ];
    }
}
