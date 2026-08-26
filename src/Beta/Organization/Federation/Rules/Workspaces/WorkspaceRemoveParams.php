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
 * Disable a federation rule for a workspace.
 *
 * Idempotent; succeeds even if the enablement was already removed. OAuth
 * callers may only manage rules whose `oauth_scope` is
 * `workspace:developer` or `workspace:inference`; other scopes require a
 * Console session.
 *
 * @see Anthropic\Services\Beta\Organization\Federation\Rules\WorkspacesService::remove()
 *
 * @phpstan-type WorkspaceRemoveParamsShape = array{
 *   federationRuleID: string,
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null,
 * }
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
     * Optional header to specify the beta version(s) you want to use.
     *
     * @var list<string|value-of<AnthropicBeta>>|null $betas
     */
    #[Optional(list: AnthropicBeta::class)]
    public ?array $betas;

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
     *
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>>|null $betas
     */
    public static function with(
        string $federationRuleID,
        ?array $betas = null
    ): self {
        $self = new self;

        $self['federationRuleID'] = $federationRuleID;

        null !== $betas && $self['betas'] = $betas;

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
