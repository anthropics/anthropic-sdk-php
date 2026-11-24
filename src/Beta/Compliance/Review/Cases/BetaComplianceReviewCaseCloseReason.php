<?php

declare(strict_types=1);

namespace Anthropic\Beta\Compliance\Review\Cases;

use Anthropic\Beta\Compliance\Review\Cases\BetaComplianceReviewCaseCloseReason\Type;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Why a review case closed.
 *
 * @phpstan-type BetaComplianceReviewCaseCloseReasonShape = array{
 *   type: Type|value-of<Type>
 * }
 */
final class BetaComplianceReviewCaseCloseReason implements BaseModel
{
    /** @use SdkModel<BetaComplianceReviewCaseCloseReasonShape> */
    use SdkModel;

    /**
     * `responded` means that Anthropic recorded a response. `window_ended` means that the time to respond ended with no response. `ended_by_anthropic` means that Anthropic ended the case before that time was over. New values can appear, so accept a value that you don't know.
     *
     * @var value-of<Type> $type
     */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * `new BetaComplianceReviewCaseCloseReason()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaComplianceReviewCaseCloseReason::with(type: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaComplianceReviewCaseCloseReason())->withType(...)
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
     * @param Type|value-of<Type> $type
     */
    public static function with(Type|string $type): self
    {
        $self = new self;

        $self['type'] = $type;

        return $self;
    }

    /**
     * `responded` means that Anthropic recorded a response. `window_ended` means that the time to respond ended with no response. `ended_by_anthropic` means that Anthropic ended the case before that time was over. New values can appear, so accept a value that you don't know.
     *
     * @param Type|value-of<Type> $type
     */
    public function withType(Type|string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
