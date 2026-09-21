<?php

declare(strict_types=1);

namespace Anthropic\Beta\Environments\BetaCloudConfig;

use Anthropic\Beta\Environments\BetaCloudConfig\Networking\Type;
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

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @param list<string>|null $allowedHosts
     *
     * @return ($type is Type::UNRESTRICTED|'unrestricted' ? BetaUnrestrictedNetwork : ($type is Type::LIMITED|'limited' ? BetaLimitedNetwork : BetaUnrestrictedNetwork|BetaLimitedNetwork))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        ?bool $allowMCPServers = null,
        ?bool $allowPackageManagers = null,
        ?array $allowedHosts = null,
    ): BetaUnrestrictedNetwork|BetaLimitedNetwork {
        return match ($type) {
            Type::UNRESTRICTED, 'unrestricted' => BetaUnrestrictedNetwork::with(),
            Type::LIMITED, 'limited' => BetaLimitedNetwork::with(
                allowMCPServers: $allowMCPServers ?? throw new \ArgumentCountError('$allowMCPServers is required'),
                allowPackageManagers: $allowPackageManagers ?? throw new \ArgumentCountError('$allowPackageManagers is required'),
                allowedHosts: $allowedHosts ?? throw new \ArgumentCountError('$allowedHosts is required'),
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
