<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Webhooks;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Organization\Webhooks\WebhookListParams\Order;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * List the organization's webhook endpoints.
 *
 * An organization webhook endpoint belongs to the organization rather than to one of its workspaces. The list does not include webhook endpoints that
 * belong to a workspace.
 *
 * Every request must include the beta header `anthropic-beta: webhooks-2026-10-07`. A request without it returns `404`, exactly as if this API did not exist. Anthropic turns organization webhook endpoints on for each organization; until yours is on, requests also return `404`. Organization webhook endpoints are in beta and are not available to organizations with HIPAA readiness enabled.
 *
 * @see Anthropic\Services\Beta\Organization\WebhooksService::list()
 *
 * @phpstan-type WebhookListParamsShape = array{
 *   afterID?: string|null,
 *   beforeID?: string|null,
 *   limit?: int|null,
 *   order?: null|Order|value-of<Order>,
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null,
 * }
 */
final class WebhookListParams implements BaseModel
{
    /** @use SdkModel<WebhookListParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * ID of the object to use as a cursor for pagination. When provided, returns the page of results immediately after this object.
     */
    #[Optional(nullable: true)]
    public ?string $afterID;

    /**
     * ID of a webhook endpoint to use as a cursor. Returns the first `limit` endpoints that come before it in list order, not the `limit` endpoints just before it.
     */
    #[Optional(nullable: true)]
    public ?string $beforeID;

    /**
     * Number of items to return per page, up to `100`. The default, `0`, means `20`.
     */
    #[Optional]
    public ?int $limit;

    /**
     * Sort order by `created_at`. Defaults to `desc`, newest first.
     *
     * @var value-of<Order>|null $order
     */
    #[Optional(enum: Order::class, nullable: true)]
    public ?string $order;

    /**
     * This endpoint is in beta: requests must send `webhooks-2026-10-07` in this header.
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
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>>|null $betas
     */
    public static function with(
        ?string $afterID = null,
        ?string $beforeID = null,
        ?int $limit = null,
        Order|string|null $order = null,
        ?array $betas = null,
    ): self {
        $self = new self;

        null !== $afterID && $self['afterID'] = $afterID;
        null !== $beforeID && $self['beforeID'] = $beforeID;
        null !== $limit && $self['limit'] = $limit;
        null !== $order && $self['order'] = $order;
        null !== $betas && $self['betas'] = $betas;

        return $self;
    }

    /**
     * ID of the object to use as a cursor for pagination. When provided, returns the page of results immediately after this object.
     */
    public function withAfterID(?string $afterID): self
    {
        $self = clone $this;
        $self['afterID'] = $afterID;

        return $self;
    }

    /**
     * ID of a webhook endpoint to use as a cursor. Returns the first `limit` endpoints that come before it in list order, not the `limit` endpoints just before it.
     */
    public function withBeforeID(?string $beforeID): self
    {
        $self = clone $this;
        $self['beforeID'] = $beforeID;

        return $self;
    }

    /**
     * Number of items to return per page, up to `100`. The default, `0`, means `20`.
     */
    public function withLimit(int $limit): self
    {
        $self = clone $this;
        $self['limit'] = $limit;

        return $self;
    }

    /**
     * Sort order by `created_at`. Defaults to `desc`, newest first.
     *
     * @param Order|value-of<Order>|null $order
     */
    public function withOrder(Order|string|null $order): self
    {
        $self = clone $this;
        $self['order'] = $order;

        return $self;
    }

    /**
     * This endpoint is in beta: requests must send `webhooks-2026-10-07` in this header.
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
