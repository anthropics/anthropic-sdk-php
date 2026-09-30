<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Organization\Analytics;

use Anthropic\Beta\Organization\Analytics\AnalyticsUserActivity;
use Anthropic\Beta\Organization\Analytics\Users\UserListParams;
use Anthropic\Beta\Organization\Analytics\Users\UserListParams\GroupBy;
use Anthropic\Beta\Organization\Analytics\Users\UserListParams\Order;
use Anthropic\Client;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\Organization\Analytics\UsersRawContract;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class UsersRawService implements UsersRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Get per-user activity for a given day, with cursor-based pagination.
     *
     * Returns activity metrics for each user in the organization, sorted by email
     * address. Use `group_by[]` for per-RBAC-group aggregates, or `filter[]` to
     * scope results to specific members, groups, or a chat project. Available
     * to organizations on a Claude Enterprise plan. Requires an API key with
     * the `read:analytics` scope.
     *
     * @param array{
     *   date?: string|null,
     *   endingDate?: string|null,
     *   filter?: list<string>|null,
     *   groupBy?: list<GroupBy|value-of<GroupBy>>|null,
     *   limit?: int|null,
     *   order?: Order|value-of<Order>|null,
     *   orderBy?: string|null,
     *   page?: string|null,
     *   startingDate?: string|null,
     * }|UserListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<AnalyticsUserActivity>>
     *
     * @throws APIException
     */
    public function list(
        array|UserListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = UserListParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'v1/organizations/analytics/users?beta=true',
            query: Util::array_transform_keys(
                $parsed,
                [
                    'endingDate' => 'ending_date',
                    'groupBy' => 'group_by',
                    'orderBy' => 'order_by',
                    'startingDate' => 'starting_date',
                ],
            ),
            options: $options,
            convert: AnalyticsUserActivity::class,
            page: PageCursor::class,
        );
    }
}
