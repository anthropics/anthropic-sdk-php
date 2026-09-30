<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Organization\Analytics;

use Anthropic\Beta\Organization\Analytics\AnalyticsClaudeTagCategory;
use Anthropic\Beta\Organization\Analytics\AnalyticsContextWindow;
use Anthropic\Beta\Organization\Analytics\AnalyticsInferenceGeoFilter;
use Anthropic\Beta\Organization\Analytics\AnalyticsProductFilter;
use Anthropic\Beta\Organization\Analytics\AnalyticsUsageUsersItem;
use Anthropic\Beta\Organization\Analytics\UserUsageReport\UserUsageReportListParams\BucketWidth;
use Anthropic\Beta\Organization\Analytics\UserUsageReport\UserUsageReportListParams\GroupBy;
use Anthropic\Beta\Organization\Analytics\UserUsageReport\UserUsageReportListParams\Order;
use Anthropic\Beta\Organization\Analytics\UserUsageReport\UserUsageReportListParams\OrderBy;
use Anthropic\Beta\Organization\Analytics\UserUsageReport\UserUsageReportListParams\Speed;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface UserUsageReportContract
{
    /**
     * @api
     *
     * @param \DateTimeInterface $startingAt Start of range, inclusive. RFC 3339 tz-aware. Must be within the last 365 days and no earlier than 2026-01-01T00:00:00Z.
     * @param BucketWidth|value-of<BucketWidth>|null $bucketWidth Time-bucket granularity. When set, each row's `starting_at` and `ending_at` are populated and one actor may span several rows (one per time bucket with usage). The time bucket counts toward `limit`, so one page can return multiple rows for the same actor. `ending_at` is required when `bucket_width` is set, and with `bucket_width="1m"` the range may span at most 24 hours. When omitted, each row aggregates the full `[starting_at, ending_at)` range.
     * @param list<AnalyticsClaudeTagCategory|value-of<AnalyticsClaudeTagCategory>>|null $claudeTagCategories Filter to Claude Tag (Claude in Slack) usage in specific spend categories. Usage with no category never matches. `dm` usage is reported under the user's product rather than `claude-tag`, so combining this filter with `products[]=claude-tag` excludes it. Use `group_by[]=claude_tag_category` to break out per-category values.
     * @param list<string>|null $claudeTagUserIDs Filter to Claude Tag (Claude in Slack) usage attributed to specific Slack users, by Slack user ID (for example `U0123ABCDEF`), not claude.ai user ID. Usage that is not Claude Tag, and Claude Tag usage not attributed to a single user, never matches. Use `group_by[]=claude_tag_user_id` to break out per-user values.
     * @param list<AnalyticsContextWindow|value-of<AnalyticsContextWindow>>|null $contextWindows Filter to specific context-window pricing tiers. Use `group_by[]=context_window` to break out per-tier values.
     * @param \DateTimeInterface|null $endingAt End of range, exclusive. When omitted, defaults to the earlier of now and `starting_at` + 31 days. The range may span at most 31 days.
     * @param bool $excludeDeletedUsers If true, omit rows for users who are deleted (`deleted: true`). A page may contain fewer than `limit` rows; use `has_more` and `next_page` to paginate as usual.
     * @param list<GroupBy|value-of<GroupBy>>|null $groupBy Break each actor's row out by the given dimensions. Accepts the same values as the bucketed `/usage_report` endpoint. `limit` bounds (actor × time bucket × dimension) rows — with dimensions or `bucket_width` present, one actor may span several rows.
     * @param list<AnalyticsInferenceGeoFilter|value-of<AnalyticsInferenceGeoFilter>>|null $inferenceGeos Filter to specific inference regions. `not_available` matches rows where the region is unset. Use `group_by[]=inference_geo` to break out per-region values.
     * @param int $limit Number of rows per page (1-1000, default 20). One row per actor unless `group_by[]` or `bucket_width` splits an actor across rows; `cost_type`/`token_type` fan-out rows (cost endpoint only) are the exception — they do not count toward this limit, so `data` can exceed it.
     * @param list<string>|null $models Models to include. Defaults to all models. Use `group_by[]=model` to break out per-model values.
     * @param Order|value-of<Order> $order Sort direction. Defaults to `desc`.
     * @param OrderBy|value-of<OrderBy> $orderBy Metric to rank actors by. Defaults to `total_tokens`.
     * @param string|null $page opaque cursor from a previous response's `next_page` field
     * @param list<AnalyticsProductFilter|value-of<AnalyticsProductFilter>>|null $products Product surfaces to include. Defaults to all products.
     * @param list<string>|null $rbacGroupIDs Filter to usage attributed to specific RBAC groups. Accepts tagged RBAC group IDs (`rbac_group_...`) or bare group UUIDs. A row matches when the user belonged to any of the listed groups on the (UTC) day the usage occurred; usage with no group attribution never matches.
     * @param list<string>|null $slackChannelIDs Filter to usage originating from specific Slack channels. Use `group_by[]=slack_channel_id` to break out per-channel values.
     * @param list<Speed|value-of<Speed>>|null $speeds Filter to fast or standard inference mode. Use `group_by[]=speed` to break out per-mode values.
     * @param list<string>|null $userIDs filter to specific users by tagged user ID
     * @param RequestOpts|null $requestOptions
     *
     * @return PageCursor<AnalyticsUsageUsersItem>
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
        ?bool $excludeDeletedUsers = null,
        ?array $groupBy = null,
        ?array $inferenceGeos = null,
        ?int $limit = null,
        ?array $models = null,
        Order|string|null $order = null,
        OrderBy|string|null $orderBy = null,
        ?string $page = null,
        ?array $products = null,
        ?array $rbacGroupIDs = null,
        ?array $slackChannelIDs = null,
        ?array $speeds = null,
        ?array $userIDs = null,
        RequestOptions|array|null $requestOptions = null,
    ): PageCursor;
}
