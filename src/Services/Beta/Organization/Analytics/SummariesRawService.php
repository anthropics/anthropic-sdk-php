<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Organization\Analytics;

use Anthropic\Beta\Organization\Analytics\AnalyticsSingleDayActivitySummary;
use Anthropic\Beta\Organization\Analytics\Summaries\SummaryListParams;
use Anthropic\Client;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\Organization\Analytics\SummariesRawContract;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class SummariesRawService implements SummariesRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Get organization-wide activity summaries for a date range.
     *
     * Returns one entry per day from `starting_date` (inclusive) to `ending_date`
     * (exclusive) in `data`, the same `data` / `next_page` envelope as the other
     * analytics list endpoints; the series is currently returned in full, so
     * `next_page` is always null.
     * Data is typically available with a 1-day lag and may be revised by a few
     * percent over the following days: when `ending_date` is omitted it
     * defaults to the most recent available day + 1, so the last entry covers
     * the most recent available day. The series can be scoped to an RBAC group
     * via `filter[]=rbac_group_id:{id}`. Available to organizations on a Claude
     * Enterprise plan. Requires an API key with the `read:analytics` scope.
     *
     * @param array{
     *   startingDate: string,
     *   endingDate?: string|null,
     *   filter?: list<string>|null,
     *   limit?: int|null,
     *   page?: string|null,
     * }|SummaryListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<AnalyticsSingleDayActivitySummary>>
     *
     * @throws APIException
     */
    public function list(
        array|SummaryListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = SummaryListParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'v1/organizations/analytics/summaries?beta=true',
            query: Util::array_transform_keys(
                $parsed,
                ['startingDate' => 'starting_date', 'endingDate' => 'ending_date'],
            ),
            options: $options,
            convert: AnalyticsSingleDayActivitySummary::class,
            page: PageCursor::class,
        );
    }
}
