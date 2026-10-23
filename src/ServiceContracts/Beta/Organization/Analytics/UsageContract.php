<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Organization\Analytics;

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
use Anthropic\Beta\Organization\Analytics\Usage\BetaAnalyticsUsageGroupBy;
use Anthropic\Beta\Organization\Analytics\Usage\BetaAnalyticsUsageItem;
use Anthropic\Beta\Organization\Analytics\Usage\BetaAnalyticsUsageOrderBy;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\ReportPageCursor;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface UsageContract
{
    /**
     * @api
     *
     * @param \DateTimeInterface $startingAt Query param: Start of range, inclusive. RFC 3339 tz-aware. Must be within the last 365 days and no earlier than 2026-01-01T00:00:00Z.
     * @param list<string>|null $actorIDs Query param: Filter to usage attributed to specific identities, by tagged ID: a `user_...`, `svac_...` (service account), or `apikey_...` ID. An `apikey_` entry matches only usage attributed to the key itself, not usage on that key attributed to a user or service account (use `api_key_ids[]` for every request a key authenticated). Federated identities have no tagged ID; select them with `actor_types[]`. Use `group_by[]=actor` to break out per-identity values.
     * @param list<AnalyticsActorType|value-of<AnalyticsActorType>>|null $actorTypes Query param: Filter to usage attributed to specific kinds of identity. Use `group_by[]=actor_type` to break out per-kind values.
     * @param list<string>|null $agentIDs Query param: Filter to usage incurred by sessions of specific Claude Managed Agents agents. Use `group_by[]=agent_id` to break out per-agent values. Claude Developer Platform organizations only.
     * @param list<string>|null $apiKeyIDs Query param: Filter to usage authenticated by specific API keys, by tagged API key ID (`apikey_...`), whichever identity the usage is attributed to. Include an empty entry (`api_key_ids[]=`) to also match usage that no API key authenticated. Use `group_by[]=api_key_id` to break out per-key values; usage without a key has a null `api_key_id`. Claude Developer Platform organizations only.
     * @param list<AnalyticsClaudeTagCategory|value-of<AnalyticsClaudeTagCategory>>|null $claudeTagCategories Query param: Filter to Claude Tag (Claude in Slack) usage in specific spend categories. Usage with no category never matches. `dm` usage is reported under the user's product rather than `claude_tag`, so combining this filter with `products[]=claude_tag` excludes it. Use `group_by[]=claude_tag_category` to break out per-category values.
     * @param list<string>|null $claudeTagUserIDs Query param: Filter to Claude Tag (Claude in Slack) usage attributed to specific Slack users, by Slack user ID (for example `U0123ABCDEF`), not claude.ai user ID. Usage that is not Claude Tag, and Claude Tag usage not attributed to a single user, never matches. Use `group_by[]=claude_tag_user_id` to break out per-user values.
     * @param list<AnalyticsContextWindow|value-of<AnalyticsContextWindow>>|null $contextWindows Query param: Filter to specific context-window pricing tiers. Use `group_by[]=context_window` to break out per-tier values.
     * @param list<string>|null $deploymentIDs Query param: Filter to usage incurred by Claude Managed Agents sessions that specific deployments started. Use `group_by[]=deployment_id` to break out per-deployment values. Claude Developer Platform organizations only.
     * @param \DateTimeInterface|null $endingAt Query param: End of range, exclusive. Required when `time_bucket_width` is set. Without `time_bucket_width`, defaults to the earlier of now and `starting_at` + 31 days. The range may span at most 31 days.
     * @param list<string>|null $environmentIDs Query param: Filter to usage incurred by Claude Managed Agents sessions that ran in specific environments. Use `group_by[]=environment_id` to break out per-environment values. Claude Developer Platform organizations only.
     * @param bool $excludeDeletedUsers Query param: If true, omit rows whose `actor` is a `user_actor` with `deleted: true`. Requires `group_by[]=actor`. Rows for other actor types, and rows whose `actor` is null, are always kept. A page may contain fewer than `limit` rows; use `has_more` and `next_page` to paginate as usual.
     * @param list<BetaAnalyticsUsageGroupBy|value-of<BetaAnalyticsUsageGroupBy>>|null $groupBy Query param: Dimensions to break usage out by (at most 5): one row per combination of their values with usage in the range (and per time bucket, when `time_bucket_width` is set), every combination returned across pages rather than a capped top set. When omitted, a single row aggregates the whole range.
     * @param list<AnalyticsInferenceGeoFilter|value-of<AnalyticsInferenceGeoFilter>>|null $inferenceGeos Query param: Filter to specific inference regions. `not_available` matches rows where the region is unset. Use `group_by[]=inference_geo` to break out per-region values.
     * @param int $limit Query param: Number of rows per page (1-1000, default 20). `cost_type`/`token_type` fan-out rows (cost endpoint only) do not count toward this limit, so `data` can exceed it.
     * @param list<string>|null $models Query param: Models to include. Defaults to all models. Use `group_by[]=model` to break out per-model values.
     * @param AnalyticsUsageCostSortOrder|value-of<AnalyticsUsageCostSortOrder> $order Query param: Sort direction of the `order_by` metric, or of the time buckets when `order_by` is `time` and `time_bucket_width` is set. Defaults to `desc`.
     * @param BetaAnalyticsUsageOrderBy|value-of<BetaAnalyticsUsageOrderBy> $orderBy Query param: Row order. A metric ranks rows by that metric in the `order` direction. `time` orders rows by time bucket in the `order` direction (newest first by default) and, within a bucket, by `total_tokens`, highest first. `time` takes effect only with `time_bucket_width`; without it, `time` is the same as `total_tokens`. Defaults to `total_tokens`.
     * @param string|null $page query param: Opaque cursor from a previous response's `next_page` field
     * @param list<AnalyticsUsageCostProductFilter|value-of<AnalyticsUsageCostProductFilter>>|null $products Query param: Product surfaces to include. Defaults to all products.
     * @param list<string>|null $rbacGroupIDs Query param: Filter to usage attributed to specific RBAC groups. Accepts tagged RBAC group IDs (`rbac_group_...`) or bare group UUIDs. A row matches when the user belonged to any of the listed groups on the (UTC) day the usage occurred; usage with no group attribution never matches.
     * @param list<AnalyticsServiceTier|value-of<AnalyticsServiceTier>>|null $serviceTiers Query param: Filter to specific service tiers. Use `group_by[]=service_tier` to break out per-tier values. Claude Developer Platform organizations only; matches nothing for a Claude Enterprise organization.
     * @param list<string>|null $sessionIDs Query param: Filter to usage incurred by specific Claude Managed Agents sessions, by tagged session ID (`sesn_...`). Use `group_by[]=session_id` to break out per-session values. Claude Developer Platform organizations only.
     * @param list<string>|null $slackChannelIDs Query param: Filter to usage originating from specific Slack channels. Use `group_by[]=slack_channel_id` to break out per-channel values.
     * @param list<AnalyticsSpeed|value-of<AnalyticsSpeed>>|null $speeds Query param: Filter to fast or standard inference mode. Use `group_by[]=speed` to break out per-mode values.
     * @param AnalyticsTimeBucketWidth|value-of<AnalyticsTimeBucketWidth>|null $timeBucketWidth Query param: Time-bucket granularity. When set, rows are returned per time bucket (one per bucket and dimension combination with usage) and each row's `starting_at` and `ending_at` are that bucket's bounds; the time bucket counts toward `limit`. `ending_at` is required when `time_bucket_width` is set, and with `time_bucket_width="1m"` the range may span at most 24 hours. When omitted, each row aggregates the requested range with `starting_at` and `ending_at` each rounded down to the hour.
     * @param list<string>|null $userProfileIDs Query param: Filter to usage attributed to specific user profiles, by tagged user profile ID (`uprof_...`). Use `group_by[]=user_profile_id` to break out per-profile values. Claude Developer Platform organizations only.
     * @param list<string>|null $workspaceIDs Query param: Filter to usage in specific workspaces, by tagged workspace ID (`wrkspc_...`). Use `group_by[]=workspace_id` to break out per-workspace values. Claude Developer Platform organizations only; matches nothing for a Claude Enterprise organization.
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: This endpoint is in beta: requests must send `analytics-usage-cost-2026-08-24` in this header
     * @param RequestOpts|null $requestOptions
     *
     * @return ReportPageCursor<BetaAnalyticsUsageItem>
     *
     * @throws APIException
     */
    public function list(
        \DateTimeInterface $startingAt,
        ?array $actorIDs = null,
        ?array $actorTypes = null,
        ?array $agentIDs = null,
        ?array $apiKeyIDs = null,
        ?array $claudeTagCategories = null,
        ?array $claudeTagUserIDs = null,
        ?array $contextWindows = null,
        ?array $deploymentIDs = null,
        ?\DateTimeInterface $endingAt = null,
        ?array $environmentIDs = null,
        ?bool $excludeDeletedUsers = null,
        ?array $groupBy = null,
        ?array $inferenceGeos = null,
        ?int $limit = null,
        ?array $models = null,
        AnalyticsUsageCostSortOrder|string|null $order = null,
        BetaAnalyticsUsageOrderBy|string|null $orderBy = null,
        ?string $page = null,
        ?array $products = null,
        ?array $rbacGroupIDs = null,
        ?array $serviceTiers = null,
        ?array $sessionIDs = null,
        ?array $slackChannelIDs = null,
        ?array $speeds = null,
        AnalyticsTimeBucketWidth|string|null $timeBucketWidth = null,
        ?array $userProfileIDs = null,
        ?array $workspaceIDs = null,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): ReportPageCursor;
}
