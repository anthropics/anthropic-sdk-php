<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\SpendLimits;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * A user within the organization. `name` and `email_address` are
 * null when the underlying account is unavailable or has been deleted;
 * `deleted` is true only for deleted accounts.
 *
 * @phpstan-type SpendLimitUserActorShape = array{
 *   deleted: bool,
 *   emailAddress: string|null,
 *   name: string|null,
 *   type: 'user_actor',
 *   userID: string,
 * }
 */
final class SpendLimitUserActor implements BaseModel
{
    /** @use SdkModel<SpendLimitUserActorShape> */
    use SdkModel;

    /**
     * Actor type. Always `user_actor`.
     *
     * @var 'user_actor' $type
     */
    #[Required(type: new ConstantOf('user_actor'))]
    public string $type = 'user_actor';

    /**
     * True only when the underlying account has been deleted.
     */
    #[Required]
    public bool $deleted;

    /**
     * The user's email address. Null when the account is unavailable or has been deleted.
     */
    #[Required('email_address')]
    public ?string $emailAddress;

    /**
     * The user's current display name. Null when the account is unavailable, has been deleted, or has no name set.
     */
    #[Required]
    public ?string $name;

    /**
     * Tagged ID of the user.
     */
    #[Required('user_id')]
    public string $userID;

    /**
     * `new SpendLimitUserActor()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * SpendLimitUserActor::with(
     *   deleted: ..., emailAddress: ..., name: ..., userID: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new SpendLimitUserActor())
     *   ->withDeleted(...)
     *   ->withEmailAddress(...)
     *   ->withName(...)
     *   ->withUserID(...)
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
    public static function with(
        ?string $emailAddress,
        ?string $name,
        string $userID,
        bool $deleted = false
    ): self {
        $self = new self;

        $self['deleted'] = $deleted;
        $self['emailAddress'] = $emailAddress;
        $self['name'] = $name;
        $self['userID'] = $userID;

        return $self;
    }

    /**
     * True only when the underlying account has been deleted.
     */
    public function withDeleted(bool $deleted): self
    {
        $self = clone $this;
        $self['deleted'] = $deleted;

        return $self;
    }

    /**
     * The user's email address. Null when the account is unavailable or has been deleted.
     */
    public function withEmailAddress(?string $emailAddress): self
    {
        $self = clone $this;
        $self['emailAddress'] = $emailAddress;

        return $self;
    }

    /**
     * The user's current display name. Null when the account is unavailable, has been deleted, or has no name set.
     */
    public function withName(?string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * Actor type. Always `user_actor`.
     *
     * @param 'user_actor' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * Tagged ID of the user.
     */
    public function withUserID(string $userID): self
    {
        $self = clone $this;
        $self['userID'] = $userID;

        return $self;
    }
}
