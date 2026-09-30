<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Analytics;

use Anthropic\Beta\Messages\BetaCacheCreation;
use Anthropic\Beta\Organization\Analytics\AnalyticsUsageBucketedResult\InferenceGeo;
use Anthropic\Beta\Organization\Analytics\AnalyticsUsageBucketedResult\Speed;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type BetaCacheCreationShape from \Anthropic\Beta\Messages\BetaCacheCreation
 * @phpstan-import-type AnalyticsServerToolUseShape from \Anthropic\Beta\Organization\Analytics\AnalyticsServerToolUse
 *
 * @phpstan-type AnalyticsUsageBucketedResultShape = array{
 *   cacheCreation: BetaCacheCreation|BetaCacheCreationShape,
 *   cacheReadInputTokens: int,
 *   claudeTagCategory: null|AnalyticsClaudeTagCategory|value-of<AnalyticsClaudeTagCategory>,
 *   claudeTagUserID: string|null,
 *   contextWindow: null|AnalyticsContextWindow|value-of<AnalyticsContextWindow>,
 *   inferenceGeo: null|InferenceGeo|value-of<InferenceGeo>,
 *   model: string|null,
 *   outputTokens: int,
 *   product: string|null,
 *   rbacGroupID: string|null,
 *   requests: int|null,
 *   serverToolUse: AnalyticsServerToolUse|AnalyticsServerToolUseShape,
 *   slackChannelID: string|null,
 *   speed: null|Speed|value-of<Speed>,
 *   uncachedInputTokens: int,
 * }
 */
final class AnalyticsUsageBucketedResult implements BaseModel
{
    /** @use SdkModel<AnalyticsUsageBucketedResultShape> */
    use SdkModel;

    /**
     * The number of input tokens for cache creation.
     */
    #[Required('cache_creation')]
    public BetaCacheCreation $cacheCreation;

    /**
     * The number of input tokens read from the cache.
     */
    #[Required('cache_read_input_tokens')]
    public int $cacheReadInputTokens;

    /**
     * Claude Tag (Claude in Slack) spend category: `engaged` (a person addressed Claude in a channel or thread), `proactive` (Claude responded without being addressed), `scheduled` (a scheduled routine ran), `monitoring` (Claude watching a channel it was asked to monitor), or `dm` (direct messages with Claude). Populated only when `claude_tag_category` is in `group_by[]`; null for usage that is not Claude Tag. Direct-message usage is billed to the individual user and is reported under that user's product, not under `claude-tag`. New categories may be added over time.
     *
     * @var value-of<AnalyticsClaudeTagCategory>|null $claudeTagCategory
     */
    #[Required('claude_tag_category', enum: AnalyticsClaudeTagCategory::class)]
    public ?string $claudeTagCategory;

    /**
     * Slack user ID (for example `U0123ABCDEF`) of the member the Claude Tag (Claude in Slack) usage is attributed to, not a claude.ai user ID. Populated only when `claude_tag_user_id` is in `group_by[]`; null for usage that is not Claude Tag and for Claude Tag usage that is not attributed to a single user (for example `monitoring`, and `proactive` usage Claude initiated), so per-user rows can sum to less than the Claude Tag total. Cannot be combined with `group_by[]=rbac_group_id` or the `rbac_group_ids[]` filter.
     */
    #[Required('claude_tag_user_id')]
    public ?string $claudeTagUserID;

    /**
     * Context-window pricing tier of the usage or cost. Null unless `context_window` is in `group_by[]`; it can also be null on grouped rows with no context-window tier, such as code execution.
     *
     * @var value-of<AnalyticsContextWindow>|null $contextWindow
     */
    #[Required('context_window', enum: AnalyticsContextWindow::class)]
    public ?string $contextWindow;

    /**
     * Inference region of the usage or cost. Null unless `inference_geo` is in `group_by[]`; it can also be null on grouped rows where the region is not set (the rows that `inference_geos[]=not_available` matches).
     *
     * @var value-of<InferenceGeo>|null $inferenceGeo
     */
    #[Required('inference_geo', enum: InferenceGeo::class)]
    public ?string $inferenceGeo;

