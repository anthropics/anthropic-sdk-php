<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\RBACGroups\Members;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Remove a User from an RBAC Group. Membership of groups provisioned by an identity provider (source type `"scim"`) cannot be modified via the API while an organization in the tenant uses SCIM provisioning.
 *
 * The RBAC Groups API is available to Claude Enterprise organizations only.
 *
 * @see Anthropic\Services\Beta\Organization\RBACGroups\MembersService::remove()
 *
 * @phpstan-type MemberRemoveParamsShape = array{rbacGroupID: string}
 */
final class MemberRemoveParams implements BaseModel
{
    /** @use SdkModel<MemberRemoveParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * ID of the RBAC Group.
     */
    #[Required]
    public string $rbacGroupID;

    /**
     * `new MemberRemoveParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * MemberRemoveParams::with(rbacGroupID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new MemberRemoveParams())->withRBACGroupID(...)
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
    public static function with(string $rbacGroupID): self
    {
        $self = new self;

        $self['rbacGroupID'] = $rbacGroupID;

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
}
