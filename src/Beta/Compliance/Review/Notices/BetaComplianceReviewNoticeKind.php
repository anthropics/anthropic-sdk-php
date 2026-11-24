<?php

declare(strict_types=1);

namespace Anthropic\Beta\Compliance\Review\Notices;

use Anthropic\Beta\Compliance\Review\Notices\BetaComplianceReviewNoticeKind\Type;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * The kind of a review notice.
 *
 * @phpstan-type BetaComplianceReviewNoticeKindShape = array{
 *   type: Type|value-of<Type>
 * }
 */
final class BetaComplianceReviewNoticeKind implements BaseModel
{
    /** @use SdkModel<BetaComplianceReviewNoticeKindShape> */
    use SdkModel;

    /**
     * `response_requested` asks you to respond to the cases in `case_ids`. For `warning` and `question`, `message` explains how to answer if an answer is needed. New values can appear, so accept a value that you don't know.
     *
     * @var value-of<Type> $type
     */
    #[Required(enum: Type::class)]
    public string $type;

    /**
     * `new BetaComplianceReviewNoticeKind()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaComplianceReviewNoticeKind::with(type: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaComplianceReviewNoticeKind())->withType(...)
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
     * `response_requested` asks you to respond to the cases in `case_ids`. For `warning` and `question`, `message` explains how to answer if an answer is needed. New values can appear, so accept a value that you don't know.
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
