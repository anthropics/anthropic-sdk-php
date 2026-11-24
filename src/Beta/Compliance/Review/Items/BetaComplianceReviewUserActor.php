<?php

declare(strict_types=1);

namespace Anthropic\Beta\Compliance\Review\Items;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * A signed-in user.
 *
 * @phpstan-type BetaComplianceReviewUserActorShape = array{
 *   emailAddress: string|null, type: 'user_actor', userID: string
 * }
 */
final class BetaComplianceReviewUserActor implements BaseModel
{
    /** @use SdkModel<BetaComplianceReviewUserActorShape> */
    use SdkModel;

    /** @var 'user_actor' $type */
    #[Required(type: new ConstantOf('user_actor'))]
    public string $type = 'user_actor';

    /**
     * The user's email address. Set only for a current member of an organization that the API key can read.
     */
    #[Required('email_address')]
    public ?string $emailAddress;

    /**
     * The ID of the user (`user_...`).
     */
    #[Required('user_id')]
    public string $userID;

    /**
     * `new BetaComplianceReviewUserActor()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaComplianceReviewUserActor::with(emailAddress: ..., userID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaComplianceReviewUserActor())->withEmailAddress(...)->withUserID(...)
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
    public static function with(?string $emailAddress, string $userID): self
    {
        $self = new self;

        $self['emailAddress'] = $emailAddress;
        $self['userID'] = $userID;

        return $self;
    }

    /**
     * The user's email address. Set only for a current member of an organization that the API key can read.
     */
    public function withEmailAddress(?string $emailAddress): self
    {
        $self = clone $this;
        $self['emailAddress'] = $emailAddress;

        return $self;
    }

    /**
     * @param 'user_actor' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * The ID of the user (`user_...`).
     */
    public function withUserID(string $userID): self
    {
        $self = clone $this;
        $self['userID'] = $userID;

        return $self;
    }
}
