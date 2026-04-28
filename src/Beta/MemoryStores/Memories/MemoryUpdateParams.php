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
 * Update a memory.
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
 * }
 */
final class MemoryUpdateParams implements BaseModel
{
    /** @use SdkModel<MemoryUpdateParamsShape> */
    use SdkModel;
    use SdkParams;

    #[Required]
    public string $memoryStoreID;

    /**
     * Query parameter for view.
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
     * New path for the memory (a rename). Must start with `/`, contain at least one non-empty segment, and be at most 1,024 bytes. Must not contain empty segments, `.` or `..` segments, control or format characters, and must be NFC-normalized. Paths are case-sensitive. The memory's `id` is preserved across renames. Omit to leave the path unchanged.
     */
    #[Optional(nullable: true)]
    public ?string $path;

    /**
     * Optimistic-concurrency precondition: the update applies only if the memory's stored `content_sha256` equals the supplied value. On mismatch, the request returns `memory_precondition_failed_error` (HTTP 409); re-read the memory and retry against the fresh state. If the precondition fails but the stored state already exactly matches the requested `content` and `path`, the server returns 200 instead of 409.
     */
    #[Optional]
    public ?ManagedAgentsPrecondition $precondition;

    /**
     * Optional header to specify the beta version(s) you want to use.
     *
     * @var list<string|value-of<AnthropicBeta>>|null $betas
     */
    #[Optional(list: AnthropicBeta::class)]
    public ?array $betas;

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
     * (new MemoryUpdateParams)->withMemoryStoreID(...)
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
    ): self {
        $self = new self;

        $self['memoryStoreID'] = $memoryStoreID;

        null !== $view && $self['view'] = $view;
        null !== $content && $self['content'] = $content;
        null !== $path && $self['path'] = $path;
        null !== $precondition && $self['precondition'] = $precondition;
        null !== $betas && $self['betas'] = $betas;

        return $self;
    }

    public function withMemoryStoreID(string $memoryStoreID): self
    {
        $self = clone $this;
        $self['memoryStoreID'] = $memoryStoreID;

        return $self;
    }

    /**
     * Query parameter for view.
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
     * New path for the memory (a rename). Must start with `/`, contain at least one non-empty segment, and be at most 1,024 bytes. Must not contain empty segments, `.` or `..` segments, control or format characters, and must be NFC-normalized. Paths are case-sensitive. The memory's `id` is preserved across renames. Omit to leave the path unchanged.
     */
    public function withPath(?string $path): self
    {
        $self = clone $this;
        $self['path'] = $path;

        return $self;
    }

    /**
     * Optimistic-concurrency precondition: the update applies only if the memory's stored `content_sha256` equals the supplied value. On mismatch, the request returns `memory_precondition_failed_error` (HTTP 409); re-read the memory and retry against the fresh state. If the precondition fails but the stored state already exactly matches the requested `content` and `path`, the server returns 200 instead of 409.
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
