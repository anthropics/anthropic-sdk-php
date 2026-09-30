<?php

declare(strict_types=1);

namespace Anthropic\Services\Organization\Workspaces;

use Anthropic\Client;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Util;
use Anthropic\Organization\Workspaces\RateLimits\RateLimitListParams\GroupType;
use Anthropic\Organization\Workspaces\RateLimits\WorkspaceRateLimit;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Organization\Workspaces\RateLimitsContract;

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
     * List a workspace's rate limits.
     *
     * By default, returns only the groups and limiter types that have a
     * workspace-level override. With `include_inherited=true`, returns every
     * group with organization-level limits the workspace can see, listing for
     * each the values it inherits from the organization as well as its own
     * overrides. Each value's `source` says which it is.
     *
     * When `limit` is omitted, every matching entry is returned in a single
     * page; when `limit` truncates the result, follow `next_page` to fetch
     * the remaining entries.
     *
     * @param string $workspaceID the ID of the workspace
     * @param GroupType|value-of<GroupType>|null $groupType filter by group type
     * @param bool $includeInherited also list the limiter values the workspace inherits from the organization, including groups with no workspace-level override
     * @param int|null $limit Maximum number of items to return per page. Ranges from `1` to `1000`.
     *
     * When omitted, every remaining entry is returned in a single page and `next_page` is `null`.
     * @param string|null $page opaque cursor from a previous response's `next_page`
     * @param RequestOpts|null $requestOptions
     *
     * @return PageCursor<WorkspaceRateLimit>
     *
     * @throws APIException
     */
    public function list(
        string $workspaceID,
        GroupType|string|null $groupType = null,
        ?bool $includeInherited = null,
        ?int $limit = null,
        ?string $page = null,
        RequestOptions|array|null $requestOptions = null,
    ): PageCursor {
        $params = Util::removeNulls(
            [
                'groupType' => $groupType,
                'includeInherited' => $includeInherited,
                'limit' => $limit,
                'page' => $page,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list($workspaceID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
