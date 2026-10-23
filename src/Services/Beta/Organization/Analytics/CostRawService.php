<?php

declare(strict_types=1);

namespace Anthropic\Services\Beta\Organization\Analytics;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Organization\Analytics\AnalyticsActorType;
use Anthropic\Beta\Organization\Analytics\AnalyticsClaudeTagCategory;
use Anthropic\Beta\Organization\Analytics\AnalyticsContextWindow;
use Anthropic\Beta\Organization\Analytics\AnalyticsInferenceGeoFilter;
use Anthropic\Beta\Organization\Analytics\AnalyticsServiceTier;
use Anthropic\Beta\Organization\Analytics\AnalyticsSpeed;
use Anthropic\Beta\Organization\Analytics\AnalyticsTimeBucketWidth;
use Anthropic\Beta\Organization\Analytics\AnalyticsUsageCostProductFilter;
use Anthropic\Beta\Organization\Analytics\AnalyticsUsageCostSortOrder;
use Anthropic\Beta\Organization\Analytics\Cost\BetaAnalyticsCostGroupBy;
use Anthropic\Beta\Organization\Analytics\Cost\BetaAnalyticsCostItem;
use Anthropic\Beta\Organization\Analytics\Cost\BetaAnalyticsCostOrderBy;
use Anthropic\Beta\Organization\Analytics\Cost\CostListParams;
use Anthropic\Client;
use Anthropic\Core\Contracts\BaseResponse;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\Core\Implementation\ApiCallInfo;
use Anthropic\Core\Util;
use Anthropic\ReportPageCursor;
use Anthropic\RequestOptions;
use Anthropic\ServiceContracts\Beta\Organization\Analytics\CostRawContract;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
final class CostRawService implements CostRawContract
{
    // @phpstan-ignore-next-line
    /**
     * @internal
     */
    public function __construct(private Client $client) {}

