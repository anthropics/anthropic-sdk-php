<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ExternalStorage\ExternalStorageCreateParams;

use Anthropic\Beta\Organization\ExternalStorage\AWSExternalStorageConfigParam;
use Anthropic\Beta\Organization\ExternalStorage\ExternalStorageCreateParams\ProviderConfig\Type;
use Anthropic\Beta\Organization\ExternalStorage\GCPExternalStorageConfigParam;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-import-type AWSExternalStorageConfigParamShape from \Anthropic\Beta\Organization\ExternalStorage\AWSExternalStorageConfigParam
 * @phpstan-import-type GCPExternalStorageConfigParamShape from \Anthropic\Beta\Organization\ExternalStorage\GCPExternalStorageConfigParam
 *
 * @phpstan-type ProviderConfigVariants = AWSExternalStorageConfigParam|GCPExternalStorageConfigParam
 * @phpstan-type ProviderConfigShape = ProviderConfigVariants|AWSExternalStorageConfigParamShape|GCPExternalStorageConfigParamShape
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
            'aws' => AWSExternalStorageConfigParam::class,
            'gcp' => GCPExternalStorageConfigParam::class,
        ];
    }

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @return ($type is Type::AWS|'aws' ? AWSExternalStorageConfigParam : ($type is Type::GCP|'gcp' ? GCPExternalStorageConfigParam : AWSExternalStorageConfigParam|GCPExternalStorageConfigParam))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        string $bucketName,
        string $region,
        ?string $accountID = null,
        ?string $projectNumber = null,
    ): AWSExternalStorageConfigParam|GCPExternalStorageConfigParam {
        return match ($type) {
            Type::AWS, 'aws' => AWSExternalStorageConfigParam::with(
                accountID: $accountID ?? throw new \ArgumentCountError('$accountID is required'),
                bucketName: $bucketName,
                region: $region,
            ),
            Type::GCP, 'gcp' => GCPExternalStorageConfigParam::with(
                bucketName: $bucketName,
                projectNumber: $projectNumber ?? throw new \ArgumentCountError('$projectNumber is required'),
                region: $region,
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
