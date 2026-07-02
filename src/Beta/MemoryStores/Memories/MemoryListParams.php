<?php

declare(strict_types=1);

namespace Anthropic\Beta\MemoryStores\Memories;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * List memories.
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
 * }
 */
final class MemoryListParams implements BaseModel
{
    /** @use SdkModel<MemoryListParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * `0` (or omitted) returns all descendants below `path_prefix` (recursive). `1` returns immediate children only; deeper entries roll up as `memory_prefix` items. `depth=1` behaves like `ls`; omitting `depth` behaves like `find`.
     */
    #[Optional]
    public ?int $depth;

    /**
     * Maximum number of items to return per page. Must be between 1 and 100. Defaults to 20 when omitted. Capped at 20 when `view=full`. Both `memory` and `memory_prefix` items count toward the limit.
     */
    #[Optional]
    public ?int $limit;

    /**
     * Opaque pagination cursor (a `page_...` value). Pass the `next_page` value from a previous response to fetch the next page; omit for the first page.
     */
    #[Optional]
    public ?string $page;

    /**
     * Optional path prefix filter. Must end with `/` (segment-aligned), e.g., `/notes/`. This value appears in request URLs. Do not include secrets or personally identifiable information.
     */
    #[Optional]
    public ?string $pathPrefix;

    /**
     * Which projection of each `memory` to return. Defaults to `basic` (content omitted). `full` populates `content` on each item and caps `limit` at 20; use this as the bulk-read path for export and sync.
     *
     * @var value-of<ManagedAgentsMemoryView>|null $view
     */
    #[Optional(enum: ManagedAgentsMemoryView::class)]
    public ?string $view;

    /**
     * Optional header to specify the beta version(s) you want to use.
     *
     * @var list<string|value-of<AnthropicBeta>>|null $betas
     */
    #[Optional(list: AnthropicBeta::class)]
    public ?array $betas;

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
    ): self {
        $self = new self;

        null !== $depth && $self['depth'] = $depth;
        null !== $limit && $self['limit'] = $limit;
        null !== $page && $self['page'] = $page;
        null !== $pathPrefix && $self['pathPrefix'] = $pathPrefix;
        null !== $view && $self['view'] = $view;
        null !== $betas && $self['betas'] = $betas;

        return $self;
    }

    /**
     * `0` (or omitted) returns all descendants below `path_prefix` (recursive). `1` returns immediate children only; deeper entries roll up as `memory_prefix` items. `depth=1` behaves like `ls`; omitting `depth` behaves like `find`.
     */
    public function withDepth(int $depth): self
    {
        $self = clone $this;
        $self['depth'] = $depth;

        return $self;
    }

    /**
     * Maximum number of items to return per page. Must be between 1 and 100. Defaults to 20 when omitted. Capped at 20 when `view=full`. Both `memory` and `memory_prefix` items count toward the limit.
     */
    public function withLimit(int $limit): self
    {
        $self = clone $this;
        $self['limit'] = $limit;

        return $self;
    }

    /**
     * Opaque pagination cursor (a `page_...` value). Pass the `next_page` value from a previous response to fetch the next page; omit for the first page.
     */
    public function withPage(string $page): self
    {
        $self = clone $this;
        $self['page'] = $page;

        return $self;
    }

    /**
     * Optional path prefix filter. Must end with `/` (segment-aligned), e.g., `/notes/`. This value appears in request URLs. Do not include secrets or personally identifiable information.
     */
    public function withPathPrefix(string $pathPrefix): self
    {
        $self = clone $this;
        $self['pathPrefix'] = $pathPrefix;

        return $self;
    }

    /**
     * Which projection of each `memory` to return. Defaults to `basic` (content omitted). `full` populates `content` on each item and caps `limit` at 20; use this as the bulk-read path for export and sync.
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
