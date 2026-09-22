<?php

declare(strict_types=1);

namespace Anthropic\Beta\Environments\BetaCloudConfig;

use Anthropic\Beta\Environments\BetaLimitedNetwork;
use Anthropic\Beta\Environments\BetaUnrestrictedNetwork;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Network configuration policy.
 *
 * @phpstan-import-type BetaUnrestrictedNetworkShape from \Anthropic\Beta\Environments\BetaUnrestrictedNetwork
 * @phpstan-import-type BetaLimitedNetworkShape from \Anthropic\Beta\Environments\BetaLimitedNetwork
 *
 * @phpstan-type NetworkingVariants = BetaUnrestrictedNetwork|BetaLimitedNetwork
 * @phpstan-type NetworkingShape = NetworkingVariants|BetaUnrestrictedNetworkShape|BetaLimitedNetworkShape
 */
final class Networking implements ConverterSource
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
            'unrestricted' => BetaUnrestrictedNetwork::class,
            'limited' => BetaLimitedNetwork::class,
        ];
    }
}
