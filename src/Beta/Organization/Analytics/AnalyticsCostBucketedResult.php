<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Analytics;

use Anthropic\Beta\Organization\Analytics\AnalyticsCostBucketedResult\InferenceGeo;
use Anthropic\Beta\Organization\Analytics\AnalyticsCostBucketedResult\Speed;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type AnalyticsCostBucketedResultShape = array{
 *   amount: string,
 *   claudeTagCategory: null|AnalyticsClaudeTagCategory|value-of<AnalyticsClaudeTagCategory>,
 *   claudeTagUserID: string|null,
 *   contextWindow: null|AnalyticsContextWindow|value-of<AnalyticsContextWindow>,
 *   costType: null|AnalyticsCostType|value-of<AnalyticsCostType>,
 *   currency: string,
 *   inferenceGeo: null|InferenceGeo|value-of<InferenceGeo>,
 *   listAmount: string,
 *   model: string|null,
 *   product: string|null,
 *   rbacGroupID: string|null,
 *   requests: int|null,
 *   slackChannelID: string|null,
 *   speed: null|Speed|value-of<Speed>,
 *   tokenType: null|AnalyticsTokenType|value-of<AnalyticsTokenType>,
 * }
 */
final class AnalyticsCostBucketedResult implements BaseModel
{
    /** @use SdkModel<AnalyticsCostBucketedResultShape> */
    use SdkModel;

    /**
     * Amount (post-discount, pre-credit) in fractional cents.
     */
    #[Required]
    public string $amount;

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
     * Cost component when `group_by[]=cost_type`; null otherwise (amount is the combined total).
     *
     * @var value-of<AnalyticsCostType>|null $costType
     */
    #[Required('cost_type', enum: AnalyticsCostType::class)]
    public ?string $costType;

    /**
     * Currency code for the cost amount. Currently always `"USD"`.
     */
    #[Required]
    public string $currency;

    /**
     * Inference region of the usage or cost. Null unless `inference_geo` is in `group_by[]`; it can also be null on grouped rows where the region is not set (the rows that `inference_geos[]=not_available` matches).
     *
     * @var value-of<InferenceGeo>|null $inferenceGeo
     */
    #[Required('inference_geo', enum: InferenceGeo::class)]
    public ?string $inferenceGeo;

    /**
     * List-price amount (pre-discount) in fractional cents.
     */
    #[Required('list_amount')]
    public string $listAmount;

    /**
     * Model that produced the usage or cost, as a model name in the form the `models[]` filter accepts (for example, `claude-opus-5`). Null unless `model` is in `group_by[]`; it can also be null on grouped rows whose usage or cost is not attributed to a specific model, such as code execution.
     */
    #[Required]
    public ?string $model;

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
     * Number of API requests in this row's scope. Null when `group_by` includes `cost_type` or `token_type` (the count has no per-component attribution; read it from the ungrouped response). For sandbox / code-execution events, this counts execution spans rather than HTTP requests (these rows surface with `product: null`).
     */
    #[Required]
    public ?int $requests;

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
     * Token type when `group_by[]=token_type` and `cost_type=tokens`; null otherwise.
     *
     * @var value-of<AnalyticsTokenType>|null $tokenType
     */
    #[Required('token_type', enum: AnalyticsTokenType::class)]
    public ?string $tokenType;

