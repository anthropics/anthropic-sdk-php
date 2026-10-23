<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Organization\Analytics;

use Anthropic\Beta\Organization\Analytics\AnalyticsClaudeTagCategory;
use Anthropic\Beta\Organization\Analytics\AnalyticsContextWindow;
use Anthropic\Beta\Organization\Analytics\AnalyticsInferenceGeoFilter;
use Anthropic\Beta\Organization\Analytics\AnalyticsProductFilter;
use Anthropic\Beta\Organization\Analytics\AnalyticsUsageReportTimeBucket;
use Anthropic\Beta\Organization\Analytics\UsageReport\UsageReportListParams;
use Anthropic\Beta\Organization\Analytics\UsageReport\UsageReportListParams\BucketWidth;
use Anthropic\Beta\Organization\Analytics\UsageReport\UsageReportListParams\GroupBy;
use Anthropic\Beta\Organization\Analytics\UsageReport\UsageReportListParams\Speed;
use Anthropic\Client;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Implementation\ApiCallInfo;
use Anthropic\Core\Util;
use Anthropic\ReportPageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\Organization\Analytics\UsageReportRawContract;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class UsageReportRawService implements UsageReportRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * [Legacy] Get token usage over time across a date range.
     *
     * Returns token usage bucketed by minute, hour, or day, optionally broken down by one or more `group_by[]` dimensions, such as product or model. Available to organizations on a Claude Enterprise plan. Requires an API key with the `read:analytics` scope.
     *
     * This endpoint is one of the legacy Claude Enterprise usage and cost reports. For new integrations, use [`GET /v1/organizations/analytics/usage`](/docs/en/api/beta/organization/analytics/usage/list) in the Usage and Cost Analytics API instead. To move an existing integration, see [Migrate from the Claude Enterprise usage and cost reports](/docs/en/manage-claude/usage-cost-analytics-api#migrate-from-enterprise-analytics-reports).
     *
     * @param array{
     *   startingAt: \DateTimeInterface,
     *   bucketWidth?: BucketWidth|value-of<BucketWidth>,
     *   claudeTagCategories?: list<AnalyticsClaudeTagCategory|value-of<AnalyticsClaudeTagCategory>>|null,
     *   claudeTagUserIDs?: list<string>|null,
     *   contextWindows?: list<AnalyticsContextWindow|value-of<AnalyticsContextWindow>>|null,
     *   endingAt?: \DateTimeInterface|null,
     *   groupBy?: list<GroupBy|value-of<GroupBy>>|null,
     *   inferenceGeos?: list<AnalyticsInferenceGeoFilter|value-of<AnalyticsInferenceGeoFilter>>|null,
     *   limit?: int|null,
     *   models?: list<string>|null,
     *   page?: string|null,
     *   products?: list<AnalyticsProductFilter|value-of<AnalyticsProductFilter>>|null,
     *   rbacGroupIDs?: list<string>|null,
     *   slackChannelIDs?: list<string>|null,
     *   speeds?: list<Speed|value-of<Speed>>|null,
     *   userIDs?: list<string>|null,
     * }|UsageReportListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ReportPageCursor<AnalyticsUsageReportTimeBucket>>
     *
     * @throws APIException
     */
    public function list(
        array|UsageReportListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = UsageReportListParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'v1/organizations/analytics/usage_report',
            query: Util::array_transform_keys(
                $parsed,
                [
                    'startingAt' => 'starting_at',
                    'bucketWidth' => 'bucket_width',
                    'claudeTagCategories' => 'claude_tag_categories',
                    'claudeTagUserIDs' => 'claude_tag_user_ids',
                    'contextWindows' => 'context_windows',
                    'endingAt' => 'ending_at',
                    'groupBy' => 'group_by',
                    'inferenceGeos' => 'inference_geos',
                    'rbacGroupIDs' => 'rbac_group_ids',
                    'slackChannelIDs' => 'slack_channel_ids',
                    'userIDs' => 'user_ids',
                ],
            ),
            options: $options->withQualifiers([
                'beta' => 'true',
            ])->withApiCall(new ApiCallInfo(
                name: 'anthropic.organization.analytics.usage_report.list',
                route: '/v1/organizations/analytics/usage_report',
                query: [
                    'bucket_width',
                    'claude_tag_categories',
                    'claude_tag_user_ids',
                    'context_windows',
                    'ending_at',
                    'group_by',
                    'inference_geos',
                    'limit',
                    'models',
                    'page',
                    'products',
                    'rbac_group_ids',
                    'slack_channel_ids',
                    'speeds',
                    'starting_at',
                    'user_ids',
                ],
            )),
            convert: AnalyticsUsageReportTimeBucket::class,
            page: ReportPageCursor::class,
        );
    }
}
