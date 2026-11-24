<?php

declare(strict_types=1);

namespace Anthropic\Beta\Compliance\Review\Items;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Why a message's content isn't returned.
 *
 * @phpstan-import-type BetaComplianceReviewContentNotCapturedShape from \Anthropic\Beta\Compliance\Review\Items\BetaComplianceReviewContentNotCaptured
 * @phpstan-import-type BetaComplianceReviewStoredCopyUnavailableShape from \Anthropic\Beta\Compliance\Review\Items\BetaComplianceReviewStoredCopyUnavailable
 *
 * @phpstan-type BetaComplianceReviewContentUnavailableReasonVariants = BetaComplianceReviewContentNotCaptured|BetaComplianceReviewStoredCopyUnavailable
 * @phpstan-type BetaComplianceReviewContentUnavailableReasonShape = BetaComplianceReviewContentUnavailableReasonVariants|BetaComplianceReviewContentNotCapturedShape|BetaComplianceReviewStoredCopyUnavailableShape
 */
final class BetaComplianceReviewContentUnavailableReason implements ConverterSource
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
            'not_captured' => BetaComplianceReviewContentNotCaptured::class,
            'stored_copy_unavailable' => BetaComplianceReviewStoredCopyUnavailable::class,
        ];
    }
}
