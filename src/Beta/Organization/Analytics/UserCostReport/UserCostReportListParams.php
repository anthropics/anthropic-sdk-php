<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Analytics\UserCostReport;

use Anthropic\Beta\Organization\Analytics\AnalyticsClaudeTagCategory;
use Anthropic\Beta\Organization\Analytics\AnalyticsContextWindow;
use Anthropic\Beta\Organization\Analytics\AnalyticsInferenceGeoFilter;
use Anthropic\Beta\Organization\Analytics\AnalyticsProductFilter;
use Anthropic\Beta\Organization\Analytics\UserCostReport\UserCostReportListParams\BucketWidth;
use Anthropic\Beta\Organization\Analytics\UserCostReport\UserCostReportListParams\GroupBy;
use Anthropic\Beta\Organization\Analytics\UserCostReport\UserCostReportListParams\Order;
use Anthropic\Beta\Organization\Analytics\UserCostReport\UserCostReportListParams\OrderBy;
use Anthropic\Beta\Organization\Analytics\UserCostReport\UserCostReportListParams\Speed;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Concerns\SdkParams;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Get per-user cost in USD across a date range.
 *
 * Returns one row per user, ranked by spend. Use this to see which users
 * account for the most cost. Only cost attributable to a seat user is
 * included; for organization-wide totals including direct API-key and
 * automation traffic, use the bucketed
 * `/v1/organizations/analytics/cost_report` endpoint. Available to
 * organizations on a Claude Enterprise plan. Requires an API key with the
 * `read:analytics` scope.
 *
 * @see Anthropic\Services\Beta\Organization\Analytics\UserCostReportService::list()
 *
 * @phpstan-type UserCostReportListParamsShape = array{
 *   startingAt: \DateTimeInterface,
 *   bucketWidth?: null|BucketWidth|value-of<BucketWidth>,
 *   claudeTagCategories?: list<AnalyticsClaudeTagCategory|value-of<AnalyticsClaudeTagCategory>>|null,
 *   claudeTagUserIDs?: list<string>|null,
 *   contextWindows?: list<AnalyticsContextWindow|value-of<AnalyticsContextWindow>>|null,
 *   endingAt?: \DateTimeInterface|null,
 *   excludeDeletedUsers?: bool|null,
 *   groupBy?: list<GroupBy|value-of<GroupBy>>|null,
 *   inferenceGeos?: list<AnalyticsInferenceGeoFilter|value-of<AnalyticsInferenceGeoFilter>>|null,
 *   limit?: int|null,
 *   models?: list<string>|null,
 *   order?: null|Order|value-of<Order>,
 *   orderBy?: null|OrderBy|value-of<OrderBy>,
 *   page?: string|null,
 *   products?: list<AnalyticsProductFilter|value-of<AnalyticsProductFilter>>|null,
 *   rbacGroupIDs?: list<string>|null,
 *   slackChannelIDs?: list<string>|null,
 *   speeds?: list<Speed|value-of<Speed>>|null,
 *   userIDs?: list<string>|null,
 * }
 */
final class UserCostReportListParams implements BaseModel
{
    /** @use SdkModel<UserCostReportListParamsShape> */
    use SdkModel;
    use SdkParams;

    /**
     * Start of range, inclusive. RFC 3339 tz-aware. Must be within the last 365 days and no earlier than 2026-01-01T00:00:00Z.
     */
    #[Required]
    public \DateTimeInterface $startingAt;

    /**
     * Time-bucket granularity. When set, each row's `starting_at` and `ending_at` are populated and one actor may span several rows (one per time bucket with usage). The time bucket counts toward `limit`, so one page can return multiple rows for the same actor. `ending_at` is required when `bucket_width` is set, and with `bucket_width="1m"` the range may span at most 24 hours. When omitted, each row aggregates the full `[starting_at, ending_at)` range.
     *
     * @var value-of<BucketWidth>|null $bucketWidth
     */
    #[Optional(enum: BucketWidth::class, nullable: true)]
    public ?string $bucketWidth;

    /**
     * Filter to Claude Tag (Claude in Slack) usage in specific spend categories. Usage with no category never matches. `dm` usage is reported under the user's product rather than `claude-tag`, so combining this filter with `products[]=claude-tag` excludes it. Use `group_by[]=claude_tag_category` to break out per-category values.
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
     * End of range, exclusive. When omitted, defaults to the earlier of now and `starting_at` + 31 days. The range may span at most 31 days.
     */
    #[Optional(nullable: true)]
    public ?\DateTimeInterface $endingAt;

