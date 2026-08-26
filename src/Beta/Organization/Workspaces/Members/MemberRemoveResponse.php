<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Workspaces\Members;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type MemberRemoveResponseShape = array{
 *   type: 'workspace_member_deleted', userID: string, workspaceID: string
 * }
 */
final class MemberRemoveResponse implements BaseModel
{
    /** @use SdkModel<MemberRemoveResponseShape> */
    use SdkModel;

    /**
     * Deleted object type.
     *
     * For Workspace Members, this is always `"workspace_member_deleted"`.
     *
     * @var 'workspace_member_deleted' $type
     */
    #[Required]
    public string $type = 'workspace_member_deleted';

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
     * `new MemberRemoveResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * MemberRemoveResponse::with(userID: ..., workspaceID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new MemberRemoveResponse)->withUserID(...)->withWorkspaceID(...)
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
    public static function with(string $userID, string $workspaceID): self
    {
        $self = new self;

        $self['userID'] = $userID;
        $self['workspaceID'] = $workspaceID;

        return $self;
    }

    /**
     * Deleted object type.
     *
     * For Workspace Members, this is always `"workspace_member_deleted"`.
     *
     * @param 'workspace_member_deleted' $type
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
}
