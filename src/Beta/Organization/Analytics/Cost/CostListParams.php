<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Analytics\Cost;

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
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
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
 * @see Anthropic\Services\Beta\Organization\Analytics\CostService::list()
 *
 * @phpstan-type CostListParamsShape = array{
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
 *   excludeDeletedUsers?: bool|null,
 *   groupBy?: list<BetaAnalyticsCostGroupBy|value-of<BetaAnalyticsCostGroupBy>>|null,
 *   inferenceGeos?: list<AnalyticsInferenceGeoFilter|value-of<AnalyticsInferenceGeoFilter>>|null,
 *   limit?: int|null,
 *   models?: list<string>|null,
 *   order?: null|AnalyticsUsageCostSortOrder|value-of<AnalyticsUsageCostSortOrder>,
 *   orderBy?: null|BetaAnalyticsCostOrderBy|value-of<BetaAnalyticsCostOrderBy>,
 *   page?: string|null,
 *   products?: list<AnalyticsUsageCostProductFilter|value-of<AnalyticsUsageCostProductFilter>>|null,
 *   rbacGroupIDs?: list<string>|null,
 *   serviceTiers?: list<AnalyticsServiceTier|value-of<AnalyticsServiceTier>>|null,
 *   sessionIDs?: list<string>|null,
 *   slackChannelIDs?: list<string>|null,
 *   speeds?: list<AnalyticsSpeed|value-of<AnalyticsSpeed>>|null,
 *   timeBucketWidth?: null|AnalyticsTimeBucketWidth|value-of<AnalyticsTimeBucketWidth>,
 *   userProfileIDs?: list<string>|null,
 *   workspaceIDs?: list<string>|null,
 *   betas?: list<string|AnthropicBeta|value-of<AnthropicBeta>>|null,
 * }
 */
final class CostListParams implements BaseModel
{
    /** @use SdkModel<CostListParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Start of range, inclusive. RFC 3339 tz-aware. Must be within the last 365 days and no earlier than 2026-01-01T00:00:00Z.
     */
    #[Required]
    public \DateTimeInterface $startingAt;

    /**
     * Filter to usage attributed to specific identities, by tagged ID: a `user_...`, `svac_...` (service account), or `apikey_...` ID. An `apikey_` entry matches only usage attributed to the key itself, not usage on that key attributed to a user or service account (use `api_key_ids[]` for every request a key authenticated). Federated identities have no tagged ID; select them with `actor_types[]`. Use `group_by[]=actor` to break out per-identity values.
     *
     * @var list<string>|null $actorIDs
     */
    #[Optional(list: 'string', nullable: true)]
    public ?array $actorIDs;

    /**
     * Filter to usage attributed to specific kinds of identity. Use `group_by[]=actor_type` to break out per-kind values.
     *
     * @var list<value-of<AnalyticsActorType>>|null $actorTypes
     */
    #[Optional(list: AnalyticsActorType::class, nullable: true)]
    public ?array $actorTypes;

    /**
     * Filter to usage incurred by sessions of specific Claude Managed Agents agents. Use `group_by[]=agent_id` to break out per-agent values. Claude Developer Platform organizations only.
     *
     * @var list<string>|null $agentIDs
     */
    #[Optional(list: 'string', nullable: true)]
    public ?array $agentIDs;

    /**
     * Filter to usage authenticated by specific API keys, by tagged API key ID (`apikey_...`), whichever identity the usage is attributed to. Include an empty entry (`api_key_ids[]=`) to also match usage that no API key authenticated. Use `group_by[]=api_key_id` to break out per-key values; usage without a key has a null `api_key_id`. Claude Developer Platform organizations only.
     *
     * @var list<string>|null $apiKeyIDs
     */
    #[Optional(list: 'string', nullable: true)]
    public ?array $apiKeyIDs;

    /**
     * Filter to Claude Tag (Claude in Slack) usage in specific spend categories. Usage with no category never matches. `dm` usage is reported under the user's product rather than `claude_tag`, so combining this filter with `products[]=claude_tag` excludes it. Use `group_by[]=claude_tag_category` to break out per-category values.
     *
     * @var list<value-of<AnalyticsClaudeTagCategory>>|null $claudeTagCategories
     */
    #[Optional(list: AnalyticsClaudeTagCategory::class, nullable: true)]
    public ?array $claudeTagCategories;

