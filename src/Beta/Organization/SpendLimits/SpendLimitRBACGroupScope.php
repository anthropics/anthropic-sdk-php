<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\SpendLimits;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * @phpstan-type SpendLimitRBACGroupScopeShape = array{
 *   rbacGroupID: string, type: 'rbac_group'
 * }
 */
final class SpendLimitRBACGroupScope implements BaseModel
{
    /** @use SdkModel<SpendLimitRBACGroupScopeShape> */
    use SdkModel;

    /** @var 'rbac_group' $type */
    #[Required(type: new ConstantOf('rbac_group'))]
    public string $type = 'rbac_group';

    #[Required('rbac_group_id')]
    public string $rbacGroupID;

    /**
     * `new SpendLimitRBACGroupScope()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * SpendLimitRBACGroupScope::with(rbacGroupID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new SpendLimitRBACGroupScope)->withRBACGroupID(...)
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

    public function withRBACGroupID(string $rbacGroupID): self
    {
        $self = clone $this;
        $self['rbacGroupID'] = $rbacGroupID;

        return $self;
    }

    /**
     * @param 'rbac_group' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
