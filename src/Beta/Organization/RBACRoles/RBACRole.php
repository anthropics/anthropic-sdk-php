<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\RBACRoles;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * @phpstan-type RBACRoleShape = array{
 *   id: string,
 *   createdAt: \DateTimeInterface,
 *   name: string,
 *   type: 'rbac_role',
 *   updatedAt: \DateTimeInterface,
 * }
 */
final class RBACRole implements BaseModel
{
    /** @use SdkModel<RBACRoleShape> */
    use SdkModel;

    /**
     * Object type.
     *
     * For RBAC Roles, this is always `"rbac_role"`.
     *
     * @var 'rbac_role' $type
     */
    #[Required(type: new ConstantOf('rbac_role'))]
    public string $type = 'rbac_role';

    /**
     * ID of the RBAC Role.
     */
    #[Required]
    public string $id;

    /**
     * RFC 3339 datetime string indicating when the RBAC Role was created.
     */
    #[Required('created_at')]
    public \DateTimeInterface $createdAt;

    /**
     * Name of the RBAC Role.
     */
    #[Required]
    public string $name;

    /**
     * RFC 3339 datetime string indicating when the RBAC Role was last updated.
     */
    #[Required('updated_at')]
    public \DateTimeInterface $updatedAt;

    /**
     * `new RBACRole()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * RBACRole::with(id: ..., createdAt: ..., name: ..., updatedAt: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new RBACRole)
     *   ->withID(...)
     *   ->withCreatedAt(...)
     *   ->withName(...)
     *   ->withUpdatedAt(...)
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
    public static function with(
        string $id,
        \DateTimeInterface $createdAt,
        string $name,
        \DateTimeInterface $updatedAt,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['createdAt'] = $createdAt;
        $self['name'] = $name;
        $self['updatedAt'] = $updatedAt;

        return $self;
    }

    /**
     * ID of the RBAC Role.
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * RFC 3339 datetime string indicating when the RBAC Role was created.
     */
    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    /**
     * Name of the RBAC Role.
     */
    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * Object type.
     *
     * For RBAC Roles, this is always `"rbac_role"`.
     *
     * @param 'rbac_role' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * RFC 3339 datetime string indicating when the RBAC Role was last updated.
     */
    public function withUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $self = clone $this;
        $self['updatedAt'] = $updatedAt;

        return $self;
    }
}