    /**
     * If true, omit rows for users who are deleted (`deleted: true`). A page may contain fewer than `limit` rows; use `has_more` and `next_page` to paginate as usual.
     */
    #[Optional]
    public ?bool $excludeDeletedUsers;

    /**
     * Break each actor's row out by the given dimensions. Accepts the same values as the bucketed `/cost_report` endpoint. The `product`, `model`, `context_window`, `inference_geo`, and `speed` dimensions — and the time bucket, when `bucket_width` is set — count toward `limit`. `cost_type` and `token_type` do not: `cost_type` returns one row per cost component (tokens, web search, code execution); `token_type` returns one row per token type, each with `cost_type: "tokens"`; combining both returns the per-token-type rows plus the web-search and code-execution rows. A page can therefore contain more rows than `limit` when `cost_type` or `token_type` is requested.
     *
     * @var list<value-of<GroupBy>>|null $groupBy
     */
    #[Optional(list: GroupBy::class, nullable: true)]
    public ?array $groupBy;

    /**
     * Filter to specific inference regions. `not_available` matches rows where the region is unset. Use `group_by[]=inference_geo` to break out per-region values.
     *
     * @var list<value-of<AnalyticsInferenceGeoFilter>>|null $inferenceGeos
     */
    #[Optional(list: AnalyticsInferenceGeoFilter::class, nullable: true)]
    public ?array $inferenceGeos;

    /**
     * Number of rows per page (1-1000, default 20). One row per actor unless `group_by[]` or `bucket_width` splits an actor across rows; `cost_type`/`token_type` fan-out rows (cost endpoint only) are the exception — they do not count toward this limit, so `data` can exceed it.
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
     * Sort direction. Defaults to `desc`.
     *
     * @var value-of<Order>|null $order
     */
    #[Optional(enum: Order::class)]
    public ?string $order;

    /**
     * Metric to rank actors by. Defaults to `amount`.
     *
     * @var value-of<OrderBy>|null $orderBy
     */
    #[Optional(enum: OrderBy::class)]
    public ?string $orderBy;

    /**
     * Opaque cursor from a previous response's `next_page` field.
     */
    #[Optional(nullable: true)]
    public ?string $page;

    /**
     * Product surfaces to include. Defaults to all products.
     *
     * @var list<value-of<AnalyticsProductFilter>>|null $products
     */
    #[Optional(list: AnalyticsProductFilter::class, nullable: true)]
    public ?array $products;

    /**
     * Filter to usage attributed to specific RBAC groups. Accepts tagged RBAC group IDs (`rbac_group_...`) or bare group UUIDs. A row matches when the user belonged to any of the listed groups on the (UTC) day the usage occurred; usage with no group attribution never matches.
     *
     * @var list<string>|null $rbacGroupIDs
     */
    #[Optional(list: 'string', nullable: true)]
    public ?array $rbacGroupIDs;

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
     * @var list<value-of<Speed>>|null $speeds
     */
    #[Optional(list: Speed::class, nullable: true)]
    public ?array $speeds;

    /**
     * Filter to specific users by tagged user ID.
     *
     * @var list<string>|null $userIDs
     */
    #[Optional(list: 'string', nullable: true)]
    public ?array $userIDs;