    /**
     * Filter to Claude Tag (Claude in Slack) usage attributed to specific Slack users, by Slack user ID (for example `U0123ABCDEF`), not claude.ai user ID. Usage that is not Claude Tag, and Claude Tag usage not attributed to a single user, never matches. Use `group_by[]=claude_tag_user_id` to break out per-user values.
     *
     * @var list<string>|null $claudeTagUserIDs
     */
    #[Optional(list: 'string', nullable: true)]
    public ?array $claudeTagUserIDs;

    /**
     * Filter to specific context-window pricing tiers. Use `group_by[]=context_window` to break out per-tier values.
     *
     * @var list<value-of<AnalyticsContextWindow>>|null $contextWindows
     */
    #[Optional(list: AnalyticsContextWindow::class, nullable: true)]
    public ?array $contextWindows;

    /**
     * Filter to usage incurred by Claude Managed Agents sessions that specific deployments started. Use `group_by[]=deployment_id` to break out per-deployment values. Claude Developer Platform organizations only.
     *
     * @var list<string>|null $deploymentIDs
     */
    #[Optional(list: 'string', nullable: true)]
    public ?array $deploymentIDs;

    /**
     * End of range, exclusive. Required when `time_bucket_width` is set. Without `time_bucket_width`, defaults to the earlier of now and `starting_at` + 31 days. The range may span at most 31 days.
     */
    #[Optional(nullable: true)]
    public ?\DateTimeInterface $endingAt;

    /**
     * Filter to usage incurred by Claude Managed Agents sessions that ran in specific environments. Use `group_by[]=environment_id` to break out per-environment values. Claude Developer Platform organizations only.
     *
     * @var list<string>|null $environmentIDs
     */
    #[Optional(list: 'string', nullable: true)]
    public ?array $environmentIDs;

    /**
     * If true, omit rows whose `actor` is a `user_actor` with `deleted: true`. Requires `group_by[]=actor`. Rows for other actor types, and rows whose `actor` is null, are always kept. A page may contain fewer than `limit` rows; use `has_more` and `next_page` to paginate as usual.
     */
    #[Optional]
    public ?bool $excludeDeletedUsers;

    /**
     * Dimensions to break cost out by (at most 5, not counting `cost_type` and `token_type`): one row per combination of their values with cost in the range (and per time bucket, when `time_bucket_width` is set), every combination returned across pages rather than a capped top set. `cost_type` and `token_type` do not count toward `limit`: `cost_type` returns one row per cost component (tokens, web search, code execution, and `session_usage`, Claude Managed Agents session time); `token_type` returns one row per token type, each with `cost_type: "tokens"`; combining both returns the per-token-type rows plus the web-search, code-execution and session-usage rows. When omitted, a single row aggregates the whole range.
     *
     * @var list<value-of<BetaAnalyticsCostGroupBy>>|null $groupBy
     */
    #[Optional(list: BetaAnalyticsCostGroupBy::class, nullable: true)]
    public ?array $groupBy;

    /**
     * Filter to specific inference regions. `not_available` matches rows where the region is unset. Use `group_by[]=inference_geo` to break out per-region values.
     *
     * @var list<value-of<AnalyticsInferenceGeoFilter>>|null $inferenceGeos
     */
    #[Optional(list: AnalyticsInferenceGeoFilter::class, nullable: true)]
    public ?array $inferenceGeos;

    /**
     * Number of rows per page (1-1000, default 20). `cost_type`/`token_type` fan-out rows (cost endpoint only) do not count toward this limit, so `data` can exceed it.
     */
    #[Optional]
    public ?int $limit;

    /**
     * Models to include. Defaults to all models. Use `group_by[]=model` to break out per-model values.
     *
     * @var list<string>|null $models
     */
    #[Optional(list: 'string', nullable: true)]
    public ?array $models;

    /**
     * Sort direction of the `order_by` metric, or of the time buckets when `order_by` is `time` and `time_bucket_width` is set. Defaults to `desc`.
     *
     * @var value-of<AnalyticsUsageCostSortOrder>|null $order
     */
    #[Optional(enum: AnalyticsUsageCostSortOrder::class)]
    public ?string $order;

    /**
     * Row order. A metric ranks rows by that metric in the `order` direction. `time` orders rows by time bucket in the `order` direction (newest first by default) and, within a bucket, by `amount`, highest first. `time` takes effect only with `time_bucket_width`; without it, `time` is the same as `amount`. Defaults to `amount`.
     *
     * @var value-of<BetaAnalyticsCostOrderBy>|null $orderBy
     */
    #[Optional(enum: BetaAnalyticsCostOrderBy::class)]
    public ?string $orderBy;

