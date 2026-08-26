<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ServiceAccounts;

use Anthropic\Beta\Organization\ServiceAccounts\ServiceAccount\OrganizationRole;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Named non-human identity within the caller's organization.
 *
 * A service account is a pure identity: name + org. Authorization lives on
 * whatever references it (federation rules).
 *
 * @phpstan-type ServiceAccountShape = array{
 *   id: string,
 *   archivedAt: \DateTimeInterface|null,
 *   archivedByActorID: string|null,
 *   createdAt: \DateTimeInterface,
 *   createdByActorID: string|null,
 *   description: string|null,
 *   name: string,
 *   organizationRole: OrganizationRole|value-of<OrganizationRole>,
 *   type: 'service_account',
 *   updatedAt: \DateTimeInterface,
 *   updatedByActorID: string|null,
 * }
 */
final class ServiceAccount implements BaseModel
{
    /** @use SdkModel<ServiceAccountShape> */
    use SdkModel;

    /** @var 'service_account' $type */
    #[Required]
    public string $type = 'service_account';

    /**
     * Tagged ID of the service account.
     */
    #[Required]
    public string $id;

    /**
     * If set, this service account is archived.
     */
    #[Required('archived_at')]
    public ?\DateTimeInterface $archivedAt;

    /**
     * Tagged ID (`user_`/`svac_`) of the actor that archived this service account.
     */
    #[Required('archived_by_actor_id')]
    public ?string $archivedByActorID;

    /**
     * When this service account was created.
     */
    #[Required('created_at')]
    public \DateTimeInterface $createdAt;

    /**
     * Tagged ID (`user_`/`svac_`) of the actor that created this service account.
     */
    #[Required('created_by_actor_id')]
    public ?string $createdByActorID;

    /**
     * Optional free-text description.
     */
    #[Required]
    public ?string $description;

    /**
     * Admin-chosen slug identifier.
     */
    #[Required]
    public string $name;

    /**
     * Org-level role. A federation rule may only be created or retargeted to grant `org:admin` scope when this is `admin`. A rule granting `org:admin` whose target is later demoted to `developer` is rejected at token exchange. Rules granting `org:admin` are managed in the Console.
     *
     * @var value-of<OrganizationRole> $organizationRole
     */
    #[Required('organization_role', enum: OrganizationRole::class)]
    public string $organizationRole;

    /**
     * When this service account was last updated.
     */
    #[Required('updated_at')]
    public \DateTimeInterface $updatedAt;

    /**
     * Tagged ID (`user_`/`svac_`) of the actor that last updated this service account.
     */
    #[Required('updated_by_actor_id')]
    public ?string $updatedByActorID;

    /**
     * `new ServiceAccount()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ServiceAccount::with(
     *   id: ...,
     *   archivedAt: ...,
     *   archivedByActorID: ...,
     *   createdAt: ...,
     *   createdByActorID: ...,
     *   description: ...,
     *   name: ...,
     *   organizationRole: ...,
     *   updatedAt: ...,
     *   updatedByActorID: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ServiceAccount)
     *   ->withID(...)
     *   ->withArchivedAt(...)
     *   ->withArchivedByActorID(...)
     *   ->withCreatedAt(...)
     *   ->withCreatedByActorID(...)
     *   ->withDescription(...)
     *   ->withName(...)
     *   ->withOrganizationRole(...)
     *   ->withUpdatedAt(...)
     *   ->withUpdatedByActorID(...)
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
     * @param OrganizationRole|value-of<OrganizationRole> $organizationRole
     */
    public static function with(
        string $id,
        ?\DateTimeInterface $archivedAt,
        ?string $archivedByActorID,
        \DateTimeInterface $createdAt,
        ?string $createdByActorID,
        ?string $description,
        string $name,
        OrganizationRole|string $organizationRole,
        \DateTimeInterface $updatedAt,
        ?string $updatedByActorID,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['archivedAt'] = $archivedAt;
        $self['archivedByActorID'] = $archivedByActorID;
        $self['createdAt'] = $createdAt;
        $self['createdByActorID'] = $createdByActorID;
        $self['description'] = $description;
        $self['name'] = $name;
        $self['organizationRole'] = $organizationRole;
        $self['updatedAt'] = $updatedAt;
        $self['updatedByActorID'] = $updatedByActorID;

        return $self;
    }

    /**
     * Tagged ID of the service account.
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * If set, this service account is archived.
     */
    public function withArchivedAt(?\DateTimeInterface $archivedAt): self
    {
        $self = clone $this;
        $self['archivedAt'] = $archivedAt;

        return $self;
    }

    /**
     * Tagged ID (`user_`/`svac_`) of the actor that archived this service account.
     */
    public function withArchivedByActorID(?string $archivedByActorID): self
    {
        $self = clone $this;
        $self['archivedByActorID'] = $archivedByActorID;

        return $self;
    }

    /**
     * When this service account was created.
     */
    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    /**
     * Tagged ID (`user_`/`svac_`) of the actor that created this service account.
     */
    public function withCreatedByActorID(?string $createdByActorID): self
    {
        $self = clone $this;
        $self['createdByActorID'] = $createdByActorID;

        return $self;
    }

    /**
     * Optional free-text description.
     */
    public function withDescription(?string $description): self
    {
        $self = clone $this;
        $self['description'] = $description;

        return $self;
    }

    /**
     * Admin-chosen slug identifier.
     */
    public function withName(string $name): self
    {
        $self = clone $this;
        $self['name'] = $name;

        return $self;
    }

    /**
     * Org-level role. A federation rule may only be created or retargeted to grant `org:admin` scope when this is `admin`. A rule granting `org:admin` whose target is later demoted to `developer` is rejected at token exchange. Rules granting `org:admin` are managed in the Console.
     *
     * @param OrganizationRole|value-of<OrganizationRole> $organizationRole
     */
    public function withOrganizationRole(
        OrganizationRole|string $organizationRole
    ): self {
        $self = clone $this;
        $self['organizationRole'] = $organizationRole;

        return $self;
    }

    /**
     * @param 'service_account' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * When this service account was last updated.
     */
    public function withUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $self = clone $this;
        $self['updatedAt'] = $updatedAt;

        return $self;
    }

    /**
     * Tagged ID (`user_`/`svac_`) of the actor that last updated this service account.
     */
    public function withUpdatedByActorID(?string $updatedByActorID): self
    {
        $self = clone $this;
        $self['updatedByActorID'] = $updatedByActorID;

        return $self;
    }
}
