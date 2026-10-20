<?php

declare(strict_types=1);

namespace Anthropic\Beta\MemoryStores\Memories;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * List Memories.
 *
 * @see Anthropic\Services\Beta\MemoryStores\MemoriesService::list()
 *
 * @phpstan-type MemoryListParamsShape = array{
 *   depth?: int|null,
 *   limit?: int|null,
 *   page?: string|null,
 *   pathPrefix?: string|null,
 *   view?: null|ManagedAgentsMemoryView|value-of<ManagedAgentsMemoryView>,
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null,
 *   workspaceID?: string|null,
 * }
 */
final class MemoryListParams implements BaseModel
{
    /** @use SdkModel<MemoryListParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * How far below `path_prefix` to list. Defaults to `0`, which lists every memory below the prefix.
     *
     * Pass `1` to list only the direct children. Deeper memories are then grouped into `memory_prefix` items.
     */
    #[Optional]
    public ?int $depth;

    /**
     * The maximum number of items to return per page, from 1 to 100. Defaults to 20.
     *
     * With `view=full`, a page holds at most 20 items. `memory` and `memory_prefix` items both count toward the limit.
     */
    #[Optional]
    public ?int $limit;

    /**
     * The `next_page` value from a previous response, to get the next page. Omit it to get the first page.
     */
    #[Optional]
    public ?string $page;

    /**
     * Return only memories whose path starts with this prefix, such as `/notes/`. This value appears in request URLs. Do not include secrets or personally identifiable information.
     *
     * Omit it to list the whole store. The prefix must end with `/` and matches whole segments, so `/notes/` matches `/notes/todo.md` but not `/notes-archive/todo.md`.
     */
    #[Optional]
    public ?string $pathPrefix;

    /**
     * Whether each memory in the response includes `content`. Defaults to `basic`, which sets it to `null`.
     *
     * With `full`, a page holds at most 20 items.
     *
     * @var value-of<ManagedAgentsMemoryView>|null $view
     */
    #[Optional(enum: ManagedAgentsMemoryView::class)]
    public ?string $view;

    /**
     * This endpoint is in beta: requests must send `agent-memory-2026-07-22` or `managed-agents-2026-04-01` in this header.
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
     * @param ManagedAgentsMemoryView|value-of<ManagedAgentsMemoryView>|null $view
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>>|null $betas
     */
    public static function with(
        ?int $depth = null,
        ?int $limit = null,
        ?string $page = null,
        ?string $pathPrefix = null,
        ManagedAgentsMemoryView|string|null $view = null,
        ?array $betas = null,
        ?string $workspaceID = null,
    ): self {
        $self = new self;

        null !== $depth && $self['depth'] = $depth;
        null !== $limit && $self['limit'] = $limit;
        null !== $page && $self['page'] = $page;
        null !== $pathPrefix && $self['pathPrefix'] = $pathPrefix;
        null !== $view && $self['view'] = $view;
        null !== $betas && $self['betas'] = $betas;
        null !== $workspaceID && $self['workspaceID'] = $workspaceID;

        return $self;
    }

    /**
     * How far below `path_prefix` to list. Defaults to `0`, which lists every memory below the prefix.
     *
     * Pass `1` to list only the direct children. Deeper memories are then grouped into `memory_prefix` items.
     */
    public function withDepth(int $depth): self
    {
        $self = clone $this;
        $self['depth'] = $depth;

        return $self;
    }

    /**
     * The maximum number of items to return per page, from 1 to 100. Defaults to 20.
     *
     * With `view=full`, a page holds at most 20 items. `memory` and `memory_prefix` items both count toward the limit.
     */
    public function withLimit(int $limit): self
    {
        $self = clone $this;
        $self['limit'] = $limit;

        return $self;
    }

    /**
     * The `next_page` value from a previous response, to get the next page. Omit it to get the first page.
     */
    public function withPage(string $page): self
    {
        $self = clone $this;
        $self['page'] = $page;

        return $self;
    }

    /**
     * Return only memories whose path starts with this prefix, such as `/notes/`. This value appears in request URLs. Do not include secrets or personally identifiable information.
     *
     * Omit it to list the whole store. The prefix must end with `/` and matches whole segments, so `/notes/` matches `/notes/todo.md` but not `/notes-archive/todo.md`.
     */
    public function withPathPrefix(string $pathPrefix): self
    {
        $self = clone $this;
        $self['pathPrefix'] = $pathPrefix;

        return $self;
    }

    /**
     * Whether each memory in the response includes `content`. Defaults to `basic`, which sets it to `null`.
     *
     * With `full`, a page holds at most 20 items.
     *
     * @param ManagedAgentsMemoryView|value-of<ManagedAgentsMemoryView> $view
     */
    public function withView(ManagedAgentsMemoryView|string $view): self
    {
        $self = clone $this;
        $self['view'] = $view;

        return $self;
    }

    /**
     * This endpoint is in beta: requests must send `agent-memory-2026-07-22` or `managed-agents-2026-04-01` in this header.
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
