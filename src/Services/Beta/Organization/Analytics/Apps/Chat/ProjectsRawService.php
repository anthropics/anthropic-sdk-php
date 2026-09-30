<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Organization\Analytics\Apps\Chat;

use Anthropic\Beta\Organization\Analytics\AnalyticsProjectActivity;
use Anthropic\Beta\Organization\Analytics\Apps\Chat\Projects\ProjectListParams;
use Anthropic\Beta\Organization\Analytics\Apps\Chat\Projects\ProjectListParams\GroupBy;
use Anthropic\Beta\Organization\Analytics\Apps\Chat\Projects\ProjectListParams\Order;
use Anthropic\Client;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\Organization\Analytics\Apps\Chat\ProjectsRawContract;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class ProjectsRawService implements ProjectsRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Get per-project activity for a given day, with cursor-based pagination.
     *
     * Returns activity metrics for each project in the organization, sorted by
     * project ID. Use `group_by[]` to break projects out per member or per RBAC
     * group, and `filter[]` to scope results; the parameter descriptions list the
     * supported dimensions. Available to organizations on a Claude Enterprise
     * plan. Requires an API key with the `read:analytics` scope.
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
     * }|ProjectListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<AnalyticsProjectActivity>>
     *
     * @throws APIException
     */
    public function list(
        array|ProjectListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = ProjectListParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'v1/organizations/analytics/apps/chat/projects?beta=true',
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
            convert: AnalyticsProjectActivity::class,
            page: PageCursor::class,
        );
    }
}
