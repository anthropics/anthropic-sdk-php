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
 * Retrieve a service account's membership in a workspace.
 *
 * Returns the membership record, including the service account's
 * `workspace_role` in this workspace. Archived workspaces return 400. For
 * the default workspace, returns the implicit (`implicit: true`)
 * membership when no explicit membership exists; an explicitly added
 * membership is returned with its assigned role. An archived service
 * account returns 404.
 *
 * @see Anthropic\Services\Beta\Organization\Workspaces\ServiceAccountsService::retrieve()
 *
 * @phpstan-type ServiceAccountRetrieveParamsShape = array{
 *   workspaceID: string,
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null,
 * }
 */
final class ServiceAccountRetrieveParams implements BaseModel
{
    /** @use SdkModel<ServiceAccountRetrieveParamsShape> */
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
     * `new ServiceAccountRetrieveParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ServiceAccountRetrieveParams::with(workspaceID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ServiceAccountRetrieveParams)->withWorkspaceID(...)
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
