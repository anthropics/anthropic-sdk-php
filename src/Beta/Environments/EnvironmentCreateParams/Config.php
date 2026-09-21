<?php

declare(strict_types=1);

namespace Anthropic\Beta\Environments\EnvironmentCreateParams;

use Anthropic\Beta\Environments\BetaCloudConfigParams;
use Anthropic\Beta\Environments\BetaLimitedNetworkParams;
use Anthropic\Beta\Environments\BetaPackagesParams;
use Anthropic\Beta\Environments\BetaSelfHostedConfigParams;
use Anthropic\Beta\Environments\BetaUnrestrictedNetwork;
use Anthropic\Beta\Environments\EnvironmentCreateParams\Config\Type;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Environment configuration.
 *
 * @phpstan-import-type BetaCloudConfigParamsShape from \Anthropic\Beta\Environments\BetaCloudConfigParams
 * @phpstan-import-type BetaSelfHostedConfigParamsShape from \Anthropic\Beta\Environments\BetaSelfHostedConfigParams
 * @phpstan-import-type NetworkingShape from \Anthropic\Beta\Environments\BetaCloudConfigParams\Networking
 * @phpstan-import-type BetaPackagesParamsShape from \Anthropic\Beta\Environments\BetaPackagesParams
 *
 * @phpstan-type ConfigVariants = BetaCloudConfigParams|BetaSelfHostedConfigParams
 * @phpstan-type ConfigShape = ConfigVariants|BetaCloudConfigParamsShape|BetaSelfHostedConfigParamsShape
 */
final class Config implements ConverterSource
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
            'cloud' => BetaCloudConfigParams::class,
            'self_hosted' => BetaSelfHostedConfigParams::class,
        ];
    }

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @param NetworkingShape|null $networking
     * @param BetaPackagesParams|BetaPackagesParamsShape|null $packages
     *
     * @return ($type is Type::CLOUD|'cloud' ? BetaCloudConfigParams : ($type is Type::SELF_HOSTED|'self_hosted' ? BetaSelfHostedConfigParams : BetaCloudConfigParams|BetaSelfHostedConfigParams))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        BetaUnrestrictedNetwork|array|BetaLimitedNetworkParams|null $networking = null,
        BetaPackagesParams|array|null $packages = null,
    ): BetaCloudConfigParams|BetaSelfHostedConfigParams {
        return match ($type) {
            Type::CLOUD, 'cloud' => BetaCloudConfigParams::with(
                networking: $networking,
                packages: $packages
            ),
            Type::SELF_HOSTED, 'self_hosted' => BetaSelfHostedConfigParams::with(),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
