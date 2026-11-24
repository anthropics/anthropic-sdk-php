<?php

declare(strict_types=1);

namespace Anthropic\Beta\Compliance\Review\Cases;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * One flagged message of a review case.
 *
 * @phpstan-type BetaComplianceReviewTranscriptShape = array{
 *   itemID: string, userProfileID: string|null
 * }
 */
final class BetaComplianceReviewTranscript implements BaseModel
{
    /** @use SdkModel<BetaComplianceReviewTranscriptShape> */
    use SdkModel;

    /**
     * The ID of the flagged message.
     */
    #[Required('item_id')]
    public string $itemID;

    /**
     * The ID of the user profile that the message belongs to. Null when the message belongs to none, or when the profile can no longer be looked up.
     */
    #[Required('user_profile_id')]
    public ?string $userProfileID;

    /**
     * `new BetaComplianceReviewTranscript()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaComplianceReviewTranscript::with(itemID: ..., userProfileID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaComplianceReviewTranscript())->withItemID(...)->withUserProfileID(...)
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
     */
    public static function with(string $itemID, ?string $userProfileID): self
    {
        $self = new self;

        $self['itemID'] = $itemID;
        $self['userProfileID'] = $userProfileID;

        return $self;
    }

    /**
     * The ID of the flagged message.
     */
    public function withItemID(string $itemID): self
    {
        $self = clone $this;
        $self['itemID'] = $itemID;

        return $self;
    }

    /**
     * The ID of the user profile that the message belongs to. Null when the message belongs to none, or when the profile can no longer be looked up.
     */
    public function withUserProfileID(?string $userProfileID): self
    {
        $self = clone $this;
        $self['userProfileID'] = $userProfileID;

        return $self;
    }
}
