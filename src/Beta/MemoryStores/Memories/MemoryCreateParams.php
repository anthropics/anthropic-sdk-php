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
 * Create a Memory.
 *
 * @see Anthropic\Services\Beta\MemoryStores\MemoriesService::create()
 *
 * @phpstan-type MemoryCreateParamsShape = array{
 *   content: string|null,
 *   path: string,
 *   view?: null|ManagedAgentsMemoryView|value-of<ManagedAgentsMemoryView>,
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null,
 *   workspaceID?: string|null,
 * }
 */
final class MemoryCreateParams implements BaseModel
{
    /** @use SdkModel<MemoryCreateParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * The UTF-8 text content of the new memory. Pass `""` to create an empty memory.
     *
     * The maximum size is 100 kB (102,400 bytes).
     */
    #[Required]
    public ?string $content;

    /**
     * The path of the new memory, such as `/projects/foo/notes.md`. Paths are case-sensitive.
     *
     * A path starts with `/` and has 1 to 20 segments. A segment can't be empty and can't be `.` or `..`. A path can't contain control characters, format characters, or the line and paragraph separators U+2028 and U+2029. It must be in Unicode Normalization Form C and at most 1,024 bytes long.
     */
    #[Required]
    public string $path;

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
     * `new MemoryCreateParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * MemoryCreateParams::with(content: ..., path: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new MemoryCreateParams())->withContent(...)->withPath(...)
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
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>>|null $betas
     */
    public static function with(
        ?string $content,
        string $path,
        ManagedAgentsMemoryView|string|null $view = null,
        ?array $betas = null,
        ?string $workspaceID = null,
    ): self {
        $self = new self;

        $self['content'] = $content;
        $self['path'] = $path;

        null !== $view && $self['view'] = $view;
        null !== $betas && $self['betas'] = $betas;
        null !== $workspaceID && $self['workspaceID'] = $workspaceID;

        return $self;
    }

    /**
     * The UTF-8 text content of the new memory. Pass `""` to create an empty memory.
     *
     * The maximum size is 100 kB (102,400 bytes).
     */
    public function withContent(?string $content): self
    {
        $self = clone $this;
        $self['content'] = $content;

        return $self;
    }

    /**
     * The path of the new memory, such as `/projects/foo/notes.md`. Paths are case-sensitive.
     *
     * A path starts with `/` and has 1 to 20 segments. A segment can't be empty and can't be `.` or `..`. A path can't contain control characters, format characters, or the line and paragraph separators U+2028 and U+2029. It must be in Unicode Normalization Form C and at most 1,024 bytes long.
     */
    public function withPath(string $path): self
    {
        $self = clone $this;
        $self['path'] = $path;

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
