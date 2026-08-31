<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Workspaces\RateLimits;

use Anthropic\Beta\Organization\Workspaces\RateLimits\RateLimitListParams\GroupType;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * List rate-limit overrides configured for a workspace.
 *
 * Returns only the groups and limiter types that have a workspace-level
 * override. Groups without overrides inherit the organization limits and
 * are not listed; use `GET /v1/organizations/rate_limits` to see those.
 *
 * When `limit` is omitted, every matching entry is returned in a single
 * page; when `limit` truncates the result, follow `next_page` to fetch
 * the remaining entries.
 *
 * @see Anthropic\Services\Beta\Organization\Workspaces\RateLimitsService::list()
 *
 * @phpstan-type RateLimitListParamsShape = array{
 *   groupType?: null|GroupType|value-of<GroupType>,
 *   limit?: int|null,
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
        ?string $page = null,
    ): self {
        $self = new self;

        null !== $groupType && $self['groupType'] = $groupType;
        null !== $limit && $self['limit'] = $limit;
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
     * Opaque cursor from a previous response's `next_page`.
     */
    public function withPage(?string $page): self
    {
        $self = clone $this;
        $self['page'] = $page;

        return $self;
    }
}
