<?php

declare(strict_types=1);

namespace Anthropic\Beta\MemoryStores\Memories;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Update a Memory.
 *
 * @see Anthropic\Services\Beta\MemoryStores\MemoriesService::update()
 *
 * @phpstan-import-type ManagedAgentsPreconditionShape from \Anthropic\Beta\MemoryStores\Memories\ManagedAgentsPrecondition
 *
 * @phpstan-type MemoryUpdateParamsShape = array{
 *   memoryStoreID: string,
 *   view?: null|ManagedAgentsMemoryView|value-of<ManagedAgentsMemoryView>,
 *   content?: string|null,
 *   path?: string|null,
 *   precondition?: null|ManagedAgentsPrecondition|ManagedAgentsPreconditionShape,
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null,
 *   workspaceID?: string|null,
 * }
 */
final class MemoryUpdateParams implements BaseModel
{
    /** @use SdkModel<MemoryUpdateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * The ID of the memory store that holds the memory (`memstore_...`).
     */
    #[Required]
    public string $memoryStoreID;

    /**
     * Whether a `memory` or `memory_version` in the response includes its `content`. Defaults to `full` on retrieve operations and to `basic` on list, create, and update operations.
     *
     * With `full`, list operations return at most 20 items per page.
     *
     * @var value-of<ManagedAgentsMemoryView>|null $view
     */
    #[Optional(enum: ManagedAgentsMemoryView::class)]
    public ?string $view;

    /**
     * New UTF-8 text content for the memory. Maximum 100 kB (102,400 bytes). Omit to leave the content unchanged (e.g., for a rename-only update).
     */
    #[Optional(nullable: true)]
    public ?string $content;

    /**
     * The new path of the memory, which renames it. Omit it to keep the current path.
     *
     * The memory keeps its `id`. A path starts with `/` and has 1 to 20 segments. A segment can't be empty and can't be `.` or `..`. A path can't contain control characters, format characters, or the line and paragraph separators U+2028 and U+2029. It must be in Unicode Normalization Form C and at most 1,024 bytes long. Paths are case-sensitive.
     */
    #[Optional(nullable: true)]
    public ?string $path;

    /**
     * The condition that the memory must meet for the update to apply. Omit it to update unconditionally.
     *
     * If the condition fails, the request fails with HTTP status 409.
     */
    #[Optional]
    public ?ManagedAgentsPrecondition $precondition;

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

    /**
     * `new MemoryUpdateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * MemoryUpdateParams::with(memoryStoreID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new MemoryUpdateParams())->withMemoryStoreID(...)
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
     * @param ManagedAgentsMemoryView|value-of<ManagedAgentsMemoryView>|null $view
     * @param ManagedAgentsPrecondition|ManagedAgentsPreconditionShape|null $precondition
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>>|null $betas
     */
    public static function with(
        string $memoryStoreID,
        ManagedAgentsMemoryView|string|null $view = null,
        ?string $content = null,
        ?string $path = null,
        ManagedAgentsPrecondition|array|null $precondition = null,
        ?array $betas = null,
        ?string $workspaceID = null,
    ): self {
        $self = new self;

        $self['memoryStoreID'] = $memoryStoreID;

        null !== $view && $self['view'] = $view;
        null !== $content && $self['content'] = $content;
        null !== $path && $self['path'] = $path;
        null !== $precondition && $self['precondition'] = $precondition;
        null !== $betas && $self['betas'] = $betas;
        null !== $workspaceID && $self['workspaceID'] = $workspaceID;

        return $self;
    }

    /**
     * The ID of the memory store that holds the memory (`memstore_...`).
     */
    public function withMemoryStoreID(string $memoryStoreID): self
    {
        $self = clone $this;
        $self['memoryStoreID'] = $memoryStoreID;

        return $self;
    }

    /**
     * Whether a `memory` or `memory_version` in the response includes its `content`. Defaults to `full` on retrieve operations and to `basic` on list, create, and update operations.
     *
     * With `full`, list operations return at most 20 items per page.
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
     * New UTF-8 text content for the memory. Maximum 100 kB (102,400 bytes). Omit to leave the content unchanged (e.g., for a rename-only update).
     */
    public function withContent(?string $content): self
    {
        $self = clone $this;
        $self['content'] = $content;

        return $self;
    }

    /**
     * The new path of the memory, which renames it. Omit it to keep the current path.
     *
     * The memory keeps its `id`. A path starts with `/` and has 1 to 20 segments. A segment can't be empty and can't be `.` or `..`. A path can't contain control characters, format characters, or the line and paragraph separators U+2028 and U+2029. It must be in Unicode Normalization Form C and at most 1,024 bytes long. Paths are case-sensitive.
     */
    public function withPath(?string $path): self
    {
        $self = clone $this;
        $self['path'] = $path;

        return $self;
    }

    /**
     * The condition that the memory must meet for the update to apply. Omit it to update unconditionally.
     *
     * If the condition fails, the request fails with HTTP status 409.
     *
     * @param ManagedAgentsPrecondition|ManagedAgentsPreconditionShape $precondition
     */
    public function withPrecondition(
        ManagedAgentsPrecondition|array $precondition
    ): self {
        $self = clone $this;
        $self['precondition'] = $precondition;

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
