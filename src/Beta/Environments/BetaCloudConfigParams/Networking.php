<?php

declare(strict_types=1);

namespace Anthropic\Beta\Environments\BetaCloudConfigParams;

use Anthropic\Beta\Environments\BetaLimitedNetworkParams;
use Anthropic\Beta\Environments\BetaUnrestrictedNetwork;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Network configuration policy. Omit on update to preserve the existing value.
 *
 * @phpstan-import-type BetaUnrestrictedNetworkShape from \Anthropic\Beta\Environments\BetaUnrestrictedNetwork
 * @phpstan-import-type BetaLimitedNetworkParamsShape from \Anthropic\Beta\Environments\BetaLimitedNetworkParams
 *
 * @phpstan-type NetworkingVariants = BetaUnrestrictedNetwork|BetaLimitedNetworkParams
 * @phpstan-type NetworkingShape = NetworkingVariants|BetaUnrestrictedNetworkShape|BetaLimitedNetworkParamsShape
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
            'limited' => BetaLimitedNetworkParams::class,
        ];
    }
}
