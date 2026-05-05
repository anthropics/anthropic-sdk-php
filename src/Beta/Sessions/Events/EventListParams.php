<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Sessions\Events\EventListParams\Order;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * List Events.
 *
 * @see Anthropic\Services\Beta\Sessions\EventsService::list()
 *
 * @phpstan-type EventListParamsShape = array{
 *   createdAtGt?: \DateTimeInterface|null,
 *   createdAtGte?: \DateTimeInterface|null,
 *   createdAtLt?: \DateTimeInterface|null,
 *   createdAtLte?: \DateTimeInterface|null,
 *   limit?: int|null,
 *   order?: null|Order|value-of<Order>,
 *   page?: string|null,
 *   types?: list<string>|null,
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null,
 * }
 */
final class EventListParams implements BaseModel
{
    /** @use SdkModel<EventListParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Return events created after this time (exclusive).
     */
    #[Optional]
    public ?\DateTimeInterface $createdAtGt;

    /**
     * Return events created at or after this time (inclusive).
     */
    #[Optional]
    public ?\DateTimeInterface $createdAtGte;

    /**
     * Return events created before this time (exclusive).
     */
    #[Optional]
    public ?\DateTimeInterface $createdAtLt;

    /**
     * Return events created at or before this time (inclusive).
     */
    #[Optional]
    public ?\DateTimeInterface $createdAtLte;

    /**
     * Query parameter for limit.
     */
    #[Optional]
    public ?int $limit;

    /**
     * Sort direction for results, ordered by created_at. Defaults to asc (chronological).
     *
     * @var value-of<Order>|null $order
     */
    #[Optional(enum: Order::class)]
    public ?string $order;

    /**
     * Opaque pagination cursor from a previous response's next_page.
     */
    #[Optional]
    public ?string $page;

    /**
     * Filter by event type. Values match the `type` field on returned events (for example, `user.message` or `agent.tool_use`). Omit to return all event types.
     *
     * @var list<string>|null $types
     */
    #[Optional(list: 'string')]
    public ?array $types;

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
     * @param list<string>|null $types
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>>|null $betas
     */
    public static function with(
        ?\DateTimeInterface $createdAtGt = null,
        ?\DateTimeInterface $createdAtGte = null,
        ?\DateTimeInterface $createdAtLt = null,
        ?\DateTimeInterface $createdAtLte = null,
        ?int $limit = null,
        Order|string|null $order = null,
        ?string $page = null,
        ?array $types = null,
        ?array $betas = null,
    ): self {
        $self = new self;

        null !== $createdAtGt && $self['createdAtGt'] = $createdAtGt;
        null !== $createdAtGte && $self['createdAtGte'] = $createdAtGte;
        null !== $createdAtLt && $self['createdAtLt'] = $createdAtLt;
        null !== $createdAtLte && $self['createdAtLte'] = $createdAtLte;
        null !== $limit && $self['limit'] = $limit;
        null !== $order && $self['order'] = $order;
        null !== $page && $self['page'] = $page;
        null !== $types && $self['types'] = $types;
        null !== $betas && $self['betas'] = $betas;

        return $self;
    }

    /**
     * Return events created after this time (exclusive).
     */
    public function withCreatedAtGt(\DateTimeInterface $createdAtGt): self
    {
        $self = clone $this;
        $self['createdAtGt'] = $createdAtGt;

        return $self;
    }

    /**
     * Return events created at or after this time (inclusive).
     */
    public function withCreatedAtGte(\DateTimeInterface $createdAtGte): self
    {
        $self = clone $this;
        $self['createdAtGte'] = $createdAtGte;

        return $self;
    }

    /**
     * Return events created before this time (exclusive).
     */
    public function withCreatedAtLt(\DateTimeInterface $createdAtLt): self
    {
        $self = clone $this;
        $self['createdAtLt'] = $createdAtLt;

        return $self;
    }

    /**
     * Return events created at or before this time (inclusive).
     */
    public function withCreatedAtLte(\DateTimeInterface $createdAtLte): self
    {
        $self = clone $this;
        $self['createdAtLte'] = $createdAtLte;

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
     * Sort direction for results, ordered by created_at. Defaults to asc (chronological).
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
     * Opaque pagination cursor from a previous response's next_page.
     */
    public function withPage(string $page): self
    {
        $self = clone $this;
        $self['page'] = $page;

        return $self;
    }

    /**
     * Filter by event type. Values match the `type` field on returned events (for example, `user.message` or `agent.tool_use`). Omit to return all event types.
     *
     * @param list<string> $types
     */
    public function withTypes(array $types): self
    {
        $self = clone $this;
        $self['types'] = $types;

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
