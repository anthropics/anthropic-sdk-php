<?php

declare(strict_types=1);

namespace Anthropic\Beta\Environments\EnvironmentCreateParams;

use Anthropic\Beta\Environments\BetaCloudConfigParams;
use Anthropic\Beta\Environments\BetaSelfHostedConfigParams;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Environment configuration.
 *
 * @phpstan-import-type BetaCloudConfigParamsShape from \Anthropic\Beta\Environments\BetaCloudConfigParams
 * @phpstan-import-type BetaSelfHostedConfigParamsShape from \Anthropic\Beta\Environments\BetaSelfHostedConfigParams
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
}
