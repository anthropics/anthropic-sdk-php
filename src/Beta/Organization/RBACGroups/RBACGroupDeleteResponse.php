<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\RBACGroups;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * @phpstan-type RBACGroupDeleteResponseShape = array{
 *   id: string, type: 'rbac_group_deleted'
 * }
 */
final class RBACGroupDeleteResponse implements BaseModel
{
    /** @use SdkModel<RBACGroupDeleteResponseShape> */
    use SdkModel;

    /**
     * Deleted object type.
     *
     * For RBAC Groups, this is always `"rbac_group_deleted"`.
     *
     * @var 'rbac_group_deleted' $type
     */
    #[Required(type: new ConstantOf('rbac_group_deleted'))]
    public string $type = 'rbac_group_deleted';

    /**
     * ID of the RBAC Group.
     */
    #[Required]
    public string $id;

    /**
     * `new RBACGroupDeleteResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * RBACGroupDeleteResponse::with(id: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new RBACGroupDeleteResponse())->withID(...)
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
    public static function with(string $id): self
    {
        $self = new self;

        $self['id'] = $id;

        return $self;
    }

    /**
     * ID of the RBAC Group.
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * Deleted object type.
     *
     * For RBAC Groups, this is always `"rbac_group_deleted"`.
     *
     * @param 'rbac_group_deleted' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