    /**
     * `new AnalyticsCostBucketedResult()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * AnalyticsCostBucketedResult::with(
     *   amount: ...,
     *   claudeTagCategory: ...,
     *   claudeTagUserID: ...,
     *   contextWindow: ...,
     *   costType: ...,
     *   currency: ...,
     *   inferenceGeo: ...,
     *   listAmount: ...,
     *   model: ...,
     *   product: ...,
     *   rbacGroupID: ...,
     *   requests: ...,
     *   slackChannelID: ...,
     *   speed: ...,
     *   tokenType: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new AnalyticsCostBucketedResult)
     *   ->withAmount(...)
     *   ->withClaudeTagCategory(...)
     *   ->withClaudeTagUserID(...)
     *   ->withContextWindow(...)
     *   ->withCostType(...)
     *   ->withCurrency(...)
     *   ->withInferenceGeo(...)
     *   ->withListAmount(...)
     *   ->withModel(...)
     *   ->withProduct(...)
     *   ->withRBACGroupID(...)
     *   ->withRequests(...)
     *   ->withSlackChannelID(...)
     *   ->withSpeed(...)
     *   ->withTokenType(...)
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
     * @param AnalyticsClaudeTagCategory|value-of<AnalyticsClaudeTagCategory>|null $claudeTagCategory
     * @param AnalyticsContextWindow|value-of<AnalyticsContextWindow>|null $contextWindow
     * @param AnalyticsCostType|value-of<AnalyticsCostType>|null $costType
     * @param InferenceGeo|value-of<InferenceGeo>|null $inferenceGeo
     * @param Speed|value-of<Speed>|null $speed
     * @param AnalyticsTokenType|value-of<AnalyticsTokenType>|null $tokenType
     */
    public static function with(
        string $amount,
        AnalyticsClaudeTagCategory|string|null $claudeTagCategory,
        ?string $claudeTagUserID,
        AnalyticsContextWindow|string|null $contextWindow,
        AnalyticsCostType|string|null $costType,
        InferenceGeo|string|null $inferenceGeo,
        string $listAmount,
        ?string $model,
        ?string $product,
        ?string $rbacGroupID,
        ?int $requests,
        ?string $slackChannelID,
        Speed|string|null $speed,
        AnalyticsTokenType|string|null $tokenType,
        string $currency = 'USD',
    ): self {
        $self = new self;

        $self['amount'] = $amount;
        $self['claudeTagCategory'] = $claudeTagCategory;
        $self['claudeTagUserID'] = $claudeTagUserID;
        $self['contextWindow'] = $contextWindow;
        $self['costType'] = $costType;
        $self['currency'] = $currency;
        $self['inferenceGeo'] = $inferenceGeo;
        $self['listAmount'] = $listAmount;
        $self['model'] = $model;
        $self['product'] = $product;
        $self['rbacGroupID'] = $rbacGroupID;
        $self['requests'] = $requests;
        $self['slackChannelID'] = $slackChannelID;
        $self['speed'] = $speed;
        $self['tokenType'] = $tokenType;

        return $self;
    }

    /**
     * Amount (post-discount, pre-credit) in fractional cents.
     */
    public function withAmount(string $amount): self
    {
        $self = clone $this;
        $self['amount'] = $amount;

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
     * Cost component when `group_by[]=cost_type`; null otherwise (amount is the combined total).
     *
     * @param AnalyticsCostType|value-of<AnalyticsCostType>|null $costType
     */
    public function withCostType(AnalyticsCostType|string|null $costType): self
    {
        $self = clone $this;
        $self['costType'] = $costType;

        return $self;
    }

    /**
     * Currency code for the cost amount. Currently always `"USD"`.
     */
    public function withCurrency(string $currency): self
    {
        $self = clone $this;
        $self['currency'] = $currency;

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
     * List-price amount (pre-discount) in fractional cents.
     */
    public function withListAmount(string $listAmount): self
    {
        $self = clone $this;
        $self['listAmount'] = $listAmount;

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
     * Number of API requests in this row's scope. Null when `group_by` includes `cost_type` or `token_type` (the count has no per-component attribution; read it from the ungrouped response). For sandbox / code-execution events, this counts execution spans rather than HTTP requests (these rows surface with `product: null`).
     */
    public function withRequests(?int $requests): self
    {
        $self = clone $this;
        $self['requests'] = $requests;

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
     * Token type when `group_by[]=token_type` and `cost_type=tokens`; null otherwise.
     *
     * @param AnalyticsTokenType|value-of<AnalyticsTokenType>|null $tokenType
     */
    public function withTokenType(
        AnalyticsTokenType|string|null $tokenType
    ): self {
        $self = clone $this;
        $self['tokenType'] = $tokenType;

        return $self;
    }
}
