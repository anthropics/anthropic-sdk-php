<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Organization\Workspaces;

use Anthropic\Beta\Organization\Workspaces\RateLimits\BetaWorkspaceRateLimit;
use Anthropic\Beta\Organization\Workspaces\RateLimits\RateLimitListParams\GroupType;
use Anthropic\Client;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\Organization\Workspaces\RateLimitsContract;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class RateLimitsService implements RateLimitsContract
{
    /**
     * @api
     */
    public RateLimitsRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new RateLimitsRawService($client);
    }

    /**
     * @api
     *
     * List rate-limit overrides configured for a workspace.
     *
     * Returns only the groups and limiter types that have a workspace-level
     * override. Groups without overrides inherit the organization limits and
     * are not listed; use `GET /v1/organizations/rate_limits` to see those.
     *
     * This endpoint currently returns every matching entry in a single page
     * regardless of `limit`; follow `next_page` so that clients keep working
     * when pagination is enabled.
     *
     * @param string $workspaceID the ID of the workspace
     * @param GroupType|value-of<GroupType>|null $groupType filter by group type
     * @param int|null $limit Maximum number of items to return per page. Ranges from `1` to `1000`.
     *
     * Accepted for request-shape compatibility and currently ignored: every entry is returned in a single page.
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
    ): PageCursor {
        $params = Util::removeNulls(
            ['groupType' => $groupType, 'limit' => $limit, 'page' => $page]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list($workspaceID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