    /**
     * Model that produced the usage or cost, as a model name in the form the `models[]` filter accepts (for example, `claude-opus-5`). Null unless `model` is in `group_by[]`; it can also be null on grouped rows whose usage or cost is not attributed to a specific model, such as code execution.
     */
    #[Required]
    public ?string $model;

    /**
     * The number of output tokens generated.
     */
    #[Required('output_tokens')]
    public int $outputTokens;

    /**
     * Product surface that produced the usage or cost. Null unless product is in `group_by[]`; it can also be null on grouped rows whose usage cannot be attributed to a known surface. Values include `chat`, `claude_code`, `cowork`, `office_agent`, `claude_in_chrome`, `claude_design`, and `claude-tag`. `claude-tag` is Claude Tag, the Claude product in Slack. Some unattributed usage is reported as "other".
     */
    #[Required]
    public ?string $product;

    /**
     * RBAC group (team) the usage is attributed to, in the public tagged `rbac_group_...` spelling — the same spelling the activity resources use for this key, so the same team has one id across resources and it round-trips as an `rbac_group_ids[]` filter value. Populated only when `rbac_group_id` is in `group_by[]`. Any-membership semantics: a user in several groups contributes their full usage to each of those groups' rows, so the named-group rows overlap and their sum can exceed the org total. A null value is the single unassigned row: users in no group on that (UTC) day. For the true org total, run the same query without `group_by[]`.
     */
    #[Required('rbac_group_id')]
    public ?string $rbacGroupID;

    /**
     * Number of API requests in this row's scope. For sandbox / code-execution events, this counts execution spans rather than HTTP requests (these rows surface with `product: null`).
     */
    #[Required]
    public ?int $requests;

    /**
     * Server-side tool usage metrics.
     */
    #[Required('server_tool_use')]
    public AnalyticsServerToolUse $serverToolUse;

    /**
     * Slack channel the usage originated from. Populated only when `slack_channel_id` is in `group_by[]`; null for usage outside Slack (and for rows recorded before channel attribution was enabled).
     */
    #[Required('slack_channel_id')]
    public ?string $slackChannelID;

    /**
     * Inference speed mode of the usage or cost: `fast` or `standard`. Null unless `speed` is in `group_by[]`.
     *
     * @var value-of<Speed>|null $speed
     */
    #[Required(enum: Speed::class)]
    public ?string $speed;

    /**
     * The number of uncached input tokens processed.
     */
    #[Required('uncached_input_tokens')]
    public int $uncachedInputTokens;

    /**
     * `new AnalyticsUsageBucketedResult()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * AnalyticsUsageBucketedResult::with(
     *   cacheCreation: ...,
     *   cacheReadInputTokens: ...,
     *   claudeTagCategory: ...,
     *   claudeTagUserID: ...,
     *   contextWindow: ...,
     *   inferenceGeo: ...,
     *   model: ...,
     *   outputTokens: ...,
     *   product: ...,
     *   rbacGroupID: ...,
     *   requests: ...,
     *   serverToolUse: ...,
     *   slackChannelID: ...,
     *   speed: ...,
     *   uncachedInputTokens: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new AnalyticsUsageBucketedResult)
     *   ->withCacheCreation(...)
     *   ->withCacheReadInputTokens(...)
     *   ->withClaudeTagCategory(...)
     *   ->withClaudeTagUserID(...)
     *   ->withContextWindow(...)
     *   ->withInferenceGeo(...)
     *   ->withModel(...)
     *   ->withOutputTokens(...)
     *   ->withProduct(...)
     *   ->withRBACGroupID(...)
     *   ->withRequests(...)
     *   ->withServerToolUse(...)
     *   ->withSlackChannelID(...)
     *   ->withSpeed(...)
     *   ->withUncachedInputTokens(...)
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
     * @param BetaCacheCreation|BetaCacheCreationShape $cacheCreation
     * @param AnalyticsClaudeTagCategory|value-of<AnalyticsClaudeTagCategory>|null $claudeTagCategory
     * @param AnalyticsContextWindow|value-of<AnalyticsContextWindow>|null $contextWindow
     * @param InferenceGeo|value-of<InferenceGeo>|null $inferenceGeo
     * @param AnalyticsServerToolUse|AnalyticsServerToolUseShape $serverToolUse
     * @param Speed|value-of<Speed>|null $speed
     */
    public static function with(
        BetaCacheCreation|array $cacheCreation,
        int $cacheReadInputTokens,
        AnalyticsClaudeTagCategory|string|null $claudeTagCategory,
        ?string $claudeTagUserID,
        AnalyticsContextWindow|string|null $contextWindow,
        InferenceGeo|string|null $inferenceGeo,
        ?string $model,
        int $outputTokens,
        ?string $product,
        ?string $rbacGroupID,
        ?int $requests,
        AnalyticsServerToolUse|array $serverToolUse,
        ?string $slackChannelID,
        Speed|string|null $speed,
        int $uncachedInputTokens,
    ): self {
        $self = new self;

        $self['cacheCreation'] = $cacheCreation;
        $self['cacheReadInputTokens'] = $cacheReadInputTokens;
        $self['claudeTagCategory'] = $claudeTagCategory;
        $self['claudeTagUserID'] = $claudeTagUserID;
        $self['contextWindow'] = $contextWindow;
        $self['inferenceGeo'] = $inferenceGeo;
        $self['model'] = $model;
        $self['outputTokens'] = $outputTokens;
        $self['product'] = $product;
        $self['rbacGroupID'] = $rbacGroupID;
        $self['requests'] = $requests;
        $self['serverToolUse'] = $serverToolUse;
        $self['slackChannelID'] = $slackChannelID;
        $self['speed'] = $speed;
        $self['uncachedInputTokens'] = $uncachedInputTokens;

        return $self;
    }

