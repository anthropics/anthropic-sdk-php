<?php

declare(strict_types=1);

namespace Anthropic\Beta\Vaults\Credentials\ManagedAgentsMCPOAuthRefreshUpdateParams;

use Anthropic\Beta\Vaults\Credentials\ManagedAgentsTokenEndpointAuthBasicUpdateParam;
use Anthropic\Beta\Vaults\Credentials\ManagedAgentsTokenEndpointAuthPostUpdateParam;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Updated HTTP Basic authentication parameters for the token endpoint.
 *
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
}
