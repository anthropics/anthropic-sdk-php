<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\RBACRoles;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * @phpstan-type RBACRoleSourceCustomShape = array{type: 'custom'}
 */
final class RBACRoleSourceCustom implements BaseModel
{
    /** @use SdkModel<RBACRoleSourceCustomShape> */
    use SdkModel;

    /**
     * The organization's administrators can change and delete the RBAC Role.
     *
     * @var 'custom' $type
     */
    #[Required(type: new ConstantOf('custom'))]
    public string $type = 'custom';

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(): self
    {
        return new self;
    }

    /**
     * The organization's administrators can change and delete the RBAC Role.
     *
     * @param 'custom' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
