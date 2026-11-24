<?php

declare(strict_types=1);

namespace Anthropic\Beta\Compliance\Review\Items;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Who sent a message.
 *
 * @phpstan-import-type BetaComplianceReviewUserActorShape from \Anthropic\Beta\Compliance\Review\Items\BetaComplianceReviewUserActor
 * @phpstan-import-type BetaComplianceReviewAPIActorShape from \Anthropic\Beta\Compliance\Review\Items\BetaComplianceReviewAPIActor
 * @phpstan-import-type BetaComplianceReviewServiceAccountActorShape from \Anthropic\Beta\Compliance\Review\Items\BetaComplianceReviewServiceAccountActor
 *
 * @phpstan-type BetaComplianceReviewActorVariants = BetaComplianceReviewUserActor|BetaComplianceReviewAPIActor|BetaComplianceReviewServiceAccountActor
 * @phpstan-type BetaComplianceReviewActorShape = BetaComplianceReviewActorVariants|BetaComplianceReviewUserActorShape|BetaComplianceReviewAPIActorShape|BetaComplianceReviewServiceAccountActorShape
 */
final class BetaComplianceReviewActor implements ConverterSource
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
            'user_actor' => BetaComplianceReviewUserActor::class,
            'api_actor' => BetaComplianceReviewAPIActor::class,
            'service_account_actor' => BetaComplianceReviewServiceAccountActor::class,
        ];
    }
}