    /**
     * The number of input tokens for cache creation.
     *
     * @param BetaCacheCreation|BetaCacheCreationShape $cacheCreation
     */
    public function withCacheCreation(
        BetaCacheCreation|array $cacheCreation
    ): self {
        $self = clone $this;
        $self['cacheCreation'] = $cacheCreation;

        return $self;
    }

    /**
     * The number of input tokens read from the cache.
     */
    public function withCacheReadInputTokens(int $cacheReadInputTokens): self
    {
        $self = clone $this;
        $self['cacheReadInputTokens'] = $cacheReadInputTokens;

        return $self;
    }

    /**
     * Claude Tag (Claude in Slack) spend category: `engaged` (a person addressed Claude in a channel or thread), `proactive` (Claude responded without being addressed), `scheduled` (a scheduled routine ran), `monitoring` (Claude watching a channel it was asked to monitor), or `dm` (direct messages with Claude). Populated only when `claude_tag_category` is in `group_by[]`; null for usage that is not Claude Tag. Direct-message usage is billed to the individual user and is reported under that user's product, not under `claude-tag`. New categories may be added over time.
     *
     * @param AnalyticsClaudeTagCategory|value-of<AnalyticsClaudeTagCategory>|null $claudeTagCategory
     */
    public function withClaudeTagCategory(
        AnalyticsClaudeTagCategory|string|null $claudeTagCategory
    ): self {
        $self = clone $this;
        $self['claudeTagCategory'] = $claudeTagCategory;

        return $self;
    }

    /**
     * Slack user ID (for example `U0123ABCDEF`) of the member the Claude Tag (Claude in Slack) usage is attributed to, not a claude.ai user ID. Populated only when `claude_tag_user_id` is in `group_by[]`; null for usage that is not Claude Tag and for Claude Tag usage that is not attributed to a single user (for example `monitoring`, and `proactive` usage Claude initiated), so per-user rows can sum to less than the Claude Tag total. Cannot be combined with `group_by[]=rbac_group_id` or the `rbac_group_ids[]` filter.
     */
    public function withClaudeTagUserID(?string $claudeTagUserID): self
    {
        $self = clone $this;
        $self['claudeTagUserID'] = $claudeTagUserID;

        return $self;
    }

    /**
     * Context-window pricing tier of the usage or cost. Null unless `context_window` is in `group_by[]`; it can also be null on grouped rows with no context-window tier, such as code execution.
     *
     * @param AnalyticsContextWindow|value-of<AnalyticsContextWindow>|null $contextWindow
     */
    public function withContextWindow(
        AnalyticsContextWindow|string|null $contextWindow
    ): self {
        $self = clone $this;
        $self['contextWindow'] = $contextWindow;

        return $self;
    }

