<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Organization\Analytics;

use Anthropic\Beta\Organization\Analytics\AnalyticsClaudeTagCategory;
use Anthropic\Beta\Organization\Analytics\AnalyticsContextWindow;
use Anthropic\Beta\Organization\Analytics\AnalyticsCostUsersItem;
use Anthropic\Beta\Organization\Analytics\AnalyticsInferenceGeoFilter;
use Anthropic\Beta\Organization\Analytics\AnalyticsProductFilter;
use Anthropic\Beta\Organization\Analytics\UserCostReport\UserCostReportListParams;
use Anthropic\Beta\Organization\Analytics\UserCostReport\UserCostReportListParams\BucketWidth;
use Anthropic\Beta\Organization\Analytics\UserCostReport\UserCostReportListParams\GroupBy;
use Anthropic\Beta\Organization\Analytics\UserCostReport\UserCostReportListParams\Order;
use Anthropic\Beta\Organization\Analytics\UserCostReport\UserCostReportListParams\OrderBy;
use Anthropic\Beta\Organization\Analytics\UserCostReport\UserCostReportListParams\Speed;
use Anthropic\Client;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Implementation\ApiCallInfo;
use Anthropic\Core\Util;
use Anthropic\ReportPageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\Organization\Analytics\UserCostReportRawContract;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class UserCostReportRawService implements UserCostReportRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * [Legacy] Get per-user cost in USD across a date range.
     *
     * Returns cost per user, ranked by spend; `group_by[]` or `bucket_width` splits a user across several rows. Use this to see which users account for the most cost. Only cost attributed to a user account is included; cost with no user attributed to it, such as Code Review usage and Claude Tag usage in Slack channels, is left out. Available to organizations on a Claude Enterprise plan. Requires an API key with the `read:analytics` scope.
     *
     * This endpoint is one of the legacy Claude Enterprise usage and cost reports. For new integrations, use [`GET /v1/organizations/analytics/cost`](/docs/en/api/beta/organization/analytics/cost/list) in the Usage and Cost Analytics API instead. To move an existing integration, see [Migrate from the Claude Enterprise usage and cost reports](/docs/en/manage-claude/usage-cost-analytics-api#migrate-from-enterprise-analytics-reports).
     *
     * @param array{
     *   startingAt: \DateTimeInterface,
     *   bucketWidth?: BucketWidth|value-of<BucketWidth>|null,
     *   claudeTagCategories?: list<AnalyticsClaudeTagCategory|value-of<AnalyticsClaudeTagCategory>>|null,
     *   claudeTagUserIDs?: list<string>|null,
     *   contextWindows?: list<AnalyticsContextWindow|value-of<AnalyticsContextWindow>>|null,
     *   endingAt?: \DateTimeInterface|null,
     *   excludeDeletedUsers?: bool,
     *   groupBy?: list<GroupBy|value-of<GroupBy>>|null,
     *   inferenceGeos?: list<AnalyticsInferenceGeoFilter|value-of<AnalyticsInferenceGeoFilter>>|null,
     *   limit?: int,
     *   models?: list<string>|null,
     *   order?: Order|value-of<Order>,
     *   orderBy?: OrderBy|value-of<OrderBy>,
     *   page?: string|null,
     *   products?: list<AnalyticsProductFilter|value-of<AnalyticsProductFilter>>|null,
     *   rbacGroupIDs?: list<string>|null,
     *   slackChannelIDs?: list<string>|null,
     *   speeds?: list<Speed|value-of<Speed>>|null,
     *   userIDs?: list<string>|null,
     * }|UserCostReportListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ReportPageCursor<AnalyticsCostUsersItem>>
     *
     * @throws APIException
     */
    public function list(
        array|UserCostReportListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = UserCostReportListParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'v1/organizations/analytics/user_cost_report',
            query: Util::array_transform_keys(
                $parsed,
                [
                    'startingAt' => 'starting_at',
                    'bucketWidth' => 'bucket_width',
                    'claudeTagCategories' => 'claude_tag_categories',
                    'claudeTagUserIDs' => 'claude_tag_user_ids',
                    'contextWindows' => 'context_windows',
                    'endingAt' => 'ending_at',
                    'excludeDeletedUsers' => 'exclude_deleted_users',
                    'groupBy' => 'group_by',
                    'inferenceGeos' => 'inference_geos',
                    'orderBy' => 'order_by',
                    'rbacGroupIDs' => 'rbac_group_ids',
                    'slackChannelIDs' => 'slack_channel_ids',
                    'userIDs' => 'user_ids',
                ],
            ),
            options: $options->withQualifiers([
                'beta' => 'true',
            ])->withApiCall(new ApiCallInfo(
                name: 'anthropic.organization.analytics.user_cost_report.list',
                route: '/v1/organizations/analytics/user_cost_report',
                query: [
                    'bucket_width',
                    'claude_tag_categories',
                    'claude_tag_user_ids',
                    'context_windows',
                    'ending_at',
                    'exclude_deleted_users',
                    'group_by',
                    'inference_geos',
                    'limit',
                    'models',
                    'order',
                    'order_by',
                    'page',
                    'products',
                    'rbac_group_ids',
                    'slack_channel_ids',
                    'speeds',
                    'starting_at',
                    'user_ids',
                ],
            )),
            convert: AnalyticsCostUsersItem::class,
            page: ReportPageCursor::class,
        );
    }
}