    /**
     * Opaque cursor from a previous response's `next_page` field.
     */
    #[Optional(nullable: true)]
    public ?string $page;

    /**
     * Product surfaces to include. Defaults to all products.
     *
     * @var list<value-of<AnalyticsUsageCostProductFilter>>|null $products
     */
    #[Optional(list: AnalyticsUsageCostProductFilter::class, nullable: true)]
    public ?array $products;

    /**
     * Filter to usage attributed to specific RBAC groups. Accepts tagged RBAC group IDs (`rbac_group_...`) or bare group UUIDs. A row matches when the user belonged to any of the listed groups on the (UTC) day the usage occurred; usage with no group attribution never matches.
     *
     * @var list<string>|null $rbacGroupIDs
     */
    #[Optional(list: 'string', nullable: true)]
    public ?array $rbacGroupIDs;

    /**
     * Filter to specific service tiers. Use `group_by[]=service_tier` to break out per-tier values. Claude Developer Platform organizations only; matches nothing for a Claude Enterprise organization.
     *
     * @var list<value-of<AnalyticsServiceTier>>|null $serviceTiers
     */
    #[Optional(list: AnalyticsServiceTier::class, nullable: true)]
    public ?array $serviceTiers;

    /**
     * Filter to usage incurred by specific Claude Managed Agents sessions, by tagged session ID (`sesn_...`). Use `group_by[]=session_id` to break out per-session values. Claude Developer Platform organizations only.
     *
     * @var list<string>|null $sessionIDs
     */
    #[Optional(list: 'string', nullable: true)]
    public ?array $sessionIDs;

    /**
     * Filter to usage originating from specific Slack channels. Use `group_by[]=slack_channel_id` to break out per-channel values.
     *
     * @var list<string>|null $slackChannelIDs
     */
    #[Optional(list: 'string', nullable: true)]
    public ?array $slackChannelIDs;

    /**
     * Filter to fast or standard inference mode. Use `group_by[]=speed` to break out per-mode values.
     *
     * @var list<value-of<AnalyticsSpeed>>|null $speeds
     */
    #[Optional(list: AnalyticsSpeed::class, nullable: true)]
    public ?array $speeds;

    /**
     * Time-bucket granularity. When set, rows are returned per time bucket (one per bucket and dimension combination with usage) and each row's `starting_at` and `ending_at` are that bucket's bounds; the time bucket counts toward `limit`. `ending_at` is required when `time_bucket_width` is set, and with `time_bucket_width="1m"` the range may span at most 24 hours. When omitted, each row aggregates the requested range with `starting_at` and `ending_at` each rounded down to the hour.
     *
     * @var value-of<AnalyticsTimeBucketWidth>|null $timeBucketWidth
     */
    #[Optional(enum: AnalyticsTimeBucketWidth::class, nullable: true)]
    public ?string $timeBucketWidth;

    /**
     * Filter to usage attributed to specific user profiles, by tagged user profile ID (`uprof_...`). Use `group_by[]=user_profile_id` to break out per-profile values. Claude Developer Platform organizations only.
     *
     * @var list<string>|null $userProfileIDs
     */
    #[Optional(list: 'string', nullable: true)]
    public ?array $userProfileIDs;

    /**
     * Filter to usage in specific workspaces, by tagged workspace ID (`wrkspc_...`). Use `group_by[]=workspace_id` to break out per-workspace values. Claude Developer Platform organizations only; matches nothing for a Claude Enterprise organization.
     *
     * @var list<string>|null $workspaceIDs
     */
    #[Optional(list: 'string', nullable: true)]
    public ?array $workspaceIDs;

    /**
     * This endpoint is in beta: requests must send `analytics-usage-cost-2026-08-24` in this header.
     *
     * @var list<string|value-of<AnthropicBeta>>|null $betas
     */
    #[Optional(list: AnthropicBeta::class)]
    public ?array $betas;

