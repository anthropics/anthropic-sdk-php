<?php

declare(strict_types=1);

namespace Anthropic\Organization\ServiceAccounts\Workspaces;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Organization\Workspaces\NoBillingWorkspaceRole;

/**
 * **Requires an OAuth access token with the `org:admin` scope**, from `ant auth login --scope org:admin` or a workload identity federation rule; Admin API keys are not accepted. See [Manage WIF with the Admin API](/docs/en/manage-claude/wif-admin-api).
 *
 * Add a service account to a workspace with the given `workspace_role`.
 *
 * Mirror of `POST /workspaces/{workspace_id}/service_accounts`, addressed
 * from the service-account side; both create the same membership. If the
 * service account is already an explicit member of the workspace, its
 * `workspace_role` is replaced with the value supplied here. Archived
 * workspaces return 400. Archived service accounts cannot be added and are
 * rejected.
 *
 * @see Anthropic\Services\Organization\ServiceAccounts\WorkspacesService::add()
 *
 * @phpstan-type WorkspaceAddParamsShape = array{
 *   workspaceID: string,
 *   workspaceRole: NoBillingWorkspaceRole|value-of<NoBillingWorkspaceRole>,
 * }
 */
final class WorkspaceAddParams implements BaseModel
{
    /** @use SdkModel<WorkspaceAddParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Tagged workspace ID to add the service account to.
     */
    #[Required('workspace_id')]
    public string $workspaceID;

    /**
     * Role to assign to the service account in this workspace.
     *
     * @var value-of<NoBillingWorkspaceRole> $workspaceRole
     */
    #[Required('workspace_role', enum: NoBillingWorkspaceRole::class)]
    public string $workspaceRole;

    /**
     * `new WorkspaceAddParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * WorkspaceAddParams::with(workspaceID: ..., workspaceRole: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new WorkspaceAddParams())->withWorkspaceID(...)->withWorkspaceRole(...)
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
        string $workspaceID,
        NoBillingWorkspaceRole|string $workspaceRole
    ): self {
        $self = new self;

        $self['workspaceID'] = $workspaceID;
        $self['workspaceRole'] = $workspaceRole;

        return $self;
    }

    /**
     * Tagged workspace ID to add the service account to.
     */
    public function withWorkspaceID(string $workspaceID): self
    {
        $self = clone $this;
        $self['workspaceID'] = $workspaceID;

        return $self;
    }

    /**
     * Role to assign to the service account in this workspace.
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
