<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\RBACRoles\Permissions;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * @phpstan-type BetaRBACConnectorToolPermissionResourceShape = array{
 *   connectorID: string, toolName: string, type: 'connector_tool'
 * }
 */
final class BetaRBACConnectorToolPermissionResource implements BaseModel
{
    /** @use SdkModel<BetaRBACConnectorToolPermissionResourceShape> */
    use SdkModel;

    /**
     * Kind of resource the permission applies to.
     *
     * @var 'connector_tool' $type
     */
    #[Required(type: new ConstantOf('connector_tool'))]
    public string $type = 'connector_tool';

    /**
     * ID of the connector the permission applies to.
     */
    #[Required('connector_id')]
    public string $connectorID;

    /**
     * Published name of the connector tool the permission applies to.
     *
     * When the published name contains characters outside `[a-zA-Z0-9_-]` (or
     * collides with a reserved form), it is server-encoded into a stable
     * `{prefix}_{32-hex}` form — a shortened readable prefix of the name plus
     * a hash — from which the published name is not recoverable.
     */
    #[Required('tool_name')]
    public string $toolName;

    /**
     * `new BetaRBACConnectorToolPermissionResource()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaRBACConnectorToolPermissionResource::with(connectorID: ..., toolName: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaRBACConnectorToolPermissionResource())
     *   ->withConnectorID(...)
     *   ->withToolName(...)
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
    public static function with(string $connectorID, string $toolName): self
    {
        $self = new self;

        $self['connectorID'] = $connectorID;
        $self['toolName'] = $toolName;

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
     * Published name of the connector tool the permission applies to.
     *
     * When the published name contains characters outside `[a-zA-Z0-9_-]` (or
     * collides with a reserved form), it is server-encoded into a stable
     * `{prefix}_{32-hex}` form — a shortened readable prefix of the name plus
     * a hash — from which the published name is not recoverable.
     */
    public function withToolName(string $toolName): self
    {
        $self = clone $this;
        $self['toolName'] = $toolName;

        return $self;
    }

    /**
     * Kind of resource the permission applies to.
     *
     * @param 'connector_tool' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
