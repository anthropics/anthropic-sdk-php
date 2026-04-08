<?php

declare(strict_types=1);

namespace Anthropic\Beta\Vaults\Credentials\ManagedAgentsMCPOAuthRefreshResponse;

use Anthropic\Beta\Vaults\Credentials\ManagedAgentsTokenEndpointAuthBasicResponse;
use Anthropic\Beta\Vaults\Credentials\ManagedAgentsTokenEndpointAuthNoneResponse;
use Anthropic\Beta\Vaults\Credentials\ManagedAgentsTokenEndpointAuthPostResponse;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Token endpoint requires no client authentication.
 *
 * @phpstan-import-type ManagedAgentsTokenEndpointAuthNoneResponseShape from \Anthropic\Beta\Vaults\Credentials\ManagedAgentsTokenEndpointAuthNoneResponse
 * @phpstan-import-type ManagedAgentsTokenEndpointAuthBasicResponseShape from \Anthropic\Beta\Vaults\Credentials\ManagedAgentsTokenEndpointAuthBasicResponse
 * @phpstan-import-type ManagedAgentsTokenEndpointAuthPostResponseShape from \Anthropic\Beta\Vaults\Credentials\ManagedAgentsTokenEndpointAuthPostResponse
 *
 * @phpstan-type TokenEndpointAuthVariants = ManagedAgentsTokenEndpointAuthNoneResponse|ManagedAgentsTokenEndpointAuthBasicResponse|ManagedAgentsTokenEndpointAuthPostResponse
 * @phpstan-type TokenEndpointAuthShape = TokenEndpointAuthVariants|ManagedAgentsTokenEndpointAuthNoneResponseShape|ManagedAgentsTokenEndpointAuthBasicResponseShape|ManagedAgentsTokenEndpointAuthPostResponseShape
 */
final class TokenEndpointAuth implements ConverterSource
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
            'none' => ManagedAgentsTokenEndpointAuthNoneResponse::class,
            'client_secret_basic' => ManagedAgentsTokenEndpointAuthBasicResponse::class,
            'client_secret_post' => ManagedAgentsTokenEndpointAuthPostResponse::class,
        ];
    }
}
