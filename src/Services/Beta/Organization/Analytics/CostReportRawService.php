<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Organization\Analytics;

use Anthropic\Beta\Organization\Analytics\AnalyticsClaudeTagCategory;
use Anthropic\Beta\Organization\Analytics\AnalyticsContextWindow;
use Anthropic\Beta\Organization\Analytics\AnalyticsCostReportTimeBucket;
use Anthropic\Beta\Organization\Analytics\AnalyticsInferenceGeoFilter;
use Anthropic\Beta\Organization\Analytics\AnalyticsProductFilter;
use Anthropic\Beta\Organization\Analytics\CostReport\CostReportListParams;
use Anthropic\Beta\Organization\Analytics\CostReport\CostReportListParams\BucketWidth;
use Anthropic\Beta\Organization\Analytics\CostReport\CostReportListParams\GroupBy;
use Anthropic\Beta\Organization\Analytics\CostReport\CostReportListParams\Speed;
use Anthropic\Client;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Util;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\Organization\Analytics\CostReportRawContract;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class CostReportRawService implements CostReportRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Get cost in USD over time across a date range.
     *
     * Returns cost bucketed by minute, hour, or day, optionally broken down by
     * product, model, context window, inference region, speed, cost type, or
     * token type. Available to organizations on a Claude Enterprise plan.
     * Requires an API key with the `read:analytics` scope.
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
     * }|CostReportListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<PageCursor<AnalyticsCostReportTimeBucket>>
     *
     * @throws APIException
     */
    public function list(
        array|CostReportListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = CostReportListParams::parseRequest(
            $params,
            $requestOptions,
        );

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'v1/organizations/analytics/cost_report?beta=true',
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
            options: $options,
            convert: AnalyticsCostReportTimeBucket::class,
            page: PageCursor::class,
        );
    }
}
