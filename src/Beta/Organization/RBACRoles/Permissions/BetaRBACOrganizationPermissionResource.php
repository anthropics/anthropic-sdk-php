<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\RBACRoles\Permissions;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * @phpstan-type BetaRBACOrganizationPermissionResourceShape = array{
 *   organizationID: string, type: 'organization'
 * }
 */
final class BetaRBACOrganizationPermissionResource implements BaseModel
{
    /** @use SdkModel<BetaRBACOrganizationPermissionResourceShape> */
    use SdkModel;

    /**
     * Kind of resource the permission applies to.
     *
     * @var 'organization' $type
     */
    #[Required(type: new ConstantOf('organization'))]
    public string $type = 'organization';

    /**
     * UUID of the organization the permission applies to.
     */
    #[Required('organization_id')]
    public string $organizationID;

    /**
     * `new BetaRBACOrganizationPermissionResource()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaRBACOrganizationPermissionResource::with(organizationID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaRBACOrganizationPermissionResource)->withOrganizationID(...)
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
    public static function with(string $organizationID): self
    {
        $self = new self;

        $self['organizationID'] = $organizationID;

        return $self;
    }

    /**
     * UUID of the organization the permission applies to.
     */
    public function withOrganizationID(string $organizationID): self
    {
        $self = clone $this;
        $self['organizationID'] = $organizationID;

        return $self;
    }

    /**
     * Kind of resource the permission applies to.
     *
     * @param 'organization' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
