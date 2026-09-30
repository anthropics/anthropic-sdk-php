<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\RBACGroups;

use Anthropic\Beta\Organization\RBACGroups\RBACGroup\SourceType;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * @phpstan-type RBACGroupShape = array{
 *   id: string,
 *   createdAt: \DateTimeInterface,
 *   name: string,
 *   roleIDs: list<string>|null,
 *   sourceType: SourceType|value-of<SourceType>,
 *   type: 'rbac_group',
 *   updatedAt: \DateTimeInterface,
 * }
 */
final class RBACGroup implements BaseModel
{
    /** @use SdkModel<RBACGroupShape> */
    use SdkModel;

    /**
     * Object type.
     *
     * For RBAC Groups, this is always `"rbac_group"`.
     *
     * @var 'rbac_group' $type
     */
    #[Required(type: new ConstantOf('rbac_group'))]
    public string $type = 'rbac_group';

    /**
     * ID of the RBAC Group.
     */
    #[Required]
    public string $id;

    /**
     * RFC 3339 timestamp of when the RBAC Group was created.
     */
    #[Required('created_at')]
    public \DateTimeInterface $createdAt;

    /**
     * Name of the RBAC Group. Not uniqueness-enforced.
     */
    #[Required]
    public string $name;

    /**
     * RBAC Role IDs attached to this RBAC Group. Role attachment is managed in the admin settings and is read-only on this API. `null` means role data was temporarily unavailable — retry to distinguish from an empty list.
     *
     * @var list<string>|null $roleIDs
     */
    #[Required('role_ids', list: 'string')]
    public ?array $roleIDs;

    /**
     * How the RBAC Group was created: `"direct"` for groups created directly (for example, in the organization's admin settings), `"scim"` for groups provisioned by the identity provider.
     *
     * @var value-of<SourceType> $sourceType
     */
    #[Required('source_type', enum: SourceType::class)]
    public string $sourceType;

    /**
     * RFC 3339 timestamp of when the RBAC Group was last updated.
     */
    #[Required('updated_at')]
    public \DateTimeInterface $updatedAt;

    /**
     * `new RBACGroup()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * RBACGroup::with(
     *   id: ...,
     *   createdAt: ...,
     *   name: ...,
     *   roleIDs: ...,
     *   sourceType: ...,
     *   updatedAt: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new RBACGroup)
     *   ->withID(...)
     *   ->withCreatedAt(...)
     *   ->withName(...)
     *   ->withRoleIDs(...)
     *   ->withSourceType(...)
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
     *
     * @param list<string>|null $roleIDs
     * @param SourceType|value-of<SourceType> $sourceType
     */
    public static function with(
        string $id,
        \DateTimeInterface $createdAt,
        string $name,
        ?array $roleIDs,
        SourceType|string $sourceType,
        \DateTimeInterface $updatedAt,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['createdAt'] = $createdAt;
        $self['name'] = $name;
        $self['roleIDs'] = $roleIDs;
        $self['sourceType'] = $sourceType;
        $self['updatedAt'] = $updatedAt;

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
     * RFC 3339 timestamp of when the RBAC Group was created.
     */
    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    /**
     * Name of the RBAC Group. Not uniqueness-enforced.
     */
    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * RBAC Role IDs attached to this RBAC Group. Role attachment is managed in the admin settings and is read-only on this API. `null` means role data was temporarily unavailable — retry to distinguish from an empty list.
     *
     * @param list<string>|null $roleIDs
     */
    public function withRoleIDs(?array $roleIDs): self
    {
        $self = clone $this;
        $self['roleIDs'] = $roleIDs;

        return $self;
    }

    /**
     * How the RBAC Group was created: `"direct"` for groups created directly (for example, in the organization's admin settings), `"scim"` for groups provisioned by the identity provider.
     *
     * @param SourceType|value-of<SourceType> $sourceType
     */
    public function withSourceType(SourceType|string $sourceType): self
    {
        $self = clone $this;
        $self['sourceType'] = $sourceType;

        return $self;
    }

    /**
     * Object type.
     *
     * For RBAC Groups, this is always `"rbac_group"`.
     *
     * @param 'rbac_group' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * RFC 3339 timestamp of when the RBAC Group was last updated.
     */
    public function withUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $self = clone $this;
        $self['updatedAt'] = $updatedAt;

        return $self;
    }
}