    /**
     * `new CostListParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * CostListParams::with(startingAt: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new CostListParams())->withStartingAt(...)
     * ```
     */
    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<string>|null $actorIDs
     * @param list<AnalyticsActorType|value-of<AnalyticsActorType>>|null $actorTypes
     * @param list<string>|null $agentIDs
     * @param list<string>|null $apiKeyIDs
     * @param list<AnalyticsClaudeTagCategory|value-of<AnalyticsClaudeTagCategory>>|null $claudeTagCategories
     * @param list<string>|null $claudeTagUserIDs
     * @param list<AnalyticsContextWindow|value-of<AnalyticsContextWindow>>|null $contextWindows
     * @param list<string>|null $deploymentIDs
     * @param list<string>|null $environmentIDs
     * @param list<BetaAnalyticsCostGroupBy|value-of<BetaAnalyticsCostGroupBy>>|null $groupBy
     * @param list<AnalyticsInferenceGeoFilter|value-of<AnalyticsInferenceGeoFilter>>|null $inferenceGeos
     * @param list<string>|null $models
     * @param AnalyticsUsageCostSortOrder|value-of<AnalyticsUsageCostSortOrder>|null $order
     * @param BetaAnalyticsCostOrderBy|value-of<BetaAnalyticsCostOrderBy>|null $orderBy
     * @param list<AnalyticsUsageCostProductFilter|value-of<AnalyticsUsageCostProductFilter>>|null $products
     * @param list<string>|null $rbacGroupIDs
     * @param list<AnalyticsServiceTier|value-of<AnalyticsServiceTier>>|null $serviceTiers
     * @param list<string>|null $sessionIDs
     * @param list<string>|null $slackChannelIDs
     * @param list<AnalyticsSpeed|value-of<AnalyticsSpeed>>|null $speeds
     * @param AnalyticsTimeBucketWidth|value-of<AnalyticsTimeBucketWidth>|null $timeBucketWidth
     * @param list<string>|null $userProfileIDs
     * @param list<string>|null $workspaceIDs
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>>|null $betas
     */
    public static function with(
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
        BetaAnalyticsCostOrderBy|string|null $orderBy = null,
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
    ): self {
        $self = new self;

        $self['startingAt'] = $startingAt;

        null !== $actorIDs && $self['actorIDs'] = $actorIDs;
        null !== $actorTypes && $self['actorTypes'] = $actorTypes;
        null !== $agentIDs && $self['agentIDs'] = $agentIDs;
        null !== $apiKeyIDs && $self['apiKeyIDs'] = $apiKeyIDs;
        null !== $claudeTagCategories && $self['claudeTagCategories'] = $claudeTagCategories;
        null !== $claudeTagUserIDs && $self['claudeTagUserIDs'] = $claudeTagUserIDs;
        null !== $contextWindows && $self['contextWindows'] = $contextWindows;
        null !== $deploymentIDs && $self['deploymentIDs'] = $deploymentIDs;
        null !== $endingAt && $self['endingAt'] = $endingAt;
        null !== $environmentIDs && $self['environmentIDs'] = $environmentIDs;
        null !== $excludeDeletedUsers && $self['excludeDeletedUsers'] = $excludeDeletedUsers;
        null !== $groupBy && $self['groupBy'] = $groupBy;
        null !== $inferenceGeos && $self['inferenceGeos'] = $inferenceGeos;
        null !== $limit && $self['limit'] = $limit;
        null !== $models && $self['models'] = $models;
        null !== $order && $self['order'] = $order;
        null !== $orderBy && $self['orderBy'] = $orderBy;
        null !== $page && $self['page'] = $page;
        null !== $products && $self['products'] = $products;
        null !== $rbacGroupIDs && $self['rbacGroupIDs'] = $rbacGroupIDs;
        null !== $serviceTiers && $self['serviceTiers'] = $serviceTiers;
        null !== $sessionIDs && $self['sessionIDs'] = $sessionIDs;
        null !== $slackChannelIDs && $self['slackChannelIDs'] = $slackChannelIDs;
        null !== $speeds && $self['speeds'] = $speeds;
        null !== $timeBucketWidth && $self['timeBucketWidth'] = $timeBucketWidth;
        null !== $userProfileIDs && $self['userProfileIDs'] = $userProfileIDs;
        null !== $workspaceIDs && $self['workspaceIDs'] = $workspaceIDs;
        null !== $betas && $self['betas'] = $betas;

        return $self;
    }

    /**
     * Start of range, inclusive. RFC 3339 tz-aware. Must be within the last 365 days and no earlier than 2026-01-01T00:00:00Z.
     */
    public function withStartingAt(\DateTimeInterface $startingAt): self
    {
        $self = clone $this;
        $self['startingAt'] = $startingAt;

        return $self;
    }

