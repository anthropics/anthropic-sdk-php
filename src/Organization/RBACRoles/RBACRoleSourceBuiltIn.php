<?php

declare(strict_types=1);

namespace Anthropic\Organization\RBACRoles;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * @phpstan-type RBACRoleSourceBuiltInShape = array{type: 'built_in'}
 */
final class RBACRoleSourceBuiltIn implements BaseModel
{
    /** @use SdkModel<RBACRoleSourceBuiltInShape> */
    use SdkModel;

    /**
     * Anthropic provisions the RBAC Role, and the organization's administrators cannot change or delete it.
     *
     * @var 'built_in' $type
     */
    #[Required(type: new ConstantOf('built_in'))]
    public string $type = 'built_in';

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
     * Anthropic provisions the RBAC Role, and the organization's administrators cannot change or delete it.
     *
     * @param 'built_in' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
