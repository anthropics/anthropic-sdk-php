<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Threads;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * List Session Threads.
 *
 * @see Anthropic\Services\Beta\Sessions\ThreadsService::list()
 *
 * @phpstan-type ThreadListParamsShape = array{
 *   limit?: int|null,
 *   page?: string|null,
 *   statuses?: list<ManagedAgentsSessionThreadStatus|value-of<ManagedAgentsSessionThreadStatus>>|null,
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null,
 *   workspaceID?: string|null,
 * }
 */
final class ThreadListParams implements BaseModel
{
    /** @use SdkModel<ThreadListParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Maximum results per page. Defaults to 1000.
     */
    #[Optional]
    public ?int $limit;

    /**
     * Opaque pagination cursor from a previous response's `next_page`. Forward-only.
     */
    #[Optional]
    public ?string $page;

    /**
     * Return only threads that have one of these statuses.
     *
     * Repeat the parameter to give more than one status. Leave it out to return threads of every status.
     *
     * @var list<value-of<ManagedAgentsSessionThreadStatus>>|null $statuses
     */
    #[Optional(list: ManagedAgentsSessionThreadStatus::class)]
    public ?array $statuses;

    /**
     * Optional header to specify the beta version(s) you want to use.
     *
     * @var list<string|value-of<AnthropicBeta>>|null $betas
     */
    #[Optional(list: AnthropicBeta::class)]
    public ?array $betas;

    /**
     * Optional header to select the Workspace for this request. The value is a Workspace ID (for example, `wrkspc_011CZkZaBF1tNoB5wlCeusgy`).
     *
     * Only needed for credentials that can act on more than one Workspace. A credential that belongs to a specific Workspace may omit it; if sent, it must match that Workspace.
     */
    #[Optional]
    public ?string $workspaceID;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<ManagedAgentsSessionThreadStatus|value-of<ManagedAgentsSessionThreadStatus>>|null $statuses
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>>|null $betas
     */
    public static function with(
        ?int $limit = null,
        ?string $page = null,
        ?array $statuses = null,
        ?array $betas = null,
        ?string $workspaceID = null,
    ): self {
        $self = new self;

        null !== $limit && $self['limit'] = $limit;
        null !== $page && $self['page'] = $page;
        null !== $statuses && $self['statuses'] = $statuses;
        null !== $betas && $self['betas'] = $betas;
        null !== $workspaceID && $self['workspaceID'] = $workspaceID;

        return $self;
    }

    /**
     * Maximum results per page. Defaults to 1000.
     */
    public function withLimit(int $limit): self
    {
        $self = clone $this;
        $self['limit'] = $limit;

        return $self;
    }

    /**
     * Opaque pagination cursor from a previous response's `next_page`. Forward-only.
     */
    public function withPage(string $page): self
    {
        $self = clone $this;
        $self['page'] = $page;

        return $self;
    }

    /**
     * Return only threads that have one of these statuses.
     *
     * Repeat the parameter to give more than one status. Leave it out to return threads of every status.
     *
     * @param list<ManagedAgentsSessionThreadStatus|value-of<ManagedAgentsSessionThreadStatus>> $statuses
     */
    public function withStatuses(array $statuses): self
    {
        $self = clone $this;
        $self['statuses'] = $statuses;

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

    /**
     * Optional header to select the Workspace for this request. The value is a Workspace ID (for example, `wrkspc_011CZkZaBF1tNoB5wlCeusgy`).
     *
     * Only needed for credentials that can act on more than one Workspace. A credential that belongs to a specific Workspace may omit it; if sent, it must match that Workspace.
     */
    public function withWorkspaceID(string $workspaceID): self
    {
        $self = clone $this;
        $self['workspaceID'] = $workspaceID;

        return $self;
    }
}
