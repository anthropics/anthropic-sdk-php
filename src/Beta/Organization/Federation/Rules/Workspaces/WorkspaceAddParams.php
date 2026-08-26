<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Federation\Rules\Workspaces;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * **Requires an OAuth access token with the `org:admin` scope**, from `ant auth login --scope org:admin` or a workload identity federation rule; Admin API keys are not accepted. See [Manage WIF with the Admin API](/docs/en/manage-claude/wif-admin-api).
 *
 * Enable a federation rule for a workspace.
 *
 * Idempotent; re-enabling returns the existing enablement. The rule and
 * workspace must both belong to your organization. Membership of the
 * rule's target service account in this workspace is not checked at
 * enablement: token exchange into this workspace is rejected unless the
 * target is a member (it is implicitly a member of the default workspace).
 * Archived rules are rejected with 400. OAuth callers may only manage rules
 * whose `oauth_scope` is `workspace:developer` or `workspace:inference`;
 * other scopes require a Console session.
 *
 * @see Anthropic\Services\Beta\Organization\Federation\Rules\WorkspacesService::add()
 *
 * @phpstan-type WorkspaceAddParamsShape = array{
 *   workspaceID: string,
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null,
 * }
 */
final class WorkspaceAddParams implements BaseModel
{
    /** @use SdkModel<WorkspaceAddParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Tagged ID of the workspace to enable this rule for.
     */
    #[Required('workspace_id')]
    public string $workspaceID;

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
     * WorkspaceAddParams::with(workspaceID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new WorkspaceAddParams)->withWorkspaceID(...)
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
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>>|null $betas
     */
    public static function with(string $workspaceID, ?array $betas = null): self
    {
        $self = new self;

        $self['workspaceID'] = $workspaceID;

        null !== $betas && $self['betas'] = $betas;

        return $self;
    }

    /**
     * Tagged ID of the workspace to enable this rule for.
     */
    public function withWorkspaceID(string $workspaceID): self
    {
        $self = clone $this;
        $self['workspaceID'] = $workspaceID;

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