    /**
     * Inference region of the usage or cost. Null unless `inference_geo` is in `group_by[]`; it can also be null on grouped rows where the region is not set (the rows that `inference_geos[]=not_available` matches).
     *
     * @param InferenceGeo|value-of<InferenceGeo>|null $inferenceGeo
     */
    public function withInferenceGeo(
        InferenceGeo|string|null $inferenceGeo
    ): self {
        $self = clone $this;
        $self['inferenceGeo'] = $inferenceGeo;

        return $self;
    }

    /**
     * Model that produced the usage or cost, as a model name in the form the `models[]` filter accepts (for example, `claude-opus-5`). Null unless `model` is in `group_by[]`; it can also be null on grouped rows whose usage or cost is not attributed to a specific model, such as code execution.
     */
    public function withModel(?string $model): self
    {
        $self = clone $this;
        $self['model'] = $model;

        return $self;
    }

    /**
     * The number of output tokens generated.
     */
    public function withOutputTokens(int $outputTokens): self
    {
        $self = clone $this;
        $self['outputTokens'] = $outputTokens;

        return $self;
    }

    /**
     * Product surface that produced the usage or cost. Null unless product is in `group_by[]`; it can also be null on grouped rows whose usage cannot be attributed to a known surface. Values include `chat`, `claude_code`, `cowork`, `office_agent`, `claude_in_chrome`, `claude_design`, and `claude-tag`. `claude-tag` is Claude Tag, the Claude product in Slack. Some unattributed usage is reported as "other".
     */
    public function withProduct(?string $product): self
    {
        $self = clone $this;
        $self['product'] = $product;

        return $self;
    }

    /**
     * RBAC group (team) the usage is attributed to, in the public tagged `rbac_group_...` spelling — the same spelling the activity resources use for this key, so the same team has one id across resources and it round-trips as an `rbac_group_ids[]` filter value. Populated only when `rbac_group_id` is in `group_by[]`. Any-membership semantics: a user in several groups contributes their full usage to each of those groups' rows, so the named-group rows overlap and their sum can exceed the org total. A null value is the single unassigned row: users in no group on that (UTC) day. For the true org total, run the same query without `group_by[]`.
     */
    public function withRBACGroupID(?string $rbacGroupID): self
    {
        $self = clone $this;
        $self['rbacGroupID'] = $rbacGroupID;

        return $self;
    }

    /**
     * Number of API requests in this row's scope. For sandbox / code-execution events, this counts execution spans rather than HTTP requests (these rows surface with `product: null`).
     */
    public function withRequests(?int $requests): self
    {
        $self = clone $this;
        $self['requests'] = $requests;

        return $self;
    }

    /**
     * Server-side tool usage metrics.
     *
     * @param AnalyticsServerToolUse|AnalyticsServerToolUseShape $serverToolUse
     */
    public function withServerToolUse(
        AnalyticsServerToolUse|array $serverToolUse
    ): self {
        $self = clone $this;
        $self['serverToolUse'] = $serverToolUse;

        return $self;
    }

    /**
     * Slack channel the usage originated from. Populated only when `slack_channel_id` is in `group_by[]`; null for usage outside Slack (and for rows recorded before channel attribution was enabled).
     */
    public function withSlackChannelID(?string $slackChannelID): self
    {
        $self = clone $this;
        $self['slackChannelID'] = $slackChannelID;

        return $self;
    }

    /**
     * Inference speed mode of the usage or cost: `fast` or `standard`. Null unless `speed` is in `group_by[]`.
     *
     * @param Speed|value-of<Speed>|null $speed
     */
    public function withSpeed(Speed|string|null $speed): self
    {
        $self = clone $this;
        $self['speed'] = $speed;

        return $self;
    }

    /**
     * The number of uncached input tokens processed.
     */
    public function withUncachedInputTokens(int $uncachedInputTokens): self
    {
        $self = clone $this;
        $self['uncachedInputTokens'] = $uncachedInputTokens;

        return $self;
    }
}
