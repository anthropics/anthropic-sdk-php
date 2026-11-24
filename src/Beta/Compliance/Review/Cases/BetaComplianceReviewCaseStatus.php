<?php

declare(strict_types=1);

namespace Anthropic\Beta\Compliance\Review\Cases;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * The status of a review case.
 *
 * @phpstan-import-type BetaComplianceReviewCaseOpenShape from \Anthropic\Beta\Compliance\Review\Cases\BetaComplianceReviewCaseOpen
 * @phpstan-import-type BetaComplianceReviewCaseClosedShape from \Anthropic\Beta\Compliance\Review\Cases\BetaComplianceReviewCaseClosed
 *
 * @phpstan-type BetaComplianceReviewCaseStatusVariants = BetaComplianceReviewCaseOpen|BetaComplianceReviewCaseClosed
 * @phpstan-type BetaComplianceReviewCaseStatusShape = BetaComplianceReviewCaseStatusVariants|BetaComplianceReviewCaseOpenShape|BetaComplianceReviewCaseClosedShape
 */
final class BetaComplianceReviewCaseStatus implements ConverterSource
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
            'open' => BetaComplianceReviewCaseOpen::class,
            'closed' => BetaComplianceReviewCaseClosed::class,
        ];
    }
}
