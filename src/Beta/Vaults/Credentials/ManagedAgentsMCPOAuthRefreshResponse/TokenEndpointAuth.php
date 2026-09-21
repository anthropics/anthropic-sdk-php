<?php

declare(strict_types=1);

namespace Anthropic\Beta\Vaults\Credentials\ManagedAgentsMCPOAuthRefreshResponse;

use Anthropic\Beta\Vaults\Credentials\ManagedAgentsMCPOAuthRefreshResponse\TokenEndpointAuth\Type;
use Anthropic\Beta\Vaults\Credentials\ManagedAgentsTokenEndpointAuthBasicResponse;
use Anthropic\Beta\Vaults\Credentials\ManagedAgentsTokenEndpointAuthNoneResponse;
use Anthropic\Beta\Vaults\Credentials\ManagedAgentsTokenEndpointAuthPostResponse;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
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

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @return ($type is Type::NONE|'none' ? ManagedAgentsTokenEndpointAuthNoneResponse : ($type is Type::CLIENT_SECRET_BASIC|'client_secret_basic' ? ManagedAgentsTokenEndpointAuthBasicResponse : ($type is Type::CLIENT_SECRET_POST|'client_secret_post' ? ManagedAgentsTokenEndpointAuthPostResponse : ManagedAgentsTokenEndpointAuthNoneResponse|ManagedAgentsTokenEndpointAuthBasicResponse|ManagedAgentsTokenEndpointAuthPostResponse)))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type
    ): ManagedAgentsTokenEndpointAuthNoneResponse|ManagedAgentsTokenEndpointAuthBasicResponse|ManagedAgentsTokenEndpointAuthPostResponse {
        return match ($type) {
            Type::NONE, 'none' => ManagedAgentsTokenEndpointAuthNoneResponse::with(
                type: 'none'
            ),
            Type::CLIENT_SECRET_BASIC, 'client_secret_basic' => ManagedAgentsTokenEndpointAuthBasicResponse::with(
                type: 'client_secret_basic'
            ),
            Type::CLIENT_SECRET_POST, 'client_secret_post' => ManagedAgentsTokenEndpointAuthPostResponse::with(
                type: 'client_secret_post'
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
