<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Organization\Analytics;

use Anthropic\Beta\Organization\Analytics\AnalyticsConnectorActivity;
use Anthropic\Beta\Organization\Analytics\Connectors\ConnectorListParams;
use Anthropic\Beta\Organization\Analytics\Connectors\ConnectorListParams\GroupBy;
use Anthropic\Beta\Organization\Analytics\Connectors\ConnectorListParams\Order;
use Anthropic\Client;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\Organization\Analytics\ConnectorsRawContract;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class ConnectorsRawService implements ConnectorsRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Get per-connector usage for a given day, with cursor-based pagination.
     *
     * Returns connector usage metrics for the organization, sorted by connector
     * name. Connector names are normalized from their various sources — for
     * example, "Atlassian MCP server" and "mcp-atlassian" both appear as
     * "atlassian". Use `group_by[]` to break usage out per member, per RBAC
     * group, or per product surface, and `filter[]` to scope results; the
     * parameter descriptions list the supported dimensions. Available to
     * organizations on a Claude Enterprise plan. Requires an API key with the
     * `read:analytics` scope.
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
     * }|ConnectorListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<AnalyticsConnectorActivity>>
     *
     * @throws APIException
     */
    public function list(
        array|ConnectorListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = ConnectorListParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'v1/organizations/analytics/connectors?beta=true',
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
            convert: AnalyticsConnectorActivity::class,
            page: PageCursor::class,
        );
    }
}