    /**
     * @api
     *
     * Get cost in USD across a date range, broken out by dimension.
     *
     * Returns one row per combination of the requested `group_by[]`
     * dimensions (and time bucket, when `time_bucket_width` is set) that has
     * cost in the range, ranked by spend or ordered by time bucket; every
     * combination is returned across pages. With no `group_by[]` and no
     * `time_bucket_width`, a single row aggregates the whole range. Includes
     * all cost, whether or not it is attributable to a seat user. Requires an
     * API key with the `read:analytics` scope, or an Admin API key.
     *
     * @param array{
     *   startingAt: \DateTimeInterface,
     *   actorIDs?: list<string>|null,
     *   actorTypes?: list<AnalyticsActorType|value-of<AnalyticsActorType>>|null,
     *   agentIDs?: list<string>|null,
     *   apiKeyIDs?: list<string>|null,
     *   claudeTagCategories?: list<AnalyticsClaudeTagCategory|value-of<AnalyticsClaudeTagCategory>>|null,
     *   claudeTagUserIDs?: list<string>|null,
     *   contextWindows?: list<AnalyticsContextWindow|value-of<AnalyticsContextWindow>>|null,
     *   deploymentIDs?: list<string>|null,
     *   endingAt?: \DateTimeInterface|null,
     *   environmentIDs?: list<string>|null,
     *   excludeDeletedUsers?: bool,
     *   groupBy?: list<BetaAnalyticsCostGroupBy|value-of<BetaAnalyticsCostGroupBy>>|null,
     *   inferenceGeos?: list<AnalyticsInferenceGeoFilter|value-of<AnalyticsInferenceGeoFilter>>|null,
     *   limit?: int,
     *   models?: list<string>|null,
     *   order?: AnalyticsUsageCostSortOrder|value-of<AnalyticsUsageCostSortOrder>,
     *   orderBy?: BetaAnalyticsCostOrderBy|value-of<BetaAnalyticsCostOrderBy>,
     *   page?: string|null,
     *   products?: list<AnalyticsUsageCostProductFilter|value-of<AnalyticsUsageCostProductFilter>>|null,
     *   rbacGroupIDs?: list<string>|null,
     *   serviceTiers?: list<AnalyticsServiceTier|value-of<AnalyticsServiceTier>>|null,
     *   sessionIDs?: list<string>|null,
     *   slackChannelIDs?: list<string>|null,
     *   speeds?: list<AnalyticsSpeed|value-of<AnalyticsSpeed>>|null,
     *   timeBucketWidth?: AnalyticsTimeBucketWidth|value-of<AnalyticsTimeBucketWidth>|null,
     *   userProfileIDs?: list<string>|null,
     *   workspaceIDs?: list<string>|null,
     *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>,
     * }|CostListParams $params
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseResponse<ReportPageCursor<BetaAnalyticsCostItem>>
     *
     * @throws APIException
     */
    public function list(
        array|CostListParams $params,
        RequestOptions|array|null $requestOptions = null,
    ): BaseResponse {
        [$parsed, $options] = CostListParams::parseRequest(
            $params,
            $requestOptions,
        );
        $query_params = array_flip(
            [
                'startingAt',
                'actorIDs',
                'actorTypes',
                'agentIDs',
                'apiKeyIDs',
                'claudeTagCategories',
                'claudeTagUserIDs',
                'contextWindows',
                'deploymentIDs',
                'endingAt',
                'environmentIDs',
                'excludeDeletedUsers',
                'groupBy',
                'inferenceGeos',
                'limit',
                'models',
                'order',
                'orderBy',
                'page',
                'products',
                'rbacGroupIDs',
                'serviceTiers',
                'sessionIDs',
                'slackChannelIDs',
                'speeds',
                'timeBucketWidth',
                'userProfileIDs',
                'workspaceIDs',
            ],
        );

        /** @var array<string,string> */
        $header_params = array_diff_key($parsed, $query_params);

        // @phpstan-ignore-next-line return.type
        return $this->client->request(
            method: 'get',
            path: 'v1/organizations/analytics/cost',
            query: Util::array_transform_keys(
                array_intersect_key($parsed, $query_params),
                [
                    'startingAt' => 'starting_at',
                    'actorIDs' => 'actor_ids',
                    'actorTypes' => 'actor_types',
                    'agentIDs' => 'agent_ids',
                    'apiKeyIDs' => 'api_key_ids',
                    'claudeTagCategories' => 'claude_tag_categories',
                    'claudeTagUserIDs' => 'claude_tag_user_ids',
                    'contextWindows' => 'context_windows',
                    'deploymentIDs' => 'deployment_ids',
                    'endingAt' => 'ending_at',
                    'environmentIDs' => 'environment_ids',
                    'excludeDeletedUsers' => 'exclude_deleted_users',
                    'groupBy' => 'group_by',
                    'inferenceGeos' => 'inference_geos',
                    'orderBy' => 'order_by',
                    'rbacGroupIDs' => 'rbac_group_ids',
                    'serviceTiers' => 'service_tiers',
                    'sessionIDs' => 'session_ids',
                    'slackChannelIDs' => 'slack_channel_ids',
                    'timeBucketWidth' => 'time_bucket_width',
                    'userProfileIDs' => 'user_profile_ids',
                    'workspaceIDs' => 'workspace_ids',
                ],
            ),
            headers: Util::array_transform_keys(
                $header_params,
                ['betas' => 'anthropic-beta']
            ),
            options: RequestOptions::parse(
                [
                    'extraHeaders' => [
                        'anthropic-beta' => 'analytics-usage-cost-2026-08-24',
                    ],
                ],
                $options,
            )->withQualifiers(['beta' => 'true'])->withApiCall(new ApiCallInfo(
                name: 'anthropic.organization.analytics.cost.list',
                route: '/v1/organizations/analytics/cost',
                query: [
                    'actor_ids',
                    'actor_types',
                    'agent_ids',
                    'api_key_ids',
                    'claude_tag_categories',
                    'claude_tag_user_ids',
                    'context_windows',
                    'deployment_ids',
                    'ending_at',
                    'environment_ids',
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
                    'service_tiers',
                    'session_ids',
                    'slack_channel_ids',
                    'speeds',
                    'starting_at',
                    'time_bucket_width',
                    'user_profile_ids',
                    'workspace_ids',
                ],
            )),
            convert: BetaAnalyticsCostItem::class,
            page: ReportPageCursor::class,
        );
    }
}