    /**
     * Filter to usage attributed to specific identities, by tagged ID: a `user_...`, `svac_...` (service account), or `apikey_...` ID. An `apikey_` entry matches only usage attributed to the key itself, not usage on that key attributed to a user or service account (use `api_key_ids[]` for every request a key authenticated). Federated identities have no tagged ID; select them with `actor_types[]`. Use `group_by[]=actor` to break out per-identity values.
     *
     * @param list<string>|null $actorIDs
     */
    public function withActorIDs(?array $actorIDs): self
    {
        $self = clone $this;
        $self['actorIDs'] = $actorIDs;

        return $self;
    }

    /**
     * Filter to usage attributed to specific kinds of identity. Use `group_by[]=actor_type` to break out per-kind values.
     *
     * @param list<AnalyticsActorType|value-of<AnalyticsActorType>>|null $actorTypes
     */
    public function withActorTypes(?array $actorTypes): self
    {
        $self = clone $this;
        $self['actorTypes'] = $actorTypes;

        return $self;
    }

    /**
     * Filter to usage incurred by sessions of specific Claude Managed Agents agents. Use `group_by[]=agent_id` to break out per-agent values. Claude Developer Platform organizations only.
     *
     * @param list<string>|null $agentIDs
     */
    public function withAgentIDs(?array $agentIDs): self
    {
        $self = clone $this;
        $self['agentIDs'] = $agentIDs;

        return $self;
    }

    /**
     * Filter to usage authenticated by specific API keys, by tagged API key ID (`apikey_...`), whichever identity the usage is attributed to. Include an empty entry (`api_key_ids[]=`) to also match usage that no API key authenticated. Use `group_by[]=api_key_id` to break out per-key values; usage without a key has a null `api_key_id`. Claude Developer Platform organizations only.
     *
     * @param list<string>|null $apiKeyIDs
     */
    public function withAPIKeyIDs(?array $apiKeyIDs): self
    {
        $self = clone $this;
        $self['apiKeyIDs'] = $apiKeyIDs;

        return $self;
    }

    /**
     * Filter to Claude Tag (Claude in Slack) usage in specific spend categories. Usage with no category never matches. `dm` usage is reported under the user's product rather than `claude_tag`, so combining this filter with `products[]=claude_tag` excludes it. Use `group_by[]=claude_tag_category` to break out per-category values.
     *
     * @param list<AnalyticsClaudeTagCategory|value-of<AnalyticsClaudeTagCategory>>|null $claudeTagCategories
     */
    public function withClaudeTagCategories(?array $claudeTagCategories): self
    {
        $self = clone $this;
        $self['claudeTagCategories'] = $claudeTagCategories;

        return $self;
    }

    /**
     * Filter to Claude Tag (Claude in Slack) usage attributed to specific Slack users, by Slack user ID (for example `U0123ABCDEF`), not claude.ai user ID. Usage that is not Claude Tag, and Claude Tag usage not attributed to a single user, never matches. Use `group_by[]=claude_tag_user_id` to break out per-user values.
     *
     * @param list<string>|null $claudeTagUserIDs
     */
    public function withClaudeTagUserIDs(?array $claudeTagUserIDs): self
    {
        $self = clone $this;
        $self['claudeTagUserIDs'] = $claudeTagUserIDs;

        return $self;
    }

    /**
     * Filter to specific context-window pricing tiers. Use `group_by[]=context_window` to break out per-tier values.
     *
     * @param list<AnalyticsContextWindow|value-of<AnalyticsContextWindow>>|null $contextWindows
     */
    public function withContextWindows(?array $contextWindows): self
    {
        $self = clone $this;
        $self['contextWindows'] = $contextWindows;

        return $self;
    }

    /**
     * Filter to usage incurred by Claude Managed Agents sessions that specific deployments started. Use `group_by[]=deployment_id` to break out per-deployment values. Claude Developer Platform organizations only.
     *
     * @param list<string>|null $deploymentIDs
     */
    public function withDeploymentIDs(?array $deploymentIDs): self
    {
        $self = clone $this;
        $self['deploymentIDs'] = $deploymentIDs;

        return $self;
    }

    /**
     * End of range, exclusive. Required when `time_bucket_width` is set. Without `time_bucket_width`, defaults to the earlier of now and `starting_at` + 31 days. The range may span at most 31 days.
     */
    public function withEndingAt(?\DateTimeInterface $endingAt): self
    {
        $self = clone $this;
        $self['endingAt'] = $endingAt;

        return $self;
    }

