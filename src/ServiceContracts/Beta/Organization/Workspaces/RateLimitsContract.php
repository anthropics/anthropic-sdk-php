<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Organization\Workspaces;

use Anthropic\Beta\Organization\Workspaces\RateLimits\BetaWorkspaceRateLimit;
use Anthropic\Beta\Organization\Workspaces\RateLimits\RateLimitListParams\GroupType;
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
     * @param string $workspaceID the ID of the workspace
     * @param GroupType|value-of<GroupType>|null $groupType filter by group type
     * @param int|null $limit Maximum number of items to return per page. Ranges from `1` to `1000`.
     *
     * When omitted, every remaining entry is returned in a single page and `next_page` is `null`.
     * @param string|null $page opaque cursor from a previous response's `next_page`
     * @param RequestOpts|null $requestOptions
     *
     * @return PageCursor<BetaWorkspaceRateLimit>
     *
     * @throws APIException
     */
    public function list(
        string $workspaceID,
        GroupType|string|null $groupType = null,
        ?int $limit = null,
        ?string $page = null,
        RequestOptions|array|null $requestOptions = null,
    ): PageCursor;
}
