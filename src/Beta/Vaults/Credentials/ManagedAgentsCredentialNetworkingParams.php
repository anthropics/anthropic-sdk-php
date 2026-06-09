<?php

declare(strict_types=1);

namespace Anthropic\Beta\Vaults\Credentials;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Substitute the secret on any host the session's Environment network policy permits egress to. The Environment's network policy is the only boundary on where the secret can reach.
 *
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
