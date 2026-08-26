<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Workspaces\ServiceAccounts;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * **Requires an OAuth access token with the `org:admin` scope**, from `ant auth login --scope org:admin` or a workload identity federation rule; Admin API keys are not accepted. See [Manage WIF with the Admin API](/docs/en/manage-claude/wif-admin-api).
 *
 * Remove a service account from a workspace.
 *
 * Removal is idempotent (returns 200 even if the membership was already
 * removed). A DELETE against the implicit default-workspace membership
 * returns 200 but is a no-op and the membership persists; deleting an
 * explicit default-workspace row reverts to the implicit `workspace_user`
 * membership. Archived workspaces return 400.
 *
 * @see Anthropic\Services\Beta\Organization\Workspaces\ServiceAccountsService::remove()
 *
 * @phpstan-type ServiceAccountRemoveParamsShape = array{
 *   workspaceID: string,
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null,
 * }
 */
final class ServiceAccountRemoveParams implements BaseModel
{
    /** @use SdkModel<ServiceAccountRemoveParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * ID of the workspace.
     */
    #[Required]
    public string $workspaceID;

    /**
     * Optional header to specify the beta version(s) you want to use.
     *
     * @var list<string|value-of<AnthropicBeta>>|null $betas
     */
    #[Optional(list: AnthropicBeta::class)]
    public ?array $betas;

    /**
     * `new ServiceAccountRemoveParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ServiceAccountRemoveParams::with(workspaceID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ServiceAccountRemoveParams)->withWorkspaceID(...)
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
     * ID of the workspace.
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
