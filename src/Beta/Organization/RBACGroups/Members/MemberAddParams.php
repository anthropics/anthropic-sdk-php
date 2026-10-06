<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\RBACGroups\Members;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Add a User to an RBAC Group. Membership of groups provisioned by an identity provider (source type `"scim"`) cannot be modified via the API while an organization in the tenant uses SCIM provisioning.
 *
 * The RBAC Groups API is available to Claude Enterprise organizations only.
 *
 * @see Anthropic\Services\Beta\Organization\RBACGroups\MembersService::add()
 *
 * @phpstan-type MemberAddParamsShape = array{userID: string}
 */
final class MemberAddParams implements BaseModel
{
    /** @use SdkModel<MemberAddParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * ID of the User.
     */
    #[Required('user_id')]
    public string $userID;

    /**
     * `new MemberAddParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * MemberAddParams::with(userID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new MemberAddParams())->withUserID(...)
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
    public static function with(string $userID): self
    {
        $self = new self;

        $self['userID'] = $userID;

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
