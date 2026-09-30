<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\RBACGroups\Members;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * @phpstan-type MemberRemoveResponseShape = array{
 *   rbacGroupID: string, type: 'rbac_group_member_deleted', userID: string
 * }
 */
final class MemberRemoveResponse implements BaseModel
{
    /** @use SdkModel<MemberRemoveResponseShape> */
    use SdkModel;

    /**
     * Deleted object type. For RBAC Group Members, this is always `"rbac_group_member_deleted"`.
     *
     * @var 'rbac_group_member_deleted' $type
     */
    #[Required(type: new ConstantOf('rbac_group_member_deleted'))]
    public string $type = 'rbac_group_member_deleted';

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
     * `new MemberRemoveResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * MemberRemoveResponse::with(rbacGroupID: ..., userID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new MemberRemoveResponse)->withRBACGroupID(...)->withUserID(...)
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
    public static function with(string $rbacGroupID, string $userID): self
    {
        $self = new self;

        $self['rbacGroupID'] = $rbacGroupID;
        $self['userID'] = $userID;

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
     * Deleted object type. For RBAC Group Members, this is always `"rbac_group_member_deleted"`.
     *
     * @param 'rbac_group_member_deleted' $type
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
