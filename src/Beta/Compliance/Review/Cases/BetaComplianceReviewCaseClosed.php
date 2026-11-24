<?php

declare(strict_types=1);

namespace Anthropic\Beta\Compliance\Review\Cases;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Anthropic has stopped waiting for a response. A closed case stays closed.
 *
 * @phpstan-import-type BetaComplianceReviewCaseCloseReasonShape from \Anthropic\Beta\Compliance\Review\Cases\BetaComplianceReviewCaseCloseReason
 *
 * @phpstan-type BetaComplianceReviewCaseClosedShape = array{
 *   reason: BetaComplianceReviewCaseCloseReason|BetaComplianceReviewCaseCloseReasonShape,
 *   type: 'closed',
 * }
 */
final class BetaComplianceReviewCaseClosed implements BaseModel
{
    /** @use SdkModel<BetaComplianceReviewCaseClosedShape> */
    use SdkModel;

    /** @var 'closed' $type */
    #[Required(type: new ConstantOf('closed'))]
    public string $type = 'closed';

    /**
     * Why the case closed. It doesn't change afterwards.
     */
    #[Required]
    public BetaComplianceReviewCaseCloseReason $reason;

    /**
     * `new BetaComplianceReviewCaseClosed()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaComplianceReviewCaseClosed::with(reason: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaComplianceReviewCaseClosed())->withReason(...)
     * ```
     */
    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param BetaComplianceReviewCaseCloseReason|BetaComplianceReviewCaseCloseReasonShape $reason
     */
    public static function with(
        BetaComplianceReviewCaseCloseReason|array $reason
    ): self {
        $self = new self;

        $self['reason'] = $reason;

        return $self;
    }

    /**
     * Why the case closed. It doesn't change afterwards.
     *
     * @param BetaComplianceReviewCaseCloseReason|BetaComplianceReviewCaseCloseReasonShape $reason
     */
    public function withReason(
        BetaComplianceReviewCaseCloseReason|array $reason
    ): self {
        $self = clone $this;
        $self['reason'] = $reason;

        return $self;
    }

    /**
     * @param 'closed' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
