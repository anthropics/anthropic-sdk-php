<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Workspaces\Members;

use Anthropic\Beta\Organization\Workspaces\NoBillingWorkspaceRole;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Create Workspace Member.
 *
 * @see Anthropic\Services\Beta\Organization\Workspaces\MembersService::add()
 *
 * @phpstan-type MemberAddParamsShape = array{
 *   userID: string,
 *   workspaceRole: NoBillingWorkspaceRole|value-of<NoBillingWorkspaceRole>,
 * }
 */
final class MemberAddParams implements BaseModel
{
    /** @use SdkModel<MemberAddParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * ID of the User.
     */
    #[Required('user_id')]
    public string $userID;

    /**
     * Role of the new Workspace Member. Cannot be `workspace_billing`.
     *
     * @var value-of<NoBillingWorkspaceRole> $workspaceRole
     */
    #[Required('workspace_role', enum: NoBillingWorkspaceRole::class)]
    public string $workspaceRole;

    /**
     * `new MemberAddParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * MemberAddParams::with(userID: ..., workspaceRole: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new MemberAddParams)->withUserID(...)->withWorkspaceRole(...)
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
     * @param NoBillingWorkspaceRole|value-of<NoBillingWorkspaceRole> $workspaceRole
     */
    public static function with(
        string $userID,
        NoBillingWorkspaceRole|string $workspaceRole
    ): self {
        $self = new self;

        $self['userID'] = $userID;
        $self['workspaceRole'] = $workspaceRole;

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
     * Role of the new Workspace Member. Cannot be `workspace_billing`.
     *
     * @param NoBillingWorkspaceRole|value-of<NoBillingWorkspaceRole> $workspaceRole
     */
    public function withWorkspaceRole(
        NoBillingWorkspaceRole|string $workspaceRole
    ): self {
        $self = clone $this;
        $self['workspaceRole'] = $workspaceRole;

        return $self;
    }
}
