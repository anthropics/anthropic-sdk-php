<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\RBACRoles\Permissions;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * @phpstan-type BetaRBACAllConnectorsPermissionResourceShape = array{
 *   type: 'all_connectors'
 * }
 */
final class BetaRBACAllConnectorsPermissionResource implements BaseModel
{
    /** @use SdkModel<BetaRBACAllConnectorsPermissionResourceShape> */
    use SdkModel;

    /**
     * Kind of resource the permission applies to.
     *
     * @var 'all_connectors' $type
     */
    #[Required(type: new ConstantOf('all_connectors'))]
    public string $type = 'all_connectors';

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
     * Kind of resource the permission applies to.
     *
     * @param 'all_connectors' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
