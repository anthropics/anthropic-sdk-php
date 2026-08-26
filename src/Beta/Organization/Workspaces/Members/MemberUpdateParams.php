<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Workspaces\Members;

use Anthropic\Beta\Organization\Workspaces\WorkspaceRole;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Update Workspace Member.
 *
 * @see Anthropic\Services\Beta\Organization\Workspaces\MembersService::update()
 *
 * @phpstan-type MemberUpdateParamsShape = array{
 *   workspaceID: string, workspaceRole: WorkspaceRole|value-of<WorkspaceRole>
 * }
 */
final class MemberUpdateParams implements BaseModel
{
    /** @use SdkModel<MemberUpdateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * ID of the Workspace.
     */
    #[Required]
    public string $workspaceID;

    /**
     * New workspace role for the User.
     *
     * @var value-of<WorkspaceRole> $workspaceRole
     */
    #[Required('workspace_role', enum: WorkspaceRole::class)]
    public string $workspaceRole;

    /**
     * `new MemberUpdateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * MemberUpdateParams::with(workspaceID: ..., workspaceRole: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new MemberUpdateParams)->withWorkspaceID(...)->withWorkspaceRole(...)
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
        string $workspaceID,
        WorkspaceRole|string $workspaceRole
    ): self {
        $self = new self;

        $self['workspaceID'] = $workspaceID;
        $self['workspaceRole'] = $workspaceRole;

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
     * New workspace role for the User.
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
