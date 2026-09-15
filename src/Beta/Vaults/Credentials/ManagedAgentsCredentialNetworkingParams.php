<?php

declare(strict_types=1);

namespace Anthropic\Beta\Vaults\Credentials;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-import-type ManagedAgentsUnrestrictedCredentialNetworkingParamsShape from \Anthropic\Beta\Vaults\Credentials\ManagedAgentsUnrestrictedCredentialNetworkingParams
 * @phpstan-import-type ManagedAgentsLimitedCredentialNetworkingParamsShape from \Anthropic\Beta\Vaults\Credentials\ManagedAgentsLimitedCredentialNetworkingParams
 *
 * @phpstan-type ManagedAgentsCredentialNetworkingParamsVariants = ManagedAgentsUnrestrictedCredentialNetworkingParams|ManagedAgentsLimitedCredentialNetworkingParams
 * @phpstan-type ManagedAgentsCredentialNetworkingParamsShape = ManagedAgentsCredentialNetworkingParamsVariants|ManagedAgentsUnrestrictedCredentialNetworkingParamsShape|ManagedAgentsLimitedCredentialNetworkingParamsShape
 */
final class ManagedAgentsCredentialNetworkingParams implements ConverterSource
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
            'unrestricted' => ManagedAgentsUnrestrictedCredentialNetworkingParams::class,
            'limited' => ManagedAgentsLimitedCredentialNetworkingParams::class,
        ];
    }
}
