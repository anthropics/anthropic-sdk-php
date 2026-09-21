<?php

declare(strict_types=1);

namespace Anthropic\Beta\Vaults\Credentials\ManagedAgentsMCPOAuthRefreshUpdateParams;

use Anthropic\Beta\Vaults\Credentials\ManagedAgentsMCPOAuthRefreshUpdateParams\TokenEndpointAuth\Type;
use Anthropic\Beta\Vaults\Credentials\ManagedAgentsTokenEndpointAuthBasicUpdateParam;
use Anthropic\Beta\Vaults\Credentials\ManagedAgentsTokenEndpointAuthPostUpdateParam;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-import-type ManagedAgentsTokenEndpointAuthBasicUpdateParamShape from \Anthropic\Beta\Vaults\Credentials\ManagedAgentsTokenEndpointAuthBasicUpdateParam
 * @phpstan-import-type ManagedAgentsTokenEndpointAuthPostUpdateParamShape from \Anthropic\Beta\Vaults\Credentials\ManagedAgentsTokenEndpointAuthPostUpdateParam
 *
 * @phpstan-type TokenEndpointAuthVariants = ManagedAgentsTokenEndpointAuthBasicUpdateParam|ManagedAgentsTokenEndpointAuthPostUpdateParam
 * @phpstan-type TokenEndpointAuthShape = TokenEndpointAuthVariants|ManagedAgentsTokenEndpointAuthBasicUpdateParamShape|ManagedAgentsTokenEndpointAuthPostUpdateParamShape
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
            'client_secret_basic' => ManagedAgentsTokenEndpointAuthBasicUpdateParam::class,
            'client_secret_post' => ManagedAgentsTokenEndpointAuthPostUpdateParam::class,
        ];
    }

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @return ($type is Type::CLIENT_SECRET_BASIC|'client_secret_basic' ? ManagedAgentsTokenEndpointAuthBasicUpdateParam : ($type is Type::CLIENT_SECRET_POST|'client_secret_post' ? ManagedAgentsTokenEndpointAuthPostUpdateParam : ManagedAgentsTokenEndpointAuthBasicUpdateParam|ManagedAgentsTokenEndpointAuthPostUpdateParam))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        ?string $clientSecret = null
    ): ManagedAgentsTokenEndpointAuthBasicUpdateParam|ManagedAgentsTokenEndpointAuthPostUpdateParam {
        return match ($type) {
            Type::CLIENT_SECRET_BASIC, 'client_secret_basic' => ManagedAgentsTokenEndpointAuthBasicUpdateParam::with(
                type: 'client_secret_basic',
                clientSecret: $clientSecret
            ),
            Type::CLIENT_SECRET_POST, 'client_secret_post' => ManagedAgentsTokenEndpointAuthPostUpdateParam::with(
                type: 'client_secret_post',
                clientSecret: $clientSecret
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
