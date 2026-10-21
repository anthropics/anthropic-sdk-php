<?php

declare(strict_types=1);

namespace Anthropic\UserProfiles;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Anthropic has stopped serving the end user where the ban applies and does not plan to serve them there again.
 *
 * @phpstan-type UserProfileEnforcementActionBanShape = array{
 *   id: string,
 *   action: null|UserProfileEnforcementActionNextStep|value-of<UserProfileEnforcementActionNextStep>,
 *   expiresAt: \DateTimeInterface|null,
 *   openedAt: \DateTimeInterface,
 *   reason: UserProfileEnforcementActionReason|value-of<UserProfileEnforcementActionReason>,
 *   type: 'ban',
 * }
 */
final class UserProfileEnforcementActionBan implements BaseModel
{
    /** @use SdkModel<UserProfileEnforcementActionBanShape> */
    use SdkModel;

    /** @var 'ban' $type */
    #[Required(type: new ConstantOf('ban'))]
    public string $type = 'ban';

    /**
     * The action's ID (`enac_...`), stable while the action is open.
     */
    #[Required]
    public string $id;

    /**
     * Always `null`: the end user cannot clear a ban.
     *
     * @var value-of<UserProfileEnforcementActionNextStep>|null $action
     */
    #[Required(enum: UserProfileEnforcementActionNextStep::class)]
    public ?string $action;

    /**
     * Always `null`: a ban has no end date.
     */
    #[Required('expires_at')]
    public ?\DateTimeInterface $expiresAt;

    /**
     * When Anthropic opened the action, in RFC 3339 format.
     */
    #[Required('opened_at')]
    public \DateTimeInterface $openedAt;

    /**
     * Why Anthropic placed the limit: `unsupported_region`, `fraud_or_abuse`, `high_harm`, `usage_policy_violation`, `account_compromise` or `unspecified`.
     *
     * @var value-of<UserProfileEnforcementActionReason> $reason
     */
    #[Required(enum: UserProfileEnforcementActionReason::class)]
    public string $reason;

    /**
     * `new UserProfileEnforcementActionBan()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * UserProfileEnforcementActionBan::with(
     *   id: ..., action: ..., expiresAt: ..., openedAt: ..., reason: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new UserProfileEnforcementActionBan())
     *   ->withID(...)
     *   ->withAction(...)
     *   ->withExpiresAt(...)
     *   ->withOpenedAt(...)
     *   ->withReason(...)
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
     * @param UserProfileEnforcementActionNextStep|value-of<UserProfileEnforcementActionNextStep>|null $action
     * @param UserProfileEnforcementActionReason|value-of<UserProfileEnforcementActionReason> $reason
     */
    public static function with(
        string $id,
        UserProfileEnforcementActionNextStep|string|null $action,
        ?\DateTimeInterface $expiresAt,
        \DateTimeInterface $openedAt,
        UserProfileEnforcementActionReason|string $reason,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['action'] = $action;
        $self['expiresAt'] = $expiresAt;
        $self['openedAt'] = $openedAt;
        $self['reason'] = $reason;

        return $self;
    }

    /**
     * The action's ID (`enac_...`), stable while the action is open.
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * Always `null`: the end user cannot clear a ban.
     *
     * @param UserProfileEnforcementActionNextStep|value-of<UserProfileEnforcementActionNextStep>|null $action
     */
    public function withAction(
        UserProfileEnforcementActionNextStep|string|null $action
    ): self {
        $self = clone $this;
        $self['action'] = $action;

        return $self;
    }

    /**
     * Always `null`: a ban has no end date.
     */
    public function withExpiresAt(?\DateTimeInterface $expiresAt): self
    {
        $self = clone $this;
        $self['expiresAt'] = $expiresAt;

        return $self;
    }

    /**
     * When Anthropic opened the action, in RFC 3339 format.
     */
    public function withOpenedAt(\DateTimeInterface $openedAt): self
    {
        $self = clone $this;
        $self['openedAt'] = $openedAt;

        return $self;
    }

    /**
     * Why Anthropic placed the limit: `unsupported_region`, `fraud_or_abuse`, `high_harm`, `usage_policy_violation`, `account_compromise` or `unspecified`.
     *
     * @param UserProfileEnforcementActionReason|value-of<UserProfileEnforcementActionReason> $reason
     */
    public function withReason(
        UserProfileEnforcementActionReason|string $reason
    ): self {
        $self = clone $this;
        $self['reason'] = $reason;

        return $self;
    }

    /**
     * @param 'ban' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
