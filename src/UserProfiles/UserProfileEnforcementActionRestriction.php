<?php

declare(strict_types=1);

namespace Anthropic\UserProfiles;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * Anthropic has limited how it serves the end user until the action is resolved. The end user may still be served in part.
 *
 * @phpstan-type UserProfileEnforcementActionRestrictionShape = array{
 *   id: string,
 *   action: null|UserProfileEnforcementActionNextStep|value-of<UserProfileEnforcementActionNextStep>,
 *   expiresAt: \DateTimeInterface|null,
 *   openedAt: \DateTimeInterface,
 *   reason: UserProfileEnforcementActionReason|value-of<UserProfileEnforcementActionReason>,
 *   type: 'restriction',
 * }
 */
final class UserProfileEnforcementActionRestriction implements BaseModel
{
    /** @use SdkModel<UserProfileEnforcementActionRestrictionShape> */
    use SdkModel;

    /** @var 'restriction' $type */
    #[Required(type: new ConstantOf('restriction'))]
    public string $type = 'restriction';

    /**
     * The action's ID (`enac_...`), stable while the action is open.
     */
    #[Required]
    public string $id;

    /**
     * The next step on the action: `verify` or `null`. `verify`: the end user can clear it now by passing an identity check. `null`: there is nothing the end user can do now to clear it, including while Anthropic reviews an identity check the end user submitted.
     *
     * @var value-of<UserProfileEnforcementActionNextStep>|null $action
     */
    #[Required(enum: UserProfileEnforcementActionNextStep::class)]
    public ?string $action;

    /**
     * When the action ends on its own, in RFC 3339 format; it stops showing once this time has passed. `null` when it has no end date, and always `null` when `reason` is `account_compromise`.
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
     * `new UserProfileEnforcementActionRestriction()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * UserProfileEnforcementActionRestriction::with(
     *   id: ..., action: ..., expiresAt: ..., openedAt: ..., reason: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new UserProfileEnforcementActionRestriction())
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
     * The next step on the action: `verify` or `null`. `verify`: the end user can clear it now by passing an identity check. `null`: there is nothing the end user can do now to clear it, including while Anthropic reviews an identity check the end user submitted.
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
     * When the action ends on its own, in RFC 3339 format; it stops showing once this time has passed. `null` when it has no end date, and always `null` when `reason` is `account_compromise`.
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
     * @param 'restriction' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
