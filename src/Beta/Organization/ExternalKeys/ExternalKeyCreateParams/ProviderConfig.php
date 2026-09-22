<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ExternalKeys\ExternalKeyCreateParams;

use Anthropic\Beta\Organization\ExternalKeys\AWSExternalKeyConfig;
use Anthropic\Beta\Organization\ExternalKeys\AzureExternalKeyConfigParam;
use Anthropic\Beta\Organization\ExternalKeys\ExternalKeyCreateParams\ProviderConfig\Type;
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

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @return ($type is Type::AWS|'aws' ? AWSExternalKeyConfig : ($type is Type::GCP|'gcp' ? GCPExternalKeyConfig : ($type is Type::AZURE|'azure' ? AzureExternalKeyConfigParam : AWSExternalKeyConfig|GCPExternalKeyConfig|AzureExternalKeyConfigParam)))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        ?string $kmsARN = null,
        ?string $region = null,
        ?string $roleARN = null,
        ?string $keyName = null,
        ?string $tenantID = null,
        ?string $vaultURI = null,
        ?string $clientID = null,
    ): AWSExternalKeyConfig|GCPExternalKeyConfig|AzureExternalKeyConfigParam {
        return match ($type) {
            Type::AWS, 'aws' => AWSExternalKeyConfig::with(
                kmsARN: $kmsARN ?? throw new \ArgumentCountError('$kmsARN is required'),
                region: $region,
                roleARN: $roleARN,
            ),
            Type::GCP, 'gcp' => GCPExternalKeyConfig::with(
                keyName: $keyName ?? throw new \ArgumentCountError('$keyName is required'),
            ),
            Type::AZURE, 'azure' => AzureExternalKeyConfigParam::with(
                keyName: $keyName ?? throw new \ArgumentCountError('$keyName is required'),
                tenantID: $tenantID ?? throw new \ArgumentCountError('$tenantID is required'),
                vaultURI: $vaultURI ?? throw new \ArgumentCountError('$vaultURI is required'),
                clientID: $clientID,
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