    /**
     * Filter to usage incurred by Claude Managed Agents sessions that ran in specific environments. Use `group_by[]=environment_id` to break out per-environment values. Claude Developer Platform organizations only.
     *
     * @param list<string>|null $environmentIDs
     */
    public function withEnvironmentIDs(?array $environmentIDs): self
    {
        $self = clone $this;
        $self['environmentIDs'] = $environmentIDs;

        return $self;
    }

    /**
     * If true, omit rows whose `actor` is a `user_actor` with `deleted: true`. Requires `group_by[]=actor`. Rows for other actor types, and rows whose `actor` is null, are always kept. A page may contain fewer than `limit` rows; use `has_more` and `next_page` to paginate as usual.
     */
    public function withExcludeDeletedUsers(bool $excludeDeletedUsers): self
    {
        $self = clone $this;
        $self['excludeDeletedUsers'] = $excludeDeletedUsers;

        return $self;
    }

    /**
     * Dimensions to break cost out by (at most 5, not counting `cost_type` and `token_type`): one row per combination of their values with cost in the range (and per time bucket, when `time_bucket_width` is set), every combination returned across pages rather than a capped top set. `cost_type` and `token_type` do not count toward `limit`: `cost_type` returns one row per cost component (tokens, web search, code execution, and `session_usage`, Claude Managed Agents session time); `token_type` returns one row per token type, each with `cost_type: "tokens"`; combining both returns the per-token-type rows plus the web-search, code-execution and session-usage rows. When omitted, a single row aggregates the whole range.
     *
     * @param list<BetaAnalyticsCostGroupBy|value-of<BetaAnalyticsCostGroupBy>>|null $groupBy
     */
    public function withGroupBy(?array $groupBy): self
    {
        $self = clone $this;
        $self['groupBy'] = $groupBy;

        return $self;
    }

    /**
     * Filter to specific inference regions. `not_available` matches rows where the region is unset. Use `group_by[]=inference_geo` to break out per-region values.
     *
     * @param list<AnalyticsInferenceGeoFilter|value-of<AnalyticsInferenceGeoFilter>>|null $inferenceGeos
     */
    public function withInferenceGeos(?array $inferenceGeos): self
    {
        $self = clone $this;
        $self['inferenceGeos'] = $inferenceGeos;

        return $self;
    }

    /**
     * Number of rows per page (1-1000, default 20). `cost_type`/`token_type` fan-out rows (cost endpoint only) do not count toward this limit, so `data` can exceed it.
     */
    public function withLimit(int $limit): self
    {
        $self = clone $this;
        $self['limit'] = $limit;

        return $self;
    }

    /**
     * Models to include. Defaults to all models. Use `group_by[]=model` to break out per-model values.
     *
     * @param list<string>|null $models
     */
    public function withModels(?array $models): self
    {
        $self = clone $this;
        $self['models'] = $models;

        return $self;
    }

    /**
     * Sort direction of the `order_by` metric, or of the time buckets when `order_by` is `time` and `time_bucket_width` is set. Defaults to `desc`.
     *
     * @param AnalyticsUsageCostSortOrder|value-of<AnalyticsUsageCostSortOrder> $order
     */
    public function withOrder(AnalyticsUsageCostSortOrder|string $order): self
    {
        $self = clone $this;
        $self['order'] = $order;

        return $self;
    }

    /**
     * Row order. A metric ranks rows by that metric in the `order` direction. `time` orders rows by time bucket in the `order` direction (newest first by default) and, within a bucket, by `amount`, highest first. `time` takes effect only with `time_bucket_width`; without it, `time` is the same as `amount`. Defaults to `amount`.
     *
     * @param BetaAnalyticsCostOrderBy|value-of<BetaAnalyticsCostOrderBy> $orderBy
     */
    public function withOrderBy(BetaAnalyticsCostOrderBy|string $orderBy): self
    {
        $self = clone $this;
        $self['orderBy'] = $orderBy;

        return $self;
    }

    /**
     * Opaque cursor from a previous response's `next_page` field.
     */
    public function withPage(?string $page): self
    {
        $self = clone $this;
        $self['page'] = $page;

        return $self;
    }

