<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\RBACRoles\Permissions;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * @phpstan-type BetaRBACConnectorPermissionResourceShape = array{
 *   connectorID: string, type: 'connector'
 * }
 */
final class BetaRBACConnectorPermissionResource implements BaseModel
{
    /** @use SdkModel<BetaRBACConnectorPermissionResourceShape> */
    use SdkModel;

    /**
     * Kind of resource the permission applies to.
     *
     * @var 'connector' $type
     */
    #[Required(type: new ConstantOf('connector'))]
    public string $type = 'connector';

    /**
     * ID of the connector the permission applies to.
     */
    #[Required('connector_id')]
    public string $connectorID;

    /**
     * `new BetaRBACConnectorPermissionResource()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaRBACConnectorPermissionResource::with(connectorID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaRBACConnectorPermissionResource)->withConnectorID(...)
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
    public static function with(string $connectorID): self
    {
        $self = new self;

        $self['connectorID'] = $connectorID;

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
     * Kind of resource the permission applies to.
     *
     * @param 'connector' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
