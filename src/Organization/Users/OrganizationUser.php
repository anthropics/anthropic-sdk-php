<?php

declare(strict_types=1);

namespace Anthropic\Organization\Users;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;
use Anthropic\Organization\OrganizationRole;

/**
 * @phpstan-type OrganizationUserShape = array{
 *   id: string,
 *   addedAt: \DateTimeInterface,
 *   email: string,
 *   name: string,
 *   role: OrganizationRole|value-of<OrganizationRole>,
 *   type: 'user',
 * }
 */
final class OrganizationUser implements BaseModel
{
    /** @use SdkModel<OrganizationUserShape> */
    use SdkModel;

    /**
     * Object type.
     *
     * For Users, this is always `"user"`.
     *
     * @var 'user' $type
     */
    #[Required(type: new ConstantOf('user'))]
    public string $type = 'user';

    /**
     * ID of the User.
     */
    #[Required]
    public string $id;

    /**
     * RFC 3339 datetime string indicating when the User joined the Organization.
     */
    #[Required('added_at')]
    public \DateTimeInterface $addedAt;

    /**
     * Email of the User.
     */
    #[Required]
    public string $email;

    /**
     * Name of the User.
     */
    #[Required]
    public string $name;

    /**
     * Organization role of the User.
     *
     * @var value-of<OrganizationRole> $role
     */
    #[Required(enum: OrganizationRole::class)]
    public string $role;

    /**
     * `new OrganizationUser()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * OrganizationUser::with(id: ..., addedAt: ..., email: ..., name: ..., role: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new OrganizationUser)
     *   ->withID(...)
     *   ->withAddedAt(...)
     *   ->withEmail(...)
     *   ->withName(...)
     *   ->withRole(...)
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
     *
     * @param OrganizationRole|value-of<OrganizationRole> $role
     */
    public static function with(
        string $id,
        \DateTimeInterface $addedAt,
        string $email,
        string $name,
        OrganizationRole|string $role,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['addedAt'] = $addedAt;
        $self['email'] = $email;
        $self['name'] = $name;
        $self['role'] = $role;

        return $self;
    }

    /**
     * ID of the User.
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * RFC 3339 datetime string indicating when the User joined the Organization.
     */
    public function withAddedAt(\DateTimeInterface $addedAt): self
    {
        $self = clone $this;
        $self['addedAt'] = $addedAt;

        return $self;
    }

    /**
     * Email of the User.
     */
    public function withEmail(string $email): self
    {
        $self = clone $this;
        $self['email'] = $email;

        return $self;
    }

    /**
     * Name of the User.
     */
    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * Organization role of the User.
     *
     * @param OrganizationRole|value-of<OrganizationRole> $role
     */
    public function withRole(OrganizationRole|string $role): self
    {
        $self = clone $this;
        $self['role'] = $role;

        return $self;
    }

    /**
     * Object type.
     *
     * For Users, this is always `"user"`.
     *
     * @param 'user' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
