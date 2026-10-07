<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Organization\Analytics;

use Anthropic\Beta\Organization\Analytics\AnalyticsSingleDayActivitySummary;
use Anthropic\Client;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\Organization\Analytics\SummariesContract;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class SummariesService implements SummariesContract
{
    /**
     * @api
     */
    public SummariesRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new SummariesRawService($client);
    }

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
     * @param string $startingDate UTC date in YYYY-MM-DD format. Start of the date range (inclusive). Data is typically available with a 1-day lag (varies by query; the error for a too-recent date names the latest available day) and may be revised by a few percent over the following days. No earlier than 2026-01-01.
     * @param string|null $endingDate UTC date in YYYY-MM-DD format. End of the date range (exclusive). Data is typically available with a 1-day lag, so this can be at most today — which is also the default when omitted, making the last entry cover the most recent available day. Data may be revised by a few percent over the following days. The range may span at most 366 days.
     * @param list<string>|null $filter Filters as `dimension:value`. Only `rbac_group_id` is supported (e.g. `filter[]=rbac_group_id:{id}`); repeat the param to OR across groups. Scopes the whole day series to members of the matching group(s), re-aggregated from member-level activity — org-wide seat/invite fields and the adoption rates derived from them are null on scoped rows. `rbac_group_id` accepts the tagged id (`rbac_group_...`, as emitted in responses and by the spend-limits API) or a bare group UUID, and matches users who held the group at any point during each UTC day (time-of-usage attribution). At most 100 entries.
     * @param int|null $limit Number of results per page (1-1000, default 100). The day series (at most 366 entries) is currently returned in full in a single page, so `limit` does not yet shorten it.
     * @param string|null $page Opaque cursor from a previous response's `next_page` field. `next_page` is currently always null, so there is never a cursor to send.
     * @param RequestOpts|null $requestOptions
     *
     * @return PageCursor<AnalyticsSingleDayActivitySummary>
     *
     * @throws APIException
     */
    public function list(
        string $startingDate,
        ?string $endingDate = null,
        ?array $filter = null,
        ?int $limit = null,
        ?string $page = null,
        RequestOptions|array|null $requestOptions = null,
    ): PageCursor {
        $params = Util::removeNulls(
            [
                'startingDate' => $startingDate,
                'endingDate' => $endingDate,
                'filter' => $filter,
                'limit' => $limit,
                'page' => $page,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
