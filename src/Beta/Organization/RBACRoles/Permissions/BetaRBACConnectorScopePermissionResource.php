<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\RBACRoles\Permissions;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * @phpstan-type BetaRBACConnectorScopePermissionResourceShape = array{
 *   connectorID: string, scope: string, type: 'connector_scope'
 * }
 */
final class BetaRBACConnectorScopePermissionResource implements BaseModel
{
    /** @use SdkModel<BetaRBACConnectorScopePermissionResourceShape> */
    use SdkModel;

    /**
     * Kind of resource the permission applies to.
     *
     * @var 'connector_scope' $type
     */
    #[Required(type: new ConstantOf('connector_scope'))]
    public string $type = 'connector_scope';

    /**
     * ID of the connector the permission applies to.
     */
    #[Required('connector_id')]
    public string $connectorID;

    /**
     * OAuth scope the permission names — the role may receive this scope when
     * tokens are minted for the connector.
     *
     * Subject to the same encoding rule as `tool_name`: a scope containing
     * characters outside `[a-zA-Z0-9_-]` (or colliding with a reserved form)
     * appears server-encoded in a stable `{prefix}_{32-hex}` form. OAuth
     * scopes routinely contain `:` and `/`, so most appear encoded.
     */
    #[Required]
    public string $scope;

    /**
     * `new BetaRBACConnectorScopePermissionResource()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaRBACConnectorScopePermissionResource::with(connectorID: ..., scope: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaRBACConnectorScopePermissionResource)
     *   ->withConnectorID(...)
     *   ->withScope(...)
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
    public static function with(string $connectorID, string $scope): self
    {
        $self = new self;

        $self['connectorID'] = $connectorID;
        $self['scope'] = $scope;

        return $self;
    }

    /**
     * ID of the connector the permission applies to.
     */
    public function withConnectorID(string $connectorID): self
    {
        $self = clone $this;
        $self['connectorID'] = $connectorID;

        return $self;
    }

    /**
     * OAuth scope the permission names — the role may receive this scope when
     * tokens are minted for the connector.
     *
     * Subject to the same encoding rule as `tool_name`: a scope containing
     * characters outside `[a-zA-Z0-9_-]` (or colliding with a reserved form)
     * appears server-encoded in a stable `{prefix}_{32-hex}` form. OAuth
     * scopes routinely contain `:` and `/`, so most appear encoded.
     */
    public function withScope(string $scope): self
    {
        $self = clone $this;
        $self['scope'] = $scope;

        return $self;
    }

    /**
     * Kind of resource the permission applies to.
     *
     * @param 'connector_scope' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
