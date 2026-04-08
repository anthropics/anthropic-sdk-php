<?php

declare(strict_types=1);

namespace Anthropic\Beta\Vaults\Credentials\ManagedAgentsMCPOAuthRefreshParams;

use Anthropic\Beta\Vaults\Credentials\ManagedAgentsTokenEndpointAuthBasicParam;
use Anthropic\Beta\Vaults\Credentials\ManagedAgentsTokenEndpointAuthNoneParam;
use Anthropic\Beta\Vaults\Credentials\ManagedAgentsTokenEndpointAuthPostParam;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Token endpoint requires no client authentication.
 *
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
}
