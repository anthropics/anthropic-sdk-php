<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ExternalStorage\ExternalStorage;

use Anthropic\Beta\Organization\ExternalStorage\AWSExternalStorageConfig;
use Anthropic\Beta\Organization\ExternalStorage\GCPExternalStorageConfig;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-import-type AWSExternalStorageConfigShape from \Anthropic\Beta\Organization\ExternalStorage\AWSExternalStorageConfig
 * @phpstan-import-type GCPExternalStorageConfigShape from \Anthropic\Beta\Organization\ExternalStorage\GCPExternalStorageConfig
 *
 * @phpstan-type ProviderConfigVariants = AWSExternalStorageConfig|GCPExternalStorageConfig
 * @phpstan-type ProviderConfigShape = ProviderConfigVariants|AWSExternalStorageConfigShape|GCPExternalStorageConfigShape
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
            'aws' => AWSExternalStorageConfig::class,
            'gcp' => GCPExternalStorageConfig::class,
        ];
    }
}
