<?php

declare(strict_types=1);

namespace Anthropic\Services\Organization\Workspaces;

use Anthropic\Client;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Implementation\ApiCallInfo;
use Anthropic\Core\Util;
use Anthropic\Organization\Workspaces\RateLimits\RateLimitListParams;
use Anthropic\Organization\Workspaces\RateLimits\RateLimitListParams\GroupType;
use Anthropic\Organization\Workspaces\RateLimits\RateLimitUpdateParams;
use Anthropic\Organization\Workspaces\RateLimits\WorkspaceRateLimit;
use Anthropic\Organization\Workspaces\RateLimits\WorkspaceRateLimitUpdateValue;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Organization\Workspaces\RateLimitsRawContract;

/**
 * @phpstan-import-type WorkspaceRateLimitUpdateValueShape from \Anthropic\Organization\Workspaces\RateLimits\WorkspaceRateLimitUpdateValue
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class RateLimitsRawService implements RateLimitsRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

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
     * @param array{
     *   workspaceID: string,
     *   limits: list<WorkspaceRateLimitUpdateValue|WorkspaceRateLimitUpdateValueShape>,
     * }|RateLimitUpdateParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<WorkspaceRateLimit>
     *
     * @throws APIException
     */
    public function update(
        string $rateLimitID,
        array|RateLimitUpdateParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = RateLimitUpdateParams::parseRequest(
            $params,
            $requestOptions,
        );
        $workspaceID = $parsed['workspaceID'];
        unset($parsed['workspaceID']);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'post',
            path: [
                'v1/organizations/workspaces/%1$s/rate_limits/%2$s',
                $workspaceID,
                $rateLimitID,
            ],
            body: (object) array_diff_key($parsed, array_flip(['workspaceID'])),
            options: $options->withApiCall(new ApiCallInfo(
                name: 'anthropic.organization.workspaces.rate_limits.update',
                route: '/v1/organizations/workspaces/{workspace_id}/rate_limits/{rate_limit_id}',
                attributes: [
                    'anthropic.organization.workspace.id' => $workspaceID,
                    'anthropic.organization.workspace.rate_limit.id' => $rateLimitID,
                ],
            )),
            convert: WorkspaceRateLimit::class,
        );
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
     * @param array{
     *   groupType?: GroupType|value-of<GroupType>|null,
     *   includeInherited?: bool,
     *   limit?: int|null,
     *   page?: string|null,
     * }|RateLimitListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<WorkspaceRateLimit>>
     *
     * @throws APIException
     */
    public function list(
        string $workspaceID,
        array|RateLimitListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = RateLimitListParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: ['v1/organizations/workspaces/%1$s/rate_limits', $workspaceID],
            query: Util::array_transform_keys(
                $parsed,
                [
                    'groupType' => 'group_type', 'includeInherited' => 'include_inherited',
                ],
            ),
            options: $options->withApiCall(new ApiCallInfo(
                name: 'anthropic.organization.workspaces.rate_limits.list',
                route: '/v1/organizations/workspaces/{workspace_id}/rate_limits',
                query: ['group_type', 'include_inherited', 'limit', 'page'],
                attributes: ['anthropic.organization.workspace.id' => $workspaceID],
            )),
            convert: WorkspaceRateLimit::class,
            page: PageCursor::class,
        );
    }
}
