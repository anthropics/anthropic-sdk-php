<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\RBACGroups\Members;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * @phpstan-type BetaRBACGroupMemberShape = array{
 *   createdAt: \DateTimeInterface,
 *   email: string,
 *   rbacGroupID: string,
 *   type: 'rbac_group_member',
 *   userID: string,
 * }
 */
final class BetaRBACGroupMember implements BaseModel
{
    /** @use SdkModel<BetaRBACGroupMemberShape> */
    use SdkModel;

    /**
     * Object type.
     *
     * For RBAC Group Members, this is always `"rbac_group_member"`.
     *
     * @var 'rbac_group_member' $type
     */
    #[Required(type: new ConstantOf('rbac_group_member'))]
    public string $type = 'rbac_group_member';

    /**
     * RFC 3339 timestamp of when the User was added to the RBAC Group.
     */
    #[Required('created_at')]
    public \DateTimeInterface $createdAt;

    /**
     * Email of the User.
     */
    #[Required]
    public string $email;

    /**
     * ID of the RBAC Group.
     */
    #[Required('rbac_group_id')]
    public string $rbacGroupID;

    /**
     * ID of the User.
     */
    #[Required('user_id')]
    public string $userID;

    /**
     * `new BetaRBACGroupMember()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaRBACGroupMember::with(
     *   createdAt: ..., email: ..., rbacGroupID: ..., userID: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaRBACGroupMember)
     *   ->withCreatedAt(...)
     *   ->withEmail(...)
     *   ->withRBACGroupID(...)
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
        \DateTimeInterface $createdAt,
        string $email,
        string $rbacGroupID,
        string $userID,
    ): self {
        $self = new self;

        $self['createdAt'] = $createdAt;
        $self['email'] = $email;
        $self['rbacGroupID'] = $rbacGroupID;
        $self['userID'] = $userID;

        return $self;
    }

    /**
     * RFC 3339 timestamp of when the User was added to the RBAC Group.
     */
    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    /**
     * Email of the User.
     */
    public function withEmail(string $email): self
    {
        $self = clone $this;
        $self['email'] = $email;

        return $self;
    }

    /**
     * ID of the RBAC Group.
     */
    public function withRBACGroupID(string $rbacGroupID): self
    {
        $self = clone $this;
        $self['rbacGroupID'] = $rbacGroupID;

        return $self;
    }

    /**
     * Object type.
     *
     * For RBAC Group Members, this is always `"rbac_group_member"`.
     *
     * @param 'rbac_group_member' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * ID of the User.
     */
    public function withUserID(string $userID): self
    {
        $self = clone $this;
        $self['userID'] = $userID;

        return $self;
    }
}
