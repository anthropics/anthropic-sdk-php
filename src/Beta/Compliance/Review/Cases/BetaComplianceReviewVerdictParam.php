<?php

declare(strict_types=1);

namespace Anthropic\Beta\Compliance\Review\Cases;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Your conclusion on one message of a review case.
 *
 * @phpstan-type BetaComplianceReviewVerdictParamShape = array{
 *   determination: BetaComplianceReviewDetermination|value-of<BetaComplianceReviewDetermination>,
 *   itemID: string,
 *   policyCategory?: null|BetaComplianceReviewViolatedPolicyCategory|value-of<BetaComplianceReviewViolatedPolicyCategory>,
 * }
 */
final class BetaComplianceReviewVerdictParam implements BaseModel
{
    /** @use SdkModel<BetaComplianceReviewVerdictParamShape> */
    use SdkModel;

    /**
     * Your conclusion on this message.
     *
     * @var value-of<BetaComplianceReviewDetermination> $determination
     */
    #[Required(enum: BetaComplianceReviewDetermination::class)]
    public string $determination;

    /**
     * The `item_id` of one of the case's `transcripts`.
     */
    #[Required('item_id')]
    public string $itemID;

    /**
     * The policy category that this message violated, from the values that the request's `policy_categories` accepts. Optional with `violation`. Leave it out with `no_violation`.
     *
     * @var value-of<BetaComplianceReviewViolatedPolicyCategory>|null $policyCategory
     */
    #[Optional(
        'policy_category',
        enum: BetaComplianceReviewViolatedPolicyCategory::class,
        nullable: true,
    )]
    public ?string $policyCategory;

    /**
     * `new BetaComplianceReviewVerdictParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaComplianceReviewVerdictParam::with(determination: ..., itemID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaComplianceReviewVerdictParam())
     *   ->withDetermination(...)
     *   ->withItemID(...)
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
     * @param BetaComplianceReviewDetermination|value-of<BetaComplianceReviewDetermination> $determination
     * @param BetaComplianceReviewViolatedPolicyCategory|value-of<BetaComplianceReviewViolatedPolicyCategory>|null $policyCategory
     */
    public static function with(
        BetaComplianceReviewDetermination|string $determination,
        string $itemID,
        BetaComplianceReviewViolatedPolicyCategory|string|null $policyCategory = null,
    ): self {
        $self = new self;

        $self['determination'] = $determination;
        $self['itemID'] = $itemID;

        null !== $policyCategory && $self['policyCategory'] = $policyCategory;

        return $self;
    }

    /**
     * Your conclusion on this message.
     *
     * @param BetaComplianceReviewDetermination|value-of<BetaComplianceReviewDetermination> $determination
     */
    public function withDetermination(
        BetaComplianceReviewDetermination|string $determination
    ): self {
        $self = clone $this;
        $self['determination'] = $determination;

        return $self;
    }

    /**
     * The `item_id` of one of the case's `transcripts`.
     */
    public function withItemID(string $itemID): self
    {
        $self = clone $this;
        $self['itemID'] = $itemID;

        return $self;
    }

    /**
     * The policy category that this message violated, from the values that the request's `policy_categories` accepts. Optional with `violation`. Leave it out with `no_violation`.
     *
     * @param BetaComplianceReviewViolatedPolicyCategory|value-of<BetaComplianceReviewViolatedPolicyCategory>|null $policyCategory
     */
    public function withPolicyCategory(
        BetaComplianceReviewViolatedPolicyCategory|string|null $policyCategory
    ): self {
        $self = clone $this;
        $self['policyCategory'] = $policyCategory;

        return $self;
    }
}