    /**
     * Product surfaces to include. Defaults to all products.
     *
     * @param list<AnalyticsUsageCostProductFilter|value-of<AnalyticsUsageCostProductFilter>>|null $products
     */
    public function withProducts(?array $products): self
    {
        $self = clone $this;
        $self['products'] = $products;

        return $self;
    }

    /**
     * Filter to usage attributed to specific RBAC groups. Accepts tagged RBAC group IDs (`rbac_group_...`) or bare group UUIDs. A row matches when the user belonged to any of the listed groups on the (UTC) day the usage occurred; usage with no group attribution never matches.
     *
     * @param list<string>|null $rbacGroupIDs
     */
    public function withRBACGroupIDs(?array $rbacGroupIDs): self
    {
        $self = clone $this;
        $self['rbacGroupIDs'] = $rbacGroupIDs;

        return $self;
    }

    /**
     * Filter to specific service tiers. Use `group_by[]=service_tier` to break out per-tier values. Claude Developer Platform organizations only; matches nothing for a Claude Enterprise organization.
     *
     * @param list<AnalyticsServiceTier|value-of<AnalyticsServiceTier>>|null $serviceTiers
     */
    public function withServiceTiers(?array $serviceTiers): self
    {
        $self = clone $this;
        $self['serviceTiers'] = $serviceTiers;

        return $self;
    }

    /**
     * Filter to usage incurred by specific Claude Managed Agents sessions, by tagged session ID (`sesn_...`). Use `group_by[]=session_id` to break out per-session values. Claude Developer Platform organizations only.
     *
     * @param list<string>|null $sessionIDs
     */
    public function withSessionIDs(?array $sessionIDs): self
    {
        $self = clone $this;
        $self['sessionIDs'] = $sessionIDs;

        return $self;
    }

    /**
     * Filter to usage originating from specific Slack channels. Use `group_by[]=slack_channel_id` to break out per-channel values.
     *
     * @param list<string>|null $slackChannelIDs
     */
    public function withSlackChannelIDs(?array $slackChannelIDs): self
    {
        $self = clone $this;
        $self['slackChannelIDs'] = $slackChannelIDs;

        return $self;
    }

    /**
     * Filter to fast or standard inference mode. Use `group_by[]=speed` to break out per-mode values.
     *
     * @param list<AnalyticsSpeed|value-of<AnalyticsSpeed>>|null $speeds
     */
    public function withSpeeds(?array $speeds): self
    {
        $self = clone $this;
        $self['speeds'] = $speeds;

        return $self;
    }

    /**
     * Time-bucket granularity. When set, rows are returned per time bucket (one per bucket and dimension combination with usage) and each row's `starting_at` and `ending_at` are that bucket's bounds; the time bucket counts toward `limit`. `ending_at` is required when `time_bucket_width` is set, and with `time_bucket_width="1m"` the range may span at most 24 hours. When omitted, each row aggregates the requested range with `starting_at` and `ending_at` each rounded down to the hour.
     *
     * @param AnalyticsTimeBucketWidth|value-of<AnalyticsTimeBucketWidth>|null $timeBucketWidth
     */
    public function withTimeBucketWidth(
        AnalyticsTimeBucketWidth|string|null $timeBucketWidth
    ): self {
        $self = clone $this;
        $self['timeBucketWidth'] = $timeBucketWidth;

        return $self;
    }

    /**
     * Filter to usage attributed to specific user profiles, by tagged user profile ID (`uprof_...`). Use `group_by[]=user_profile_id` to break out per-profile values. Claude Developer Platform organizations only.
     *
     * @param list<string>|null $userProfileIDs
     */
    public function withUserProfileIDs(?array $userProfileIDs): self
    {
        $self = clone $this;
        $self['userProfileIDs'] = $userProfileIDs;

        return $self;
    }

    /**
     * Filter to usage in specific workspaces, by tagged workspace ID (`wrkspc_...`). Use `group_by[]=workspace_id` to break out per-workspace values. Claude Developer Platform organizations only; matches nothing for a Claude Enterprise organization.
     *
     * @param list<string>|null $workspaceIDs
     */
    public function withWorkspaceIDs(?array $workspaceIDs): self
    {
        $self = clone $this;
        $self['workspaceIDs'] = $workspaceIDs;

        return $self;
    }

    /**
     * This endpoint is in beta: requests must send `analytics-usage-cost-2026-08-24` in this header.
     *
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas
     */
    public function withBetas(array $betas): self
    {
        $self = clone $this;
        $self['betas'] = $betas;

        return $self;
    }
}
