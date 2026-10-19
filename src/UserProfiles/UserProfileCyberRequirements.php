<?php

declare(strict_types=1);

namespace Anthropic\UserProfiles;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * What a request that names the profile must allow to get the relaxed safeguards of the profile's `active` tiers. A field reads `true` when at least one of those tiers has the requirement and Anthropic has not waived it on that tier for the profile. A request that does not meet a requirement is still served, without the relaxed safeguards of the tiers that have it. The values differ between profiles and can change, so read them rather than assuming them.
 *
 * @phpstan-type UserProfileCyberRequirementsShape = array{
 *   dataRetention: bool, humanReview: bool
 * }
 */
final class UserProfileCyberRequirements implements BaseModel
{
    /** @use SdkModel<UserProfileCyberRequirementsShape> */
    use SdkModel;

    /**
     * Whether Anthropic must be able to retain the request's inference data.
     */
    #[Required('data_retention')]
    public bool $dataRetention;

    /**
     * Whether Anthropic personnel must be allowed to review the data retained from the request.
     */
    #[Required('human_review')]
    public bool $humanReview;

    /**
     * `new UserProfileCyberRequirements()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * UserProfileCyberRequirements::with(dataRetention: ..., humanReview: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new UserProfileCyberRequirements())
     *   ->withDataRetention(...)
     *   ->withHumanReview(...)
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
    public static function with(bool $dataRetention, bool $humanReview): self
    {
        $self = new self;

        $self['dataRetention'] = $dataRetention;
        $self['humanReview'] = $humanReview;

        return $self;
    }

    /**
     * Whether Anthropic must be able to retain the request's inference data.
     */
    public function withDataRetention(bool $dataRetention): self
    {
        $self = clone $this;
        $self['dataRetention'] = $dataRetention;

        return $self;
    }

    /**
     * Whether Anthropic personnel must be allowed to review the data retained from the request.
     */
    public function withHumanReview(bool $humanReview): self
    {
        $self = clone $this;
        $self['humanReview'] = $humanReview;

        return $self;
    }
}
