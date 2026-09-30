<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Organization\Analytics;

use Anthropic\Beta\Organization\Analytics\AnalyticsPluginActivity;
use Anthropic\Beta\Organization\Analytics\Plugins\PluginListParams;
use Anthropic\Beta\Organization\Analytics\Plugins\PluginListParams\GroupBy;
use Anthropic\Beta\Organization\Analytics\Plugins\PluginListParams\Order;
use Anthropic\Client;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\Organization\Analytics\PluginsRawContract;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class PluginsRawService implements PluginsRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

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
     * }|PluginListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<AnalyticsPluginActivity>>
     *
     * @throws APIException
     */
    public function list(
        array|PluginListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = PluginListParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'v1/organizations/analytics/plugins?beta=true',
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
            convert: AnalyticsPluginActivity::class,
            page: PageCursor::class,
        );
    }
}
