<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Organization;

use Anthropic\Beta\Organization\RateLimits\OrganizationRateLimit;
use Anthropic\Beta\Organization\RateLimits\RateLimitListParams\GroupType;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface RateLimitsContract
{
    /**
     * @api
     *
     * @param GroupType|value-of<GroupType>|null $groupType filter by group type
     * @param int|null $limit Maximum number of items to return per page. Ranges from `1` to `1000`.
     *
     * When omitted, every remaining entry is returned in a single page and `next_page` is `null`.
     * @param string|null $model Filter to the single entry containing this model. Accepts full model names and aliases. Returns 404 if the model is not found or has no rate limits for this organization.
     * @param string|null $page opaque cursor from a previous response's `next_page`
     * @param RequestOpts|null $requestOptions
     *
     * @return PageCursor<OrganizationRateLimit>
     *
     * @throws APIException
     */
    public function list(
        GroupType|string|null $groupType = null,
        ?int $limit = null,
        ?string $model = null,
        ?string $page = null,
        RequestOptions|array|null $requestOptions = null,
    ): PageCursor;
}
