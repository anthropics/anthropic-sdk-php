<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Organization\Workspaces;

use Anthropic\Beta\Organization\Workspaces\RateLimits\BetaWorkspaceRateLimit;
use Anthropic\Beta\Organization\Workspaces\RateLimits\BetaWorkspaceRateLimitUpdateValue;
use Anthropic\Beta\Organization\Workspaces\RateLimits\RateLimitListParams\GroupType;
use Anthropic\Client;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\Organization\Workspaces\RateLimitsContract;

/**
 * @phpstan-import-type BetaWorkspaceRateLimitUpdateValueShape from \Anthropic\Beta\Organization\Workspaces\RateLimits\BetaWorkspaceRateLimitUpdateValue
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
     * Set or clear rate-limit overrides for one rate-limit group in a workspace.
     *
     * Only the limiter types named in `limits` change: an integer `value` sets
     * that type's override and `null` clears it. Types not named keep their
     * current value. A value above the organization's own limit is stored, but
     * the organization limit still applies, so the lower of the two is
     * enforced.
     *
     * Returns the targeted group's entry with this request applied, in the shape
     * `GET /v1/organizations/workspaces/{workspace_id}/rate_limits` returns.
     * Changes take effect within about an hour.
     *
     * @param string $rateLimitID path param: The `id` of the organization's rate-limit entry to set overrides for
     * @param string $workspaceID path param: The ID of the workspace
     * @param list<BetaWorkspaceRateLimitUpdateValue|BetaWorkspaceRateLimitUpdateValueShape> $limits Body param: Limits to set or clear. Unspecified limit types are unchanged.
     * @param RequestOpts|null $requestOptions
     *
     * @throws APIException
     */
    public function update(
        string $rateLimitID,
        string $workspaceID,
        array $limits,
        RequestOptions|array|null $requestOptions = null,
    ): BetaWorkspaceRateLimit {
        $params = Util::removeNulls(
            ['workspaceID' => $workspaceID, 'limits' => $limits]
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->update($rateLimitID, params: $params, requestOptions: $requestOptions);

        return $response->parse();
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
     * @return PageCursor<BetaWorkspaceRateLimit>
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
