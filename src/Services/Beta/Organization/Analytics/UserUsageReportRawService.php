<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Organization\Analytics;

use Anthropic\Beta\Organization\Analytics\AnalyticsClaudeTagCategory;
use Anthropic\Beta\Organization\Analytics\AnalyticsContextWindow;
use Anthropic\Beta\Organization\Analytics\AnalyticsInferenceGeoFilter;
use Anthropic\Beta\Organization\Analytics\AnalyticsProductFilter;
use Anthropic\Beta\Organization\Analytics\AnalyticsUsageUsersItem;
use Anthropic\Beta\Organization\Analytics\UserUsageReport\UserUsageReportListParams;
use Anthropic\Beta\Organization\Analytics\UserUsageReport\UserUsageReportListParams\BucketWidth;
use Anthropic\Beta\Organization\Analytics\UserUsageReport\UserUsageReportListParams\GroupBy;
use Anthropic\Beta\Organization\Analytics\UserUsageReport\UserUsageReportListParams\Order;
use Anthropic\Beta\Organization\Analytics\UserUsageReport\UserUsageReportListParams\OrderBy;
use Anthropic\Beta\Organization\Analytics\UserUsageReport\UserUsageReportListParams\Speed;
use Anthropic\Client;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\Organization\Analytics\UserUsageReportRawContract;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class UserUsageReportRawService implements UserUsageReportRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Get per-user token usage across a date range.
     *
     * Returns one row per user, ranked by the chosen token metric. Use this to
     * see which users consume the most tokens. Only usage attributable to a
     * seat user is included; for organization-wide totals including direct
     * API-key and automation traffic, use the bucketed
     * `/v1/organizations/analytics/usage_report` endpoint. Available to
     * organizations on a Claude Enterprise plan. Requires an API key with the
     * `read:analytics` scope.
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
     * }|UserUsageReportListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<AnalyticsUsageUsersItem>>
     *
     * @throws APIException
     */
    public function list(
        array|UserUsageReportListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = UserUsageReportListParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'v1/organizations/analytics/user_usage_report?beta=true',
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
            options: $options,
            convert: AnalyticsUsageUsersItem::class,
            page: PageCursor::class,
        );
    }
}
