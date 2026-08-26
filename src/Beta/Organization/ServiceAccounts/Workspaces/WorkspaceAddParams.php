<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ServiceAccounts\Workspaces;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Organization\Workspaces\NoBillingWorkspaceRole;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

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
 * @see Anthropic\Services\Beta\Organization\ServiceAccounts\WorkspacesService::add()
 *
 * @phpstan-type WorkspaceAddParamsShape = array{
 *   workspaceID: string,
 *   workspaceRole: NoBillingWorkspaceRole|value-of<NoBillingWorkspaceRole>,
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null,
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
     * Optional header to specify the beta version(s) you want to use.
     *
     * @var list<string|value-of<AnthropicBeta>>|null $betas
     */
    #[Optional(list: AnthropicBeta::class)]
    public ?array $betas;

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
     * (new WorkspaceAddParams)->withWorkspaceID(...)->withWorkspaceRole(...)
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
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>>|null $betas
     */
    public static function with(
        string $workspaceID,
        NoBillingWorkspaceRole|string $workspaceRole,
        ?array $betas = null,
    ): self {
        $self = new self;

        $self['workspaceID'] = $workspaceID;
        $self['workspaceRole'] = $workspaceRole;

        null !== $betas && $self['betas'] = $betas;

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

    /**
     * Optional header to specify the beta version(s) you want to use.
     *
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas
     */
    public function withBetas(array $betas): self
    {
        $self = clone $this;
        $self['betas'] = $betas;

        return $self;
    }
}
