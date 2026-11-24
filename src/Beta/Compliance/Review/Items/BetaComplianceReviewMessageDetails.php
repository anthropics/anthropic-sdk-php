<?php

declare(strict_types=1);

namespace Anthropic\Beta\Compliance\Review\Items;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * A message sent to Claude.
 *
 * @phpstan-import-type BetaComplianceReviewCreateMessageContentShape from \Anthropic\Beta\Compliance\Review\Items\BetaComplianceReviewCreateMessageContent
 * @phpstan-import-type BetaComplianceReviewContentUnavailableReasonShape from \Anthropic\Beta\Compliance\Review\Items\BetaComplianceReviewContentUnavailableReason
 * @phpstan-import-type BetaComplianceReviewContentUnavailableReasonVariants from \Anthropic\Beta\Compliance\Review\Items\BetaComplianceReviewContentUnavailableReason
 *
 * @phpstan-type BetaComplianceReviewMessageDetailsShape = array{
 *   content: null|BetaComplianceReviewCreateMessageContent|BetaComplianceReviewCreateMessageContentShape,
 *   contentUnavailableReason: BetaComplianceReviewContentUnavailableReasonShape|null,
 *   model: string|null,
 *   type: 'message',
 * }
 */
final class BetaComplianceReviewMessageDetails implements BaseModel
{
    /** @use SdkModel<BetaComplianceReviewMessageDetailsShape> */
    use SdkModel;

    /** @var 'message' $type */
    #[Required(type: new ConstantOf('message'))]
    public string $type = 'message';

    /**
     * The stored request and response. Null when `content_unavailable_reason` is set. New types can appear, so accept a type that you don't know.
     */
    #[Required]
    public ?BetaComplianceReviewCreateMessageContent $content;

    /**
     * Why `content` is null. Null when `content` is set. New types can appear, so accept a type that you don't know.
     *
     * @var BetaComplianceReviewContentUnavailableReasonVariants|null $contentUnavailableReason
     */
    #[Required(
        'content_unavailable_reason',
        union: BetaComplianceReviewContentUnavailableReason::class,
    )]
    public BetaComplianceReviewContentNotCaptured|BetaComplianceReviewStoredCopyUnavailable|null $contentUnavailableReason;

    /**
     * The model that the call named. Null when none was recorded.
     */
    #[Required]
    public ?string $model;

    /**
     * `new BetaComplianceReviewMessageDetails()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaComplianceReviewMessageDetails::with(
     *   content: ..., contentUnavailableReason: ..., model: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaComplianceReviewMessageDetails())
     *   ->withContent(...)
     *   ->withContentUnavailableReason(...)
     *   ->withModel(...)
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
     * @param BetaComplianceReviewCreateMessageContent|BetaComplianceReviewCreateMessageContentShape|null $content
     * @param BetaComplianceReviewContentUnavailableReasonShape|null $contentUnavailableReason
     */
    public static function with(
        BetaComplianceReviewCreateMessageContent|array|null $content,
        BetaComplianceReviewContentNotCaptured|array|BetaComplianceReviewStoredCopyUnavailable|null $contentUnavailableReason,
        ?string $model,
    ): self {
        $self = new self;

        $self['content'] = $content;
        $self['contentUnavailableReason'] = $contentUnavailableReason;
        $self['model'] = $model;

        return $self;
    }

    /**
     * The stored request and response. Null when `content_unavailable_reason` is set. New types can appear, so accept a type that you don't know.
     *
     * @param BetaComplianceReviewCreateMessageContent|BetaComplianceReviewCreateMessageContentShape|null $content
     */
    public function withContent(
        BetaComplianceReviewCreateMessageContent|array|null $content
    ): self {
        $self = clone $this;
        $self['content'] = $content;

        return $self;
    }

    /**
     * Why `content` is null. Null when `content` is set. New types can appear, so accept a type that you don't know.
     *
     * @param BetaComplianceReviewContentUnavailableReasonShape|null $contentUnavailableReason
     */
    public function withContentUnavailableReason(
        BetaComplianceReviewContentNotCaptured|array|BetaComplianceReviewStoredCopyUnavailable|null $contentUnavailableReason,
    ): self {
        $self = clone $this;
        $self['contentUnavailableReason'] = $contentUnavailableReason;

        return $self;
    }

    /**
     * The model that the call named. Null when none was recorded.
     */
    public function withModel(?string $model): self
    {
        $self = clone $this;
        $self['model'] = $model;

        return $self;
    }

    /**
     * @param 'message' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
