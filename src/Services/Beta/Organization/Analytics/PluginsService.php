<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Organization\Analytics;

use Anthropic\Beta\Organization\Analytics\AnalyticsPluginActivity;
use Anthropic\Beta\Organization\Analytics\Plugins\PluginListParams\GroupBy;
use Anthropic\Beta\Organization\Analytics\Plugins\PluginListParams\Order;
use Anthropic\Client;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\Organization\Analytics\PluginsContract;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class PluginsService implements PluginsContract
{
    /**
     * @api
     */
    public PluginsRawService $raw;

    /**
     * @internal
     */
    public function __construct(private Client $client)
    {
        $this->raw = new PluginsRawService($client);
    }

    /**
     * @api
     *
     * Get per-plugin install + invocation usage for a given day, with pagination.
     *
     * Returns plugin usage metrics for the organization across Cowork and Claude
     * Code, sorted by plugin name. The `plugin_name` value `third-party` is
     * an aggregate bucket, not a plugin: it collects plugin activity, from
     * either surface, for which the reporting client did not provide a plugin
     * name — so an organization's own plugins can contribute both to their own
     * named rows and to this bucket. Use `group_by[]` to break usage out per
     * member, per RBAC group, or per product surface (Cowork / Claude Code),
     * and `filter[]` to scope results; the parameter descriptions list the
     * supported dimensions. Requires an API key with the
     * `read:analytics` scope. `starting_date` / `ending_date` select
     * range-rollup mode like `/skills`.
     *
     * @param string|null $date UTC date in YYYY-MM-DD format. The day to get plugin usage for. Data is typically available with a 1-day lag (varies by query; the error for a too-recent date names the latest available day) and may be revised by a few percent over the following days. No earlier than 2026-01-01.
     * @param string|null $endingDate UTC date in YYYY-MM-DD format. End of the date range (exclusive); only valid with `starting_date`. Data is typically available with a 1-day lag (varies by query; the error for a too-recent date names the latest available day), so this can be at most today — which is also the default when omitted, resolved once when the first page is served and reused for the rest of the pagination sequence. At most 366 days after `starting_date`.
     * @param list<string>|null $filter Filters as `dimension:value`, e.g. `filter[]=rbac_group_id:{id}`. Repeat the param for OR within a dimension and across dimensions for AND. Supported dimensions on this endpoint: `plugin_name`, `product`, `rbac_group_id`, `user_id`. Value forms: `plugin_name` matches case-insensitively; `product` is `claude_code` or `cowork` (the only surfaces with plugin attribution); `rbac_group_id` takes the tagged id (`rbac_group_...`, as emitted in responses and by the spend-limits API) or a bare group UUID, and matches users who held the group at any point during each covered UTC day (time-of-usage attribution); `user_id` takes a tagged user id (`user_...`), as emitted in responses. An unsupported dimension returns 400. At most 100 entries.
     * @param list<GroupBy|value-of<GroupBy>>|null $groupBy Dimensions to break results out by (e.g. `group_by[]=user_id`). Supported on this endpoint: `product`, `rbac_group_id`, `user_id`. On this endpoint `product` takes the values `claude_code` or `cowork` only (the surfaces with plugin attribution). Grouped rows carry the requested dimension values as additional fields and paginate like ungrouped responses via `next_page`; an unsupported dimension returns 400. `rbac_group_id` attributes a user to every group they held at any point during each covered UTC day, so grouped rows are not an exclusive partition and can sum above org-level totals. At most 100 entries.
     * @param int|null $limit number of results per page (1-1000, default 100)
     * @param Order|value-of<Order>|null $order Sort direction: `asc` or `desc`. Defaults to `asc` for the endpoint's sort column and to `desc` when `order_by` names a metric (a top-N ranking). Applies to `order_by`, or to the endpoint's default sort field when `order_by` is omitted.
     * @param string|null $orderBy Sort field. Restricted to the endpoint's sort column plus its rankable metrics (metrics default to descending; a few metrics rank in date-range mode only, per the endpoint's documented orderable set).
     * @param string|null $page opaque cursor from a previous response's `next_page` field
     * @param string|null $startingDate UTC date in YYYY-MM-DD format. Start of a date range (inclusive). Enables rollup mode: one row per entity aggregated over the whole range — addable counters are summed across days, and a distinct count is never summed where summing could double-count (a field's range value is recomputed exactly over the window, approximate via HLL with typical error under 2%, null, or — for the creation-event counts, whose per-day values cannot overlap — a per-day sum that is itself exact; each field's own description says which). Use either `date` or `starting_date`, not both. Data is typically available with a 1-day lag (varies by query; the error for a too-recent date names the latest available day) and may be revised by a few percent over the following days. No earlier than 2026-01-01.
     * @param RequestOpts|null $requestOptions
     *
     * @return PageCursor<AnalyticsPluginActivity>
     *
     * @throws APIException
     */
    public function list(
        ?string $date = null,
        ?string $endingDate = null,
        ?array $filter = null,
        ?array $groupBy = null,
        ?int $limit = null,
        Order|string|null $order = null,
        ?string $orderBy = null,
        ?string $page = null,
        ?string $startingDate = null,
        RequestOptions|array|null $requestOptions = null,
    ): PageCursor {
        $params = Util::removeNulls(
            [
                'date' => $date,
                'endingDate' => $endingDate,
                'filter' => $filter,
                'groupBy' => $groupBy,
                'limit' => $limit,
                'order' => $order,
                'orderBy' => $orderBy,
                'page' => $page,
                'startingDate' => $startingDate,
            ],
        );

        // @phpstan-ignore-next-line argument.type
        $response = $this->raw->list(params: $params, requestOptions: $requestOptions);

        return $response->parse();
    }
}
