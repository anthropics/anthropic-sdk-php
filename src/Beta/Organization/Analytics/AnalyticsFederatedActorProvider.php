<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Analytics;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-import-type AnalyticsFederatedActorAWSProviderShape from \Anthropic\Beta\Organization\Analytics\AnalyticsFederatedActorAWSProvider
 * @phpstan-import-type AnalyticsFederatedActorAzureProviderShape from \Anthropic\Beta\Organization\Analytics\AnalyticsFederatedActorAzureProvider
 * @phpstan-import-type AnalyticsFederatedActorGCPProviderShape from \Anthropic\Beta\Organization\Analytics\AnalyticsFederatedActorGCPProvider
 * @phpstan-import-type AnalyticsFederatedActorOIDCProviderShape from \Anthropic\Beta\Organization\Analytics\AnalyticsFederatedActorOIDCProvider
 *
 * @phpstan-type AnalyticsFederatedActorProviderVariants = AnalyticsFederatedActorAWSProvider|AnalyticsFederatedActorAzureProvider|AnalyticsFederatedActorGCPProvider|AnalyticsFederatedActorOIDCProvider
 * @phpstan-type AnalyticsFederatedActorProviderShape = AnalyticsFederatedActorProviderVariants|AnalyticsFederatedActorAWSProviderShape|AnalyticsFederatedActorAzureProviderShape|AnalyticsFederatedActorGCPProviderShape|AnalyticsFederatedActorOIDCProviderShape
 */
final class AnalyticsFederatedActorProvider implements ConverterSource
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
            'aws' => AnalyticsFederatedActorAWSProvider::class,
            'azure' => AnalyticsFederatedActorAzureProvider::class,
            'gcp' => AnalyticsFederatedActorGCPProvider::class,
            'oidc' => AnalyticsFederatedActorOIDCProvider::class,
        ];
    }
}