    /**
     * `new UserCostReportListParams()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * UserCostReportListParams::with(startingAt: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new UserCostReportListParams())->withStartingAt(...)
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
     * @param BucketWidth|value-of<BucketWidth>|null $bucketWidth
     * @param list<AnalyticsClaudeTagCategory|value-of<AnalyticsClaudeTagCategory>>|null $claudeTagCategories
     * @param list<string>|null $claudeTagUserIDs
     * @param list<AnalyticsContextWindow|value-of<AnalyticsContextWindow>>|null $contextWindows
     * @param list<GroupBy|value-of<GroupBy>>|null $groupBy
     * @param list<AnalyticsInferenceGeoFilter|value-of<AnalyticsInferenceGeoFilter>>|null $inferenceGeos
     * @param list<string>|null $models
     * @param Order|value-of<Order>|null $order
     * @param OrderBy|value-of<OrderBy>|null $orderBy
     * @param list<AnalyticsProductFilter|value-of<AnalyticsProductFilter>>|null $products
     * @param list<string>|null $rbacGroupIDs
     * @param list<string>|null $slackChannelIDs
     * @param list<Speed|value-of<Speed>>|null $speeds
     * @param list<string>|null $userIDs
     */
    public static function with(
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
    ): self {
        $self = new self;

        $self['startingAt'] = $startingAt;

        null !== $bucketWidth && $self['bucketWidth'] = $bucketWidth;
        null !== $claudeTagCategories && $self['claudeTagCategories'] = $claudeTagCategories;
        null !== $claudeTagUserIDs && $self['claudeTagUserIDs'] = $claudeTagUserIDs;
        null !== $contextWindows && $self['contextWindows'] = $contextWindows;
        null !== $endingAt && $self['endingAt'] = $endingAt;
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
        null !== $slackChannelIDs && $self['slackChannelIDs'] = $slackChannelIDs;
        null !== $speeds && $self['speeds'] = $speeds;
        null !== $userIDs && $self['userIDs'] = $userIDs;

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
     * Time-bucket granularity. When set, each row's `starting_at` and `ending_at` are populated and one actor may span several rows (one per time bucket with usage). The time bucket counts toward `limit`, so one page can return multiple rows for the same actor. `ending_at` is required when `bucket_width` is set, and with `bucket_width="1m"` the range may span at most 24 hours. When omitted, each row aggregates the full `[starting_at, ending_at)` range.
     *
     * @param BucketWidth|value-of<BucketWidth>|null $bucketWidth
     */
    public function withBucketWidth(BucketWidth|string|null $bucketWidth): self
    {
        $self = clone $this;
        $self['bucketWidth'] = $bucketWidth;

        return $self;
    }

    /**
     * Filter to Claude Tag (Claude in Slack) usage in specific spend categories. Usage with no category never matches. `dm` usage is reported under the user's product rather than `claude-tag`, so combining this filter with `products[]=claude-tag` excludes it. Use `group_by[]=claude_tag_category` to break out per-category values.
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
     * End of range, exclusive. When omitted, defaults to the earlier of now and `starting_at` + 31 days. The range may span at most 31 days.
     */
    public function withEndingAt(?\DateTimeInterface $endingAt): self
    {
        $self = clone $this;
        $self['endingAt'] = $endingAt;

        return $self;
    }

    /**
     * If true, omit rows for users who are deleted (`deleted: true`). A page may contain fewer than `limit` rows; use `has_more` and `next_page` to paginate as usual.
     */
    public function withExcludeDeletedUsers(bool $excludeDeletedUsers): self
    {
        $self = clone $this;
        $self['excludeDeletedUsers'] = $excludeDeletedUsers;

        return $self;
    }

    /**
     * Break each actor's row out by the given dimensions. Accepts the same values as the bucketed `/cost_report` endpoint. The `product`, `model`, `context_window`, `inference_geo`, and `speed` dimensions — and the time bucket, when `bucket_width` is set — count toward `limit`. `cost_type` and `token_type` do not: `cost_type` returns one row per cost component (tokens, web search, code execution); `token_type` returns one row per token type, each with `cost_type: "tokens"`; combining both returns the per-token-type rows plus the web-search and code-execution rows. A page can therefore contain more rows than `limit` when `cost_type` or `token_type` is requested.
     *
     * @param list<GroupBy|value-of<GroupBy>>|null $groupBy
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
     * Number of rows per page (1-1000, default 20). One row per actor unless `group_by[]` or `bucket_width` splits an actor across rows; `cost_type`/`token_type` fan-out rows (cost endpoint only) are the exception — they do not count toward this limit, so `data` can exceed it.
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
     * Sort direction. Defaults to `desc`.
     *
     * @param Order|value-of<Order> $order
     */
    public function withOrder(Order|string $order): self
    {
        $self = clone $this;
        $self['order'] = $order;

        return $self;
    }

    /**
     * Metric to rank actors by. Defaults to `amount`.
     *
     * @param OrderBy|value-of<OrderBy> $orderBy
     */
    public function withOrderBy(OrderBy|string $orderBy): self
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
     * @param list<AnalyticsProductFilter|value-of<AnalyticsProductFilter>>|null $products
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
     * @param list<Speed|value-of<Speed>>|null $speeds
     */
    public function withSpeeds(?array $speeds): self
    {
        $self = clone $this;
        $self['speeds'] = $speeds;

        return $self;
    }

    /**
     * Filter to specific users by tagged user ID.
     *
     * @param list<string>|null $userIDs
     */
    public function withUserIDs(?array $userIDs): self
    {
        $self = clone $this;
        $self['userIDs'] = $userIDs;

        return $self;
    }
}
