<?php

declare(strict_types=1);

namespace Anthropic\Beta\Environments\BetaEnvironment;

use Anthropic\Beta\Environments\BetaCloudConfig;
use Anthropic\Beta\Environments\BetaSelfHostedConfig;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Environment configuration (either Anthropic Cloud or self-hosted).
 *
 * @phpstan-import-type BetaCloudConfigShape from \Anthropic\Beta\Environments\BetaCloudConfig
 * @phpstan-import-type BetaSelfHostedConfigShape from \Anthropic\Beta\Environments\BetaSelfHostedConfig
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
}
