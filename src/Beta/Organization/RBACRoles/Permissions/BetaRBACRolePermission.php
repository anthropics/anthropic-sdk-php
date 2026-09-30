<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\RBACRoles\Permissions;

use Anthropic\Beta\Organization\RBACRoles\Permissions\BetaRBACRolePermission\Resource;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * @phpstan-import-type ResourceVariants from \Anthropic\Beta\Organization\RBACRoles\Permissions\BetaRBACRolePermission\Resource
 * @phpstan-import-type ResourceShape from \Anthropic\Beta\Organization\RBACRoles\Permissions\BetaRBACRolePermission\Resource
 *
 * @phpstan-type BetaRBACRolePermissionShape = array{
 *   action: string, resource: ResourceShape, type: 'rbac_role_permission'
 * }
 */
final class BetaRBACRolePermission implements BaseModel
{
    /** @use SdkModel<BetaRBACRolePermissionShape> */
    use SdkModel;

    /**
     * Object type.
     *
     * For RBAC Role Permissions, this is always `"rbac_role_permission"`.
     *
     * @var 'rbac_role_permission' $type
     */
    #[Required(type: new ConstantOf('rbac_role_permission'))]
    public string $type = 'rbac_role_permission';

    /**
     * Action the permission grants on the resource.
     *
     * The vocabulary follows the resource: an `organization` grant carries a
     * product-feature entitlement (for example `chat`), an admin-panel
     * permission entitlement (`permission_*`), or a blanket capability-access
     * mode — `capability_access_all` grants every product-feature entitlement,
     * and `capability_access_all_ga` grants the generally-available subset as
     * it stands at permission-check time; neither mode grants model-access
     * entitlements. A consumer enumerating a role's per-feature grants should
     * treat a blanket row as granting every product-feature entitlement it
     * covers, or it will under-report the role's effective access. A `connector_tool` grant carries
     * a tool-access action (`use` or `always_allow`); a `connector_scope` grant
     * carries the scope action `grant` (the role may receive the named OAuth
     * scope when tokens are minted for the connector); `connector` and
     * `all_connectors` grants carry a tool-access action, the scope action, or
     * an authentication-method action (`interactive` or `managed`).
     */
    #[Required]
    public string $action;

    /**
     * What the permission applies to.
     *
     * A tagged union: `type` names the kind of resource and determines which
     * identifier fields are present.
     *
     * @var ResourceVariants $resource
     */
    #[Required(union: Resource::class)]
    public BetaRBACOrganizationPermissionResource|BetaRBACConnectorToolPermissionResource|BetaRBACConnectorScopePermissionResource|BetaRBACConnectorPermissionResource|BetaRBACAllConnectorsPermissionResource $resource;

    /**
     * `new BetaRBACRolePermission()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaRBACRolePermission::with(action: ..., resource: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaRBACRolePermission)->withAction(...)->withResource(...)
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
     * @param ResourceShape $resource
     */
    public static function with(
        string $action,
        BetaRBACOrganizationPermissionResource|array|BetaRBACConnectorToolPermissionResource|BetaRBACConnectorScopePermissionResource|BetaRBACConnectorPermissionResource|BetaRBACAllConnectorsPermissionResource $resource,
    ): self {
        $self = new self;

        $self['action'] = $action;
        $self['resource'] = $resource;

        return $self;
    }

    /**
     * Action the permission grants on the resource.
     *
     * The vocabulary follows the resource: an `organization` grant carries a
     * product-feature entitlement (for example `chat`), an admin-panel
     * permission entitlement (`permission_*`), or a blanket capability-access
     * mode — `capability_access_all` grants every product-feature entitlement,
     * and `capability_access_all_ga` grants the generally-available subset as
     * it stands at permission-check time; neither mode grants model-access
     * entitlements. A consumer enumerating a role's per-feature grants should
     * treat a blanket row as granting every product-feature entitlement it
     * covers, or it will under-report the role's effective access. A `connector_tool` grant carries
     * a tool-access action (`use` or `always_allow`); a `connector_scope` grant
     * carries the scope action `grant` (the role may receive the named OAuth
     * scope when tokens are minted for the connector); `connector` and
     * `all_connectors` grants carry a tool-access action, the scope action, or
     * an authentication-method action (`interactive` or `managed`).
     */
    public function withAction(string $action): self
    {
        $self = clone $this;
        $self['action'] = $action;

        return $self;
    }

    /**
     * What the permission applies to.
     *
     * A tagged union: `type` names the kind of resource and determines which
     * identifier fields are present.
     *
     * @param ResourceShape $resource
     */
    public function withResource(
        BetaRBACOrganizationPermissionResource|array|BetaRBACConnectorToolPermissionResource|BetaRBACConnectorScopePermissionResource|BetaRBACConnectorPermissionResource|BetaRBACAllConnectorsPermissionResource $resource,
    ): self {
        $self = clone $this;
        $self['resource'] = $resource;

        return $self;
    }

    /**
     * Object type.
     *
     * For RBAC Role Permissions, this is always `"rbac_role_permission"`.
     *
     * @param 'rbac_role_permission' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
