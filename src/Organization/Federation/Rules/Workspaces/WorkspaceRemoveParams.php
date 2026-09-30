<?php

declare(strict_types=1);

namespace Anthropic\Organization\Federation\Rules\Workspaces;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * **Requires an OAuth access token with the `org:admin` scope**, from `ant auth login --scope org:admin` or a workload identity federation rule; Admin API keys are not accepted. See [Manage WIF with the Admin API](/docs/en/manage-claude/wif-admin-api).
 *
 * Disable a federation rule for a workspace.
 *
 * Idempotent; succeeds even if the enablement was already removed. OAuth
 * callers may only manage rules whose `oauth_scope` is
 * `workspace:developer` or `workspace:inference`; other scopes require a
 * Console session.
 *
 * @see Anthropic\Services\Organization\Federation\Rules\WorkspacesService::remove()
 *
 * @phpstan-type WorkspaceRemoveParamsShape = array{federationRuleID: string}
 */
final class WorkspaceRemoveParams implements BaseModel
{
    /** @use SdkModel<WorkspaceRemoveParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * ID of the federation rule.
     */
    #[Required]
    public string $federationRuleID;

    /**
     * `new WorkspaceRemoveParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * WorkspaceRemoveParams::with(federationRuleID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new WorkspaceRemoveParams)->withFederationRuleID(...)
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
    public static function with(string $federationRuleID): self
    {
        $self = new self;

        $self['federationRuleID'] = $federationRuleID;

        return $self;
    }

    /**
     * ID of the federation rule.
     */
    public function withFederationRuleID(string $federationRuleID): self
    {
        $self = clone $this;
        $self['federationRuleID'] = $federationRuleID;

        return $self;
    }
}
