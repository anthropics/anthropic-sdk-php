<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\RateLimits;

use Anthropic\Beta\Organization\RateLimits\RateLimitListParams\GroupType;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * List Messages API rate limits for your organization.
 *
 * Each entry corresponds to one rate-limit group (either a model family
 * or an API-surface category such as the Files API or Message Batches)
 * and contains the set of limiter values that apply to it.
 *
 * When `limit` is omitted, every matching entry is returned in a single
 * page; when `limit` truncates the result, follow `next_page` to fetch
 * the remaining entries.
 *
 * @see Anthropic\Services\Beta\Organization\RateLimitsService::list()
 *
 * @phpstan-type RateLimitListParamsShape = array{
 *   groupType?: null|GroupType|value-of<GroupType>,
 *   limit?: int|null,
 *   model?: string|null,
 *   page?: string|null,
 * }
 */
final class RateLimitListParams implements BaseModel
{
    /** @use SdkModel<RateLimitListParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Filter by group type.
     *
     * @var value-of<GroupType>|null $groupType
     */
    #[Optional(enum: GroupType::class, nullable: true)]
    public ?string $groupType;

    /**
     * Maximum number of items to return per page. Ranges from `1` to `1000`.
     *
     * When omitted, every remaining entry is returned in a single page and `next_page` is `null`.
     */
    #[Optional(nullable: true)]
    public ?int $limit;

    /**
     * Filter to the single entry containing this model. Accepts full model names and aliases. Returns 404 if the model is not found or has no rate limits for this organization.
     */
    #[Optional(nullable: true)]
    public ?string $model;

    /**
     * Opaque cursor from a previous response's `next_page`.
     */
    #[Optional(nullable: true)]
    public ?string $page;

    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param GroupType|value-of<GroupType>|null $groupType
     */
    public static function with(
        GroupType|string|null $groupType = null,
        ?int $limit = null,
        ?string $model = null,
        ?string $page = null,
    ): self {
        $self = new self;

        null !== $groupType && $self['groupType'] = $groupType;
        null !== $limit && $self['limit'] = $limit;
        null !== $model && $self['model'] = $model;
        null !== $page && $self['page'] = $page;

        return $self;
    }

    /**
     * Filter by group type.
     *
     * @param GroupType|value-of<GroupType>|null $groupType
     */
    public function withGroupType(GroupType|string|null $groupType): self
    {
        $self = clone $this;
        $self['groupType'] = $groupType;

        return $self;
    }

    /**
     * Maximum number of items to return per page. Ranges from `1` to `1000`.
     *
     * When omitted, every remaining entry is returned in a single page and `next_page` is `null`.
     */
    public function withLimit(?int $limit): self
    {
        $self = clone $this;
        $self['limit'] = $limit;

        return $self;
    }

    /**
     * Filter to the single entry containing this model. Accepts full model names and aliases. Returns 404 if the model is not found or has no rate limits for this organization.
     */
    public function withModel(?string $model): self
    {
        $self = clone $this;
        $self['model'] = $model;

        return $self;
    }

    /**
     * Opaque cursor from a previous response's `next_page`.
     */
    public function withPage(?string $page): self
    {
        $self = clone $this;
        $self['page'] = $page;

        return $self;
    }
}
