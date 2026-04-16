<?php

declare(strict_types=1);

namespace Anthropic\Beta\UserProfiles;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\UserProfiles\UserProfileListParams\Order;
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
 *   page?: string|null,
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null,
 * }
 */
final class UserProfileListParams implements BaseModel
{
    /** @use SdkModel<UserProfileListParamsShape> */
    use SdkModel;
    use SdkParams;

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
     * Query parameter for page.
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
        ?int $limit = null,
        Order|string|null $order = null,
        ?string $page = null,
        ?array $betas = null,
    ): self {
        $self = new self;

        null !== $limit && $self['limit'] = $limit;
        null !== $order && $self['order'] = $order;
        null !== $page && $self['page'] = $page;
        null !== $betas && $self['betas'] = $betas;

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
     * Query parameter for page.
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
}
