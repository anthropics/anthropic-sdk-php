<?php

declare(strict_types=1);

namespace Anthropic\Organization\Workspaces\ServiceAccounts;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Organization\Workspaces\NoBillingWorkspaceRole;

/**
 * **Requires an OAuth access token with the `org:admin` scope**, from `ant auth login --scope org:admin` or a workload identity federation rule; Admin API keys are not accepted. See [Manage WIF with the Admin API](/docs/en/manage-claude/wif-admin-api).
 *
 * Change a service account's role in a workspace.
 *
 * The new `workspace_role` replaces the current one. Only explicit
 * memberships can be updated; to set a role on the implicit
 * default-workspace membership, add the service account explicitly with
 * `POST /workspaces/{workspace_id}/service_accounts`. Archived workspaces
 * return 400. Archived service accounts cannot be updated and are
 * rejected.
 *
 * @see Anthropic\Services\Organization\Workspaces\ServiceAccountsService::update()
 *
 * @phpstan-type ServiceAccountUpdateParamsShape = array{
 *   workspaceID: string,
 *   workspaceRole: NoBillingWorkspaceRole|value-of<NoBillingWorkspaceRole>,
 * }
 */
final class ServiceAccountUpdateParams implements BaseModel
{
    /** @use SdkModel<ServiceAccountUpdateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * ID of the workspace.
     */
    #[Required]
    public string $workspaceID;

    /**
     * New role for the service account in this workspace.
     *
     * @var value-of<NoBillingWorkspaceRole> $workspaceRole
     */
    #[Required('workspace_role', enum: NoBillingWorkspaceRole::class)]
    public string $workspaceRole;

    /**
     * `new ServiceAccountUpdateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ServiceAccountUpdateParams::with(workspaceID: ..., workspaceRole: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ServiceAccountUpdateParams)->withWorkspaceID(...)->withWorkspaceRole(...)
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
     * ID of the workspace.
     */
    public function withWorkspaceID(string $workspaceID): self
    {
        $self = clone $this;
        $self['workspaceID'] = $workspaceID;

        return $self;
    }

    /**
     * New role for the service account in this workspace.
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
