<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ServiceAccounts;

use Anthropic\Beta\Organization\Workspaces\WorkspaceRole;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type ServiceAccountWorkspaceMemberShape = array{
 *   createdByActorID: string|null,
 *   implicit: bool|null,
 *   serviceAccountID: string,
 *   type: 'service_account_workspace_member',
 *   workspaceID: string,
 *   workspaceRole: WorkspaceRole|value-of<WorkspaceRole>,
 * }
 */
final class ServiceAccountWorkspaceMember implements BaseModel
{
    /** @use SdkModel<ServiceAccountWorkspaceMemberShape> */
    use SdkModel;

    /** @var 'service_account_workspace_member' $type */
    #[Required]
    public string $type = 'service_account_workspace_member';

    /**
     * Tagged ID (`user_...`/`svac_...`) of the actor who created this membership.
     */
    #[Required('created_by_actor_id')]
    public ?string $createdByActorID;

    /**
     * True when this is the implicit default-workspace membership every service account has when no explicit membership exists. Implicit memberships have role `workspace_user` and cannot be removed.
     */
    #[Required]
    public ?bool $implicit;

    /**
     * Tagged service account ID (`svac_...`).
     */
    #[Required('service_account_id')]
    public string $serviceAccountID;

    /**
     * Tagged workspace ID (`wrkspc_...`).
     */
    #[Required('workspace_id')]
    public string $workspaceID;

    /**
     * Role of the service account in this workspace. Service accounts cannot hold the `workspace_billing` role.
     *
     * @var value-of<WorkspaceRole> $workspaceRole
     */
    #[Required('workspace_role', enum: WorkspaceRole::class)]
    public string $workspaceRole;

    /**
     * `new ServiceAccountWorkspaceMember()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ServiceAccountWorkspaceMember::with(
     *   createdByActorID: ...,
     *   implicit: ...,
     *   serviceAccountID: ...,
     *   workspaceID: ...,
     *   workspaceRole: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ServiceAccountWorkspaceMember)
     *   ->withCreatedByActorID(...)
     *   ->withImplicit(...)
     *   ->withServiceAccountID(...)
     *   ->withWorkspaceID(...)
     *   ->withWorkspaceRole(...)
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
     * @param WorkspaceRole|value-of<WorkspaceRole> $workspaceRole
     */
    public static function with(
        ?string $createdByActorID,
        ?bool $implicit,
        string $serviceAccountID,
        string $workspaceID,
        WorkspaceRole|string $workspaceRole,
    ): self {
        $self = new self;

        $self['createdByActorID'] = $createdByActorID;
        $self['implicit'] = $implicit;
        $self['serviceAccountID'] = $serviceAccountID;
        $self['workspaceID'] = $workspaceID;
        $self['workspaceRole'] = $workspaceRole;

        return $self;
    }

    /**
     * Tagged ID (`user_...`/`svac_...`) of the actor who created this membership.
     */
    public function withCreatedByActorID(?string $createdByActorID): self
    {
        $self = clone $this;
        $self['createdByActorID'] = $createdByActorID;

        return $self;
    }

    /**
     * True when this is the implicit default-workspace membership every service account has when no explicit membership exists. Implicit memberships have role `workspace_user` and cannot be removed.
     */
    public function withImplicit(?bool $implicit): self
    {
        $self = clone $this;
        $self['implicit'] = $implicit;

        return $self;
    }

    /**
     * Tagged service account ID (`svac_...`).
     */
    public function withServiceAccountID(string $serviceAccountID): self
    {
        $self = clone $this;
        $self['serviceAccountID'] = $serviceAccountID;

        return $self;
    }

    /**
     * @param 'service_account_workspace_member' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * Tagged workspace ID (`wrkspc_...`).
     */
    public function withWorkspaceID(string $workspaceID): self
    {
        $self = clone $this;
        $self['workspaceID'] = $workspaceID;

        return $self;
    }

    /**
     * Role of the service account in this workspace. Service accounts cannot hold the `workspace_billing` role.
     *
     * @param WorkspaceRole|value-of<WorkspaceRole> $workspaceRole
     */
    public function withWorkspaceRole(WorkspaceRole|string $workspaceRole): self
    {
        $self = clone $this;
        $self['workspaceRole'] = $workspaceRole;

        return $self;
    }
}
