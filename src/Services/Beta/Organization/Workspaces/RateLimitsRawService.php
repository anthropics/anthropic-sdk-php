<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Organization\Workspaces;

use Anthropic\Beta\Organization\Workspaces\RateLimits\BetaWorkspaceRateLimit;
use Anthropic\Beta\Organization\Workspaces\RateLimits\RateLimitListParams;
use Anthropic\Beta\Organization\Workspaces\RateLimits\RateLimitListParams\GroupType;
use Anthropic\Client;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\Organization\Workspaces\RateLimitsRawContract;

/**
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
     * @return BaseResponse<PageCursor<BetaWorkspaceRateLimit>>
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
            path: [
                'v1/organizations/workspaces/%1$s/rate_limits?beta=true', $workspaceID,
            ],
            query: Util::array_transform_keys(
                $parsed,
                [
                    'groupType' => 'group_type', 'includeInherited' => 'include_inherited',
                ],
            ),
            options: $options,
            convert: BetaWorkspaceRateLimit::class,
            page: PageCursor::class,
        );
    }
}
