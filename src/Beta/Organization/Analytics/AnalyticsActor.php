<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Analytics;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-import-type AnalyticsReportUserActorShape from \Anthropic\Beta\Organization\Analytics\AnalyticsReportUserActor
 * @phpstan-import-type AnalyticsServiceAccountActorShape from \Anthropic\Beta\Organization\Analytics\AnalyticsServiceAccountActor
 * @phpstan-import-type AnalyticsFederatedActorShape from \Anthropic\Beta\Organization\Analytics\AnalyticsFederatedActor
 * @phpstan-import-type AnalyticsAPIActorShape from \Anthropic\Beta\Organization\Analytics\AnalyticsAPIActor
 *
 * @phpstan-type AnalyticsActorVariants = AnalyticsReportUserActor|AnalyticsServiceAccountActor|AnalyticsFederatedActor|AnalyticsAPIActor
 * @phpstan-type AnalyticsActorShape = AnalyticsActorVariants|AnalyticsReportUserActorShape|AnalyticsServiceAccountActorShape|AnalyticsFederatedActorShape|AnalyticsAPIActorShape
 */
final class AnalyticsActor implements ConverterSource
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
            'user_actor' => AnalyticsReportUserActor::class,
            'service_account_actor' => AnalyticsServiceAccountActor::class,
            'federated_actor' => AnalyticsFederatedActor::class,
            'api_actor' => AnalyticsAPIActor::class,
        ];
    }
}
