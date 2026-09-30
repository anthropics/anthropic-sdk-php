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
 * Add a service account to a workspace with the given `workspace_role`.
 *
 * The role determines what the service account can do in the workspace and
 * which workspace-scoped permissions it can be granted when authenticating
 * through federation. Every service account is already an implicit
 * `workspace_user` member of the default workspace; adding it explicitly
 * assigns a chosen role. If the service account is already an explicit
 * member of the workspace, its `workspace_role` is replaced with the
 * value supplied here. Archived workspaces return 400. Archived service
 * accounts cannot be added and are rejected.
 *
 * @see Anthropic\Services\Organization\Workspaces\ServiceAccountsService::add()
 *
 * @phpstan-type ServiceAccountAddParamsShape = array{
 *   serviceAccountID: string,
 *   workspaceRole: NoBillingWorkspaceRole|value-of<NoBillingWorkspaceRole>,
 * }
 */
final class ServiceAccountAddParams implements BaseModel
{
    /** @use SdkModel<ServiceAccountAddParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Tagged service account ID to add.
     */
    #[Required('service_account_id')]
    public string $serviceAccountID;

    /**
     * Role to assign to the service account in this workspace.
     *
     * @var value-of<NoBillingWorkspaceRole> $workspaceRole
     */
    #[Required('workspace_role', enum: NoBillingWorkspaceRole::class)]
    public string $workspaceRole;

    /**
     * `new ServiceAccountAddParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ServiceAccountAddParams::with(serviceAccountID: ..., workspaceRole: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ServiceAccountAddParams)->withServiceAccountID(...)->withWorkspaceRole(...)
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
        string $serviceAccountID,
        NoBillingWorkspaceRole|string $workspaceRole
    ): self {
        $self = new self;

        $self['serviceAccountID'] = $serviceAccountID;
        $self['workspaceRole'] = $workspaceRole;

        return $self;
    }

    /**
     * Tagged service account ID to add.
     */
    public function withServiceAccountID(string $serviceAccountID): self
    {
        $self = clone $this;
        $self['serviceAccountID'] = $serviceAccountID;

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
