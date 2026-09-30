<?php

declare(strict_types=1);

namespace Anthropic\Organization\ExternalKeys\ExternalKey;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Organization\ExternalKeys\AWSExternalKeyConfig;
use Anthropic\Organization\ExternalKeys\AzureExternalKeyConfig;
use Anthropic\Organization\ExternalKeys\GCPExternalKeyConfig;

/**
 * KMS provider identity and auth coordinates.
 *
 * @phpstan-import-type AWSExternalKeyConfigShape from \Anthropic\Organization\ExternalKeys\AWSExternalKeyConfig
 * @phpstan-import-type GCPExternalKeyConfigShape from \Anthropic\Organization\ExternalKeys\GCPExternalKeyConfig
 * @phpstan-import-type AzureExternalKeyConfigShape from \Anthropic\Organization\ExternalKeys\AzureExternalKeyConfig
 *
 * @phpstan-type ProviderConfigVariants = AWSExternalKeyConfig|GCPExternalKeyConfig|AzureExternalKeyConfig
 * @phpstan-type ProviderConfigShape = ProviderConfigVariants|AWSExternalKeyConfigShape|GCPExternalKeyConfigShape|AzureExternalKeyConfigShape
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
            'azure' => AzureExternalKeyConfig::class,
        ];
    }
}
