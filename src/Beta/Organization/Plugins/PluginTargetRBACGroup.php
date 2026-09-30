<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Plugins;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * @phpstan-type PluginTargetRBACGroupShape = array{
 *   rbacGroupID: string, type: 'rbac_group'
 * }
 */
final class PluginTargetRBACGroup implements BaseModel
{
    /** @use SdkModel<PluginTargetRBACGroupShape> */
    use SdkModel;

    /**
     * An RBAC Group.
     *
     * @var 'rbac_group' $type
     */
    #[Required(type: new ConstantOf('rbac_group'))]
    public string $type = 'rbac_group';

    /**
     * The RBAC Group's ID.
     */
    #[Required('rbac_group_id')]
    public string $rbacGroupID;

    /**
     * `new PluginTargetRBACGroup()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * PluginTargetRBACGroup::with(rbacGroupID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new PluginTargetRBACGroup)->withRBACGroupID(...)
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
     * The RBAC Group's ID.
     */
    public function withRBACGroupID(string $rbacGroupID): self
    {
        $self = clone $this;
        $self['rbacGroupID'] = $rbacGroupID;

        return $self;
    }

    /**
     * An RBAC Group.
     *
     * @param 'rbac_group' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
