<?php

declare(strict_types=1);

namespace Anthropic\Beta\Vaults\Credentials\ManagedAgentsMCPOAuthRefreshParams;

use Anthropic\Beta\Vaults\Credentials\ManagedAgentsMCPOAuthRefreshParams\TokenEndpointAuth\Type;
use Anthropic\Beta\Vaults\Credentials\ManagedAgentsTokenEndpointAuthBasicParam;
use Anthropic\Beta\Vaults\Credentials\ManagedAgentsTokenEndpointAuthNoneParam;
use Anthropic\Beta\Vaults\Credentials\ManagedAgentsTokenEndpointAuthPostParam;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-import-type ManagedAgentsTokenEndpointAuthNoneParamShape from \Anthropic\Beta\Vaults\Credentials\ManagedAgentsTokenEndpointAuthNoneParam
 * @phpstan-import-type ManagedAgentsTokenEndpointAuthBasicParamShape from \Anthropic\Beta\Vaults\Credentials\ManagedAgentsTokenEndpointAuthBasicParam
 * @phpstan-import-type ManagedAgentsTokenEndpointAuthPostParamShape from \Anthropic\Beta\Vaults\Credentials\ManagedAgentsTokenEndpointAuthPostParam
 *
 * @phpstan-type TokenEndpointAuthVariants = ManagedAgentsTokenEndpointAuthNoneParam|ManagedAgentsTokenEndpointAuthBasicParam|ManagedAgentsTokenEndpointAuthPostParam
 * @phpstan-type TokenEndpointAuthShape = TokenEndpointAuthVariants|ManagedAgentsTokenEndpointAuthNoneParamShape|ManagedAgentsTokenEndpointAuthBasicParamShape|ManagedAgentsTokenEndpointAuthPostParamShape
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
            'none' => ManagedAgentsTokenEndpointAuthNoneParam::class,
            'client_secret_basic' => ManagedAgentsTokenEndpointAuthBasicParam::class,
            'client_secret_post' => ManagedAgentsTokenEndpointAuthPostParam::class,
        ];
    }

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @return ($type is Type::NONE|'none' ? ManagedAgentsTokenEndpointAuthNoneParam : ($type is Type::CLIENT_SECRET_BASIC|'client_secret_basic' ? ManagedAgentsTokenEndpointAuthBasicParam : ($type is Type::CLIENT_SECRET_POST|'client_secret_post' ? ManagedAgentsTokenEndpointAuthPostParam : ManagedAgentsTokenEndpointAuthNoneParam|ManagedAgentsTokenEndpointAuthBasicParam|ManagedAgentsTokenEndpointAuthPostParam)))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        ?string $clientSecret = null
    ): ManagedAgentsTokenEndpointAuthNoneParam|ManagedAgentsTokenEndpointAuthBasicParam|ManagedAgentsTokenEndpointAuthPostParam {
        return match ($type) {
            Type::NONE, 'none' => ManagedAgentsTokenEndpointAuthNoneParam::with(
                type: 'none'
            ),
            Type::CLIENT_SECRET_BASIC, 'client_secret_basic' => ManagedAgentsTokenEndpointAuthBasicParam::with(
                type: 'client_secret_basic',
                clientSecret: $clientSecret ?? throw new \ArgumentCountError('$clientSecret is required'),
            ),
            Type::CLIENT_SECRET_POST, 'client_secret_post' => ManagedAgentsTokenEndpointAuthPostParam::with(
                type: 'client_secret_post',
                clientSecret: $clientSecret ?? throw new \ArgumentCountError('$clientSecret is required'),
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
