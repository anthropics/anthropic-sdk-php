<?php

declare(strict_types=1);

namespace Anthropic\Beta\MemoryStores\Memories;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\MemoryStores\Memories\MemoryListParams\Order;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * ListMemories.
 *
 * @see Anthropic\Services\Beta\MemoryStores\MemoriesService::list()
 *
 * @phpstan-type MemoryListParamsShape = array{
 *   depth?: int|null,
 *   limit?: int|null,
 *   order?: null|Order|value-of<Order>,
 *   orderBy?: string|null,
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
     * Query parameter for depth.
     */
    #[Optional]
    public ?int $depth;

    /**
     * Query parameter for limit.
     */
    #[Optional]
    public ?int $limit;

    /**
     * Query parameter for order.
     *
     * @var value-of<Order>|null $order
     */
    #[Optional(enum: Order::class)]
    public ?string $order;

    /**
     * Query parameter for order_by.
     */
    #[Optional]
    public ?string $orderBy;

    /**
     * Query parameter for page.
     */
    #[Optional]
    public ?string $page;

    /**
     * Optional path prefix filter (raw string-prefix match; include a trailing slash for directory-scoped lists). This value appears in request URLs. Do not include secrets or personally identifiable information.
     */
    #[Optional]
    public ?string $pathPrefix;

    /**
     * Query parameter for view.
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
     * @param Order|value-of<Order>|null $order
     * @param ManagedAgentsMemoryView|value-of<ManagedAgentsMemoryView>|null $view
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>>|null $betas
     */
    public static function with(
        ?int $depth = null,
        ?int $limit = null,
        Order|string|null $order = null,
        ?string $orderBy = null,
        ?string $page = null,
        ?string $pathPrefix = null,
        ManagedAgentsMemoryView|string|null $view = null,
        ?array $betas = null,
    ): self {
        $self = new self;

        null !== $depth && $self['depth'] = $depth;
        null !== $limit && $self['limit'] = $limit;
        null !== $order && $self['order'] = $order;
        null !== $orderBy && $self['orderBy'] = $orderBy;
        null !== $page && $self['page'] = $page;
        null !== $pathPrefix && $self['pathPrefix'] = $pathPrefix;
        null !== $view && $self['view'] = $view;
        null !== $betas && $self['betas'] = $betas;

        return $self;
    }

    /**
     * Query parameter for depth.
     */
    public function withDepth(int $depth): self
    {
        $self = clone $this;
        $self['depth'] = $depth;

        return $self;
    }

    /**
     * Query parameter for limit.
     */
    public function withLimit(int $limit): self
    {
        $self = clone $this;
        $self['limit'] = $limit;

        return $self;
    }

    /**
     * Query parameter for order.
     *
     * @param Order|value-of<Order> $order
     */
    public function withOrder(Order|string $order): self
    {
        $self = clone $this;
        $self['order'] = $order;

        return $self;
    }

    /**
     * Query parameter for order_by.
     */
    public function withOrderBy(string $orderBy): self
    {
        $self = clone $this;
        $self['orderBy'] = $orderBy;

        return $self;
    }

    /**
     * Query parameter for page.
     */
    public function withPage(string $page): self
    {
        $self = clone $this;
        $self['page'] = $page;

        return $self;
    }

    /**
     * Optional path prefix filter (raw string-prefix match; include a trailing slash for directory-scoped lists). This value appears in request URLs. Do not include secrets or personally identifiable information.
     */
    public function withPathPrefix(string $pathPrefix): self
    {
        $self = clone $this;
        $self['pathPrefix'] = $pathPrefix;

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
