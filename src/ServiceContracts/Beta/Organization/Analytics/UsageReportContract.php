<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Organization\Analytics;

use Anthropic\Beta\Organization\Analytics\AnalyticsClaudeTagCategory;
use Anthropic\Beta\Organization\Analytics\AnalyticsContextWindow;
use Anthropic\Beta\Organization\Analytics\AnalyticsInferenceGeoFilter;
use Anthropic\Beta\Organization\Analytics\AnalyticsProductFilter;
use Anthropic\Beta\Organization\Analytics\AnalyticsUsageReportTimeBucket;
use Anthropic\Beta\Organization\Analytics\UsageReport\UsageReportListParams\BucketWidth;
use Anthropic\Beta\Organization\Analytics\UsageReport\UsageReportListParams\GroupBy;
use Anthropic\Beta\Organization\Analytics\UsageReport\UsageReportListParams\Speed;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface UsageReportContract
{
    /**
     * @api
     *
     * @param \DateTimeInterface $startingAt Start of range, inclusive. RFC 3339 tz-aware. Must be within the last 365 days and no earlier than 2026-01-01T00:00:00Z.
     * @param BucketWidth|value-of<BucketWidth> $bucketWidth time bucket granularity
     * @param list<AnalyticsClaudeTagCategory|value-of<AnalyticsClaudeTagCategory>>|null $claudeTagCategories Filter to Claude Tag (Claude in Slack) usage in specific spend categories. Usage with no category never matches. `dm` usage is reported under the user's product rather than `claude-tag`, so combining this filter with `products[]=claude-tag` excludes it. Use `group_by[]=claude_tag_category` to break out per-category values.
     * @param list<string>|null $claudeTagUserIDs Filter to Claude Tag (Claude in Slack) usage attributed to specific Slack users, by Slack user ID (for example `U0123ABCDEF`), not claude.ai user ID. Usage that is not Claude Tag, and Claude Tag usage not attributed to a single user, never matches. Use `group_by[]=claude_tag_user_id` to break out per-user values.
     * @param list<AnalyticsContextWindow|value-of<AnalyticsContextWindow>>|null $contextWindows Filter to specific context-window pricing tiers. Use `group_by[]=context_window` to break out per-tier values.
     * @param \DateTimeInterface|null $endingAt End of range, exclusive. When omitted, defaults to the earlier of now and `starting_at` + 31 days. The range may span at most 31 days.
     * @param list<GroupBy|value-of<GroupBy>>|null $groupBy Dimensions to break each time bucket out by. Defaults to no grouping (one total per bucket). Each bucket reports at most its top 100 groups; a group beyond that cap has no row in that bucket (there is no remainder row), so grouped buckets are not exhaustive when a dimension has more than 100 distinct values.
     * @param list<AnalyticsInferenceGeoFilter|value-of<AnalyticsInferenceGeoFilter>>|null $inferenceGeos Filter to specific inference regions. `not_available` matches rows where the region is unset. Use `group_by[]=inference_geo` to break out per-region values.
     * @param int|null $limit Maximum number of time buckets per page. Defaults and caps vary by `bucket_width` (`1d`: default 7, max 31; `1h`: default 24, max 168; `1m`: default 60, max 256).
     * @param list<string>|null $models Models to include. Defaults to all models. Use `group_by[]=model` to break out per-model values.
     * @param string|null $page opaque cursor from a previous response's `next_page` field
     * @param list<AnalyticsProductFilter|value-of<AnalyticsProductFilter>>|null $products Product surfaces to include. Defaults to all products. Use `group_by[]=product` to break out per-product values.
     * @param list<string>|null $rbacGroupIDs Filter to usage attributed to specific RBAC groups. Accepts tagged RBAC group IDs (`rbac_group_...`) or bare group UUIDs. A row matches when the user belonged to any of the listed groups on the (UTC) day the usage occurred; usage with no group attribution never matches.
     * @param list<string>|null $slackChannelIDs Filter to usage originating from specific Slack channels. Use `group_by[]=slack_channel_id` to break out per-channel values.
     * @param list<Speed|value-of<Speed>>|null $speeds Filter to fast or standard inference mode. Use `group_by[]=speed` to break out per-mode values.
     * @param list<string>|null $userIDs filter to specific users by tagged user ID
     * @param RequestOpts|null $requestOptions
     *
     * @return PageCursor<AnalyticsUsageReportTimeBucket>
     *
     * @throws APIException
     */
    public function list(
        \DateTimeInterface $startingAt,
        BucketWidth|string|null $bucketWidth = null,
        ?array $claudeTagCategories = null,
        ?array $claudeTagUserIDs = null,
        ?array $contextWindows = null,
        ?\DateTimeInterface $endingAt = null,
        ?array $groupBy = null,
        ?array $inferenceGeos = null,
        ?int $limit = null,
        ?array $models = null,
        ?string $page = null,
        ?array $products = null,
        ?array $rbacGroupIDs = null,
        ?array $slackChannelIDs = null,
        ?array $speeds = null,
        ?array $userIDs = null,
        RequestOptions|array|null $requestOptions = null,
    ): PageCursor;
}
