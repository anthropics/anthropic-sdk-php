<?php

declare(strict_types=1);

namespace Anthropic\Beta\UserProfiles;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\UserProfiles\UserProfileListParams\Order;
use Anthropic\Beta\UserProfiles\UserProfileListParams\OrderBy;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * List User Profiles.
 *
 * @see Anthropic\Services\Beta\UserProfilesService::list()
 *
 * @phpstan-type UserProfileListParamsShape = array{
 *   limit?: int|null,
 *   order?: null|Order|value-of<Order>,
 *   orderBy?: null|OrderBy|value-of<OrderBy>,
 *   page?: string|null,
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null,
 *   workspaceID?: string|null,
 * }
 */
final class UserProfileListParams implements BaseModel
{
    /** @use SdkModel<UserProfileListParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * The maximum number of user profiles to return, from 1 to 100. Defaults to 20.
     */
    #[Optional]
    public ?int $limit;

    /**
     * The sort direction, applied to the field that `order_by` selects. Defaults to `desc`.
     *
     * @var value-of<Order>|null $order
     */
    #[Optional(enum: Order::class)]
    public ?string $order;

    /**
     * The field to sort user profiles by, in the direction that `order` sets. Defaults to `created_at`.
     *
     * @var value-of<OrderBy>|null $orderBy
     */
    #[Optional(enum: OrderBy::class)]
    public ?string $orderBy;

    /**
     * The cursor for the page to return, taken from `next_page` in a previous response.
     *
     * Leave it out to get the first page.
     */
    #[Optional]
    public ?string $page;

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
     * @param Order|value-of<Order>|null $order
     * @param OrderBy|value-of<OrderBy>|null $orderBy
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>>|null $betas
     */
    public static function with(
        ?int $limit = null,
        Order|string|null $order = null,
        OrderBy|string|null $orderBy = null,
        ?string $page = null,
        ?array $betas = null,
        ?string $workspaceID = null,
    ): self {
        $self = new self;

        null !== $limit && $self['limit'] = $limit;
        null !== $order && $self['order'] = $order;
        null !== $orderBy && $self['orderBy'] = $orderBy;
        null !== $page && $self['page'] = $page;
        null !== $betas && $self['betas'] = $betas;
        null !== $workspaceID && $self['workspaceID'] = $workspaceID;

        return $self;
    }

    /**
     * The maximum number of user profiles to return, from 1 to 100. Defaults to 20.
     */
    public function withLimit(int $limit): self
    {
        $self = clone $this;
        $self['limit'] = $limit;

        return $self;
    }

    /**
     * The sort direction, applied to the field that `order_by` selects. Defaults to `desc`.
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
     * The field to sort user profiles by, in the direction that `order` sets. Defaults to `created_at`.
     *
     * @param OrderBy|value-of<OrderBy> $orderBy
     */
    public function withOrderBy(OrderBy|string $orderBy): self
    {
        $self = clone $this;
        $self['orderBy'] = $orderBy;

        return $self;
    }

    /**
     * The cursor for the page to return, taken from `next_page` in a previous response.
     *
     * Leave it out to get the first page.
     */
    public function withPage(string $page): self
    {
        $self = clone $this;
        $self['page'] = $page;

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
