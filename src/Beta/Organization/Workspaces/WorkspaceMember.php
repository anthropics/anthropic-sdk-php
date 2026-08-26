<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Workspaces;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type WorkspaceMemberShape = array{
 *   type: 'workspace_member',
 *   userID: string,
 *   workspaceID: string,
 *   workspaceRole: WorkspaceRole|value-of<WorkspaceRole>,
 * }
 */
final class WorkspaceMember implements BaseModel
{
    /** @use SdkModel<WorkspaceMemberShape> */
    use SdkModel;

    /**
     * Object type.
     *
     * For Workspace Members, this is always `"workspace_member"`.
     *
     * @var 'workspace_member' $type
     */
    #[Required]
    public string $type = 'workspace_member';

    /**
     * ID of the User.
     */
    #[Required('user_id')]
    public string $userID;

    /**
     * ID of the Workspace.
     */
    #[Required('workspace_id')]
    public string $workspaceID;

    /**
     * Role of the Workspace Member.
     *
     * @var value-of<WorkspaceRole> $workspaceRole
     */
    #[Required('workspace_role', enum: WorkspaceRole::class)]
    public string $workspaceRole;

    /**
     * `new WorkspaceMember()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * WorkspaceMember::with(userID: ..., workspaceID: ..., workspaceRole: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new WorkspaceMember)
     *   ->withUserID(...)
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
        string $userID,
        string $workspaceID,
        WorkspaceRole|string $workspaceRole
    ): self {
        $self = new self;

        $self['userID'] = $userID;
        $self['workspaceID'] = $workspaceID;
        $self['workspaceRole'] = $workspaceRole;

        return $self;
    }

    /**
     * Object type.
     *
     * For Workspace Members, this is always `"workspace_member"`.
     *
     * @param 'workspace_member' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }

    /**
     * ID of the User.
     */
    public function withUserID(string $userID): self
    {
        $self = clone $this;
        $self['userID'] = $userID;

        return $self;
    }

    /**
     * ID of the Workspace.
     */
    public function withWorkspaceID(string $workspaceID): self
    {
        $self = clone $this;
        $self['workspaceID'] = $workspaceID;

        return $self;
    }

    /**
     * Role of the Workspace Member.
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
