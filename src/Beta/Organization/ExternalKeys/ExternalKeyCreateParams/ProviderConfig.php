<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ExternalKeys\ExternalKeyCreateParams;

use Anthropic\Beta\Organization\ExternalKeys\AWSExternalKeyConfig;
use Anthropic\Beta\Organization\ExternalKeys\AzureExternalKeyConfigParam;
use Anthropic\Beta\Organization\ExternalKeys\GCPExternalKeyConfig;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * KMS provider identity and auth coordinates.
 *
 * @phpstan-import-type AWSExternalKeyConfigShape from \Anthropic\Beta\Organization\ExternalKeys\AWSExternalKeyConfig
 * @phpstan-import-type GCPExternalKeyConfigShape from \Anthropic\Beta\Organization\ExternalKeys\GCPExternalKeyConfig
 * @phpstan-import-type AzureExternalKeyConfigParamShape from \Anthropic\Beta\Organization\ExternalKeys\AzureExternalKeyConfigParam
 *
 * @phpstan-type ProviderConfigVariants = AWSExternalKeyConfig|GCPExternalKeyConfig|AzureExternalKeyConfigParam
 * @phpstan-type ProviderConfigShape = ProviderConfigVariants|AWSExternalKeyConfigShape|GCPExternalKeyConfigShape|AzureExternalKeyConfigParamShape
 */
final class ProviderConfig implements ConverterSource
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
            'aws' => AWSExternalKeyConfig::class,
            'gcp' => GCPExternalKeyConfig::class,
            'azure' => AzureExternalKeyConfigParam::class,
        ];
    }
}
