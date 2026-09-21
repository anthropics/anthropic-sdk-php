<?php

declare(strict_types=1);

namespace Anthropic\Beta\Environments\BetaCloudConfigParams;

use Anthropic\Beta\Environments\BetaCloudConfigParams\Networking\Type;
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

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @param list<string>|null $allowedHosts
     *
     * @return ($type is Type::UNRESTRICTED|'unrestricted' ? BetaUnrestrictedNetwork : ($type is Type::LIMITED|'limited' ? BetaLimitedNetworkParams : BetaUnrestrictedNetwork|BetaLimitedNetworkParams))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        ?bool $allowMCPServers = null,
        ?bool $allowPackageManagers = null,
        ?array $allowedHosts = null,
    ): BetaUnrestrictedNetwork|BetaLimitedNetworkParams {
        return match ($type) {
            Type::UNRESTRICTED, 'unrestricted' => BetaUnrestrictedNetwork::with(),
            Type::LIMITED, 'limited' => BetaLimitedNetworkParams::with(
                allowMCPServers: $allowMCPServers,
                allowPackageManagers: $allowPackageManagers,
                allowedHosts: $allowedHosts,
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
