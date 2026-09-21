<?php

declare(strict_types=1);

namespace Anthropic\Beta\Environments\BetaEnvironment;

use Anthropic\Beta\Environments\BetaCloudConfig;
use Anthropic\Beta\Environments\BetaEnvironment\Config\Type;
use Anthropic\Beta\Environments\BetaLimitedNetwork;
use Anthropic\Beta\Environments\BetaPackages;
use Anthropic\Beta\Environments\BetaSelfHostedConfig;
use Anthropic\Beta\Environments\BetaUnrestrictedNetwork;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Environment configuration (either Anthropic Cloud or self-hosted).
 *
 * @phpstan-import-type BetaCloudConfigShape from \Anthropic\Beta\Environments\BetaCloudConfig
 * @phpstan-import-type BetaSelfHostedConfigShape from \Anthropic\Beta\Environments\BetaSelfHostedConfig
 * @phpstan-import-type NetworkingShape from \Anthropic\Beta\Environments\BetaCloudConfig\Networking
 * @phpstan-import-type BetaPackagesShape from \Anthropic\Beta\Environments\BetaPackages
 *
 * @phpstan-type ConfigVariants = BetaCloudConfig|BetaSelfHostedConfig
 * @phpstan-type ConfigShape = ConfigVariants|BetaCloudConfigShape|BetaSelfHostedConfigShape
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
            'cloud' => BetaCloudConfig::class,
            'self_hosted' => BetaSelfHostedConfig::class,
        ];
    }

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @param NetworkingShape|null $networking
     * @param BetaPackages|BetaPackagesShape|null $packages
     *
     * @return ($type is Type::CLOUD|'cloud' ? BetaCloudConfig : ($type is Type::SELF_HOSTED|'self_hosted' ? BetaSelfHostedConfig : BetaCloudConfig|BetaSelfHostedConfig))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        BetaUnrestrictedNetwork|array|BetaLimitedNetwork|null $networking = null,
        BetaPackages|array|null $packages = null,
    ): BetaCloudConfig|BetaSelfHostedConfig {
        return match ($type) {
            Type::CLOUD, 'cloud' => BetaCloudConfig::with(
                networking: $networking ?? throw new \ArgumentCountError('$networking is required'),
                packages: $packages ?? throw new \ArgumentCountError('$packages is required'),
            ),
            Type::SELF_HOSTED, 'self_hosted' => BetaSelfHostedConfig::with(),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
