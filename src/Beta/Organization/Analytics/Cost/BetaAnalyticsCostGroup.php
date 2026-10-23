<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Analytics\Cost;

use Anthropic\Beta\Organization\Analytics\AnalyticsActor;
use Anthropic\Beta\Organization\Analytics\AnalyticsActorType;
use Anthropic\Beta\Organization\Analytics\AnalyticsAPIActor;
use Anthropic\Beta\Organization\Analytics\AnalyticsClaudeTagCategory;
use Anthropic\Beta\Organization\Analytics\AnalyticsContextWindow;
use Anthropic\Beta\Organization\Analytics\AnalyticsFederatedActor;
use Anthropic\Beta\Organization\Analytics\AnalyticsGroupedCostType;
use Anthropic\Beta\Organization\Analytics\AnalyticsReportUserActor;
use Anthropic\Beta\Organization\Analytics\AnalyticsServiceAccountActor;
use Anthropic\Beta\Organization\Analytics\AnalyticsServiceTier;
use Anthropic\Beta\Organization\Analytics\AnalyticsSpeed;
use Anthropic\Beta\Organization\Analytics\AnalyticsTokenType;
use Anthropic\Beta\Organization\Analytics\AnalyticsUsageCostInferenceGeo;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * The dimension values one cost row is broken out by, including
 * `cost_type` and `token_type`.
 *
 * @phpstan-import-type AnalyticsActorShape from \Anthropic\Beta\Organization\Analytics\AnalyticsActor
 * @phpstan-import-type AnalyticsActorVariants from \Anthropic\Beta\Organization\Analytics\AnalyticsActor
 *
 * @phpstan-type BetaAnalyticsCostGroupShape = array{
 *   actor: AnalyticsActorShape|null,
 *   actorType: null|AnalyticsActorType|value-of<AnalyticsActorType>,
 *   agentID: string|null,
 *   apiKeyID: string|null,
 *   claudeTagCategory: null|AnalyticsClaudeTagCategory|value-of<AnalyticsClaudeTagCategory>,
 *   claudeTagUserID: string|null,
 *   contextWindow: null|AnalyticsContextWindow|value-of<AnalyticsContextWindow>,
 *   costType: null|AnalyticsGroupedCostType|value-of<AnalyticsGroupedCostType>,
 *   deploymentID: string|null,
 *   environmentID: string|null,
 *   inferenceGeo: null|AnalyticsUsageCostInferenceGeo|value-of<AnalyticsUsageCostInferenceGeo>,
 *   model: string|null,
 *   product: string|null,
 *   rbacGroupID: string|null,
 *   serviceTier: null|AnalyticsServiceTier|value-of<AnalyticsServiceTier>,
 *   sessionID: string|null,
 *   slackChannelID: string|null,
 *   speed: null|AnalyticsSpeed|value-of<AnalyticsSpeed>,
 *   tokenType: null|AnalyticsTokenType|value-of<AnalyticsTokenType>,
 *   userProfileID: string|null,
 *   workspaceID: string|null,
 * }
 */
final class BetaAnalyticsCostGroup implements BaseModel
{
    /** @use SdkModel<BetaAnalyticsCostGroupShape> */
    use SdkModel;

    /**
     * The identity the usage is attributed to: the user if one is attributed, else the service account, else the federated (cloud-platform) identity, else the API key. Populated only when `actor` is in `group_by[]`; null for usage with no attributable identity, and for users' and federated identities' usage when the reader is a member who can see only some workspaces. Distinct identities the server cannot render also read null, each as its own row.
     *
     * @var AnalyticsActorVariants|null $actor
     */
    #[Required(union: AnalyticsActor::class)]
    public AnalyticsReportUserActor|AnalyticsServiceAccountActor|AnalyticsFederatedActor|AnalyticsAPIActor|null $actor;

    /**
     * Kind of identity the usage is attributed to; matches `actor.type` when `actor` is set. Populated only when `actor_type` is in `group_by[]`.
     *
     * @var value-of<AnalyticsActorType>|null $actorType
     */
    #[Required('actor_type', enum: AnalyticsActorType::class)]
    public ?string $actorType;

    /**
     * Claude Managed Agents agent whose session incurred the usage. Populated only when `agent_id` is in `group_by[]`; null for usage outside a managed session.
     */
    #[Required('agent_id')]
    public ?string $agentID;

    /**
     * API key that authenticated the requests, as a tagged API key ID, whichever identity `actor` resolves to. Populated only when `api_key_id` is in `group_by[]`; null for usage not authenticated by an API key.
     */
    #[Required('api_key_id')]
    public ?string $apiKeyID;

    /**
     * Claude Tag (Claude in Slack) spend category: `engaged` (a person addressed Claude in a channel or thread), `proactive` (Claude responded without being addressed), `scheduled` (a scheduled routine ran), `monitoring` (Claude watching a channel it was asked to monitor), or `dm` (direct messages with Claude). Populated only when `claude_tag_category` is in `group_by[]`; null for usage that is not Claude Tag. Direct-message usage is billed to the individual user and is reported under that user's product, not under `claude_tag`. New categories may be added over time.
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
     * Cost component breakdown; null when returning the combined total.
     *
     * @var value-of<AnalyticsGroupedCostType>|null $costType
     */
    #[Required('cost_type', enum: AnalyticsGroupedCostType::class)]
    public ?string $costType;

    /**
     * Deployment that started the Claude Managed Agents session. Populated only when `deployment_id` is in `group_by[]`; null for usage outside a managed session and for sessions no deployment started.
     */
    #[Required('deployment_id')]
    public ?string $deploymentID;

    /**
     * Claude Managed Agents environment the session ran in. Populated only when `environment_id` is in `group_by[]`; null for usage outside a managed session.
     */
    #[Required('environment_id')]
    public ?string $environmentID;

    /**
     * Inference region of the usage or cost. Null unless `inference_geo` is in `group_by[]`; it can also be null on grouped rows where the region is not set (the rows that `inference_geos[]=not_available` matches).
     *
     * @var value-of<AnalyticsUsageCostInferenceGeo>|null $inferenceGeo
     */
    #[Required('inference_geo', enum: AnalyticsUsageCostInferenceGeo::class)]
    public ?string $inferenceGeo;

    /**
     * Model that produced the usage or cost, as a model name in the form the `models[]` filter accepts (for example, `claude-opus-5-5`). Null unless `model` is in `group_by[]`; it can also be null on grouped rows whose usage or cost is not attributed to a specific model, such as code execution.
     */
    #[Required]
    public ?string $model;

    /**
     * Product surface that produced the usage or cost. Null unless product is in `group_by[]`; it can also be null on grouped rows whose usage cannot be attributed to a known surface. Values include `chat`, `claude_code`, `cowork`, `office_agent`, `claude_in_chrome`, `claude_design`, `claude_tag`, and `chat_cowork_unified`. `claude_tag` is Claude Tag, the Claude product in Slack. `chat_cowork_unified` is Chat and Cowork unified, Cowork's features inside claude.ai chat: chat and Cowork usage by a member who has it turned on is reported under this value instead of `chat` or `cowork`. It is accepted as a filter only on deployments that offer Chat and Cowork unified. Some unattributed usage is reported as "other".
     */
    #[Required]
    public ?string $product;

    /**
     * RBAC group (team) the usage is attributed to, in the public tagged `rbac_group_...` spelling — the same spelling the activity resources use for this key, so the same team has one id across resources and it round-trips as an `rbac_group_ids[]` filter value. Populated only when `rbac_group_id` is in `group_by[]`. Any-membership semantics: a user in several groups contributes their full usage to each of those groups' rows, so the named-group rows overlap and their sum can exceed the org total. A null value is the single unassigned row: users in no group on that (UTC) day. For the true org total, run the same query without `group_by[]`.
     */
    #[Required('rbac_group_id')]
    public ?string $rbacGroupID;

    /**
     * Service tier the usage was served at. Populated only when `service_tier` is in `group_by[]`; null for usage with no service tier (for example, code execution) and for Claude Enterprise usage.
     *
     * @var value-of<AnalyticsServiceTier>|null $serviceTier
     */
    #[Required('service_tier', enum: AnalyticsServiceTier::class)]
    public ?string $serviceTier;

    /**
     * Claude Managed Agents session that incurred the usage. Populated only when `session_id` is in `group_by[]`; null for usage outside a managed session.
     */
    #[Required('session_id')]
    public ?string $sessionID;

    /**
     * Slack channel the usage originated from. Populated only when `slack_channel_id` is in `group_by[]`; null for usage outside Slack (and for rows recorded before channel attribution was enabled).
     */
    #[Required('slack_channel_id')]
    public ?string $slackChannelID;

    /**
     * Inference speed mode of the usage or cost: `fast` or `standard`. Null unless `speed` is in `group_by[]`.
     *
     * @var value-of<AnalyticsSpeed>|null $speed
     */
    #[Required(enum: AnalyticsSpeed::class)]
    public ?string $speed;

    /**
     * Token type when `cost_type` is `tokens`; null otherwise.
     *
     * @var value-of<AnalyticsTokenType>|null $tokenType
     */
    #[Required('token_type', enum: AnalyticsTokenType::class)]
    public ?string $tokenType;

    /**
     * User profile the usage was attributed to, as a tagged `uprof_` ID. Populated only when `user_profile_id` is in `group_by[]`; null for usage that named no profile and for Claude Enterprise usage.
     */
    #[Required('user_profile_id')]
    public ?string $userProfileID;

    /**
     * Workspace the usage occurred in, as a tagged workspace ID, including the organization's default workspace. Populated only when `workspace_id` is in `group_by[]`; null for Claude Enterprise usage.
     */
    #[Required('workspace_id')]
    public ?string $workspaceID;

    /**
     * `new BetaAnalyticsCostGroup()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaAnalyticsCostGroup::with(
     *   actor: ...,
     *   actorType: ...,
     *   agentID: ...,
     *   apiKeyID: ...,
     *   claudeTagCategory: ...,
     *   claudeTagUserID: ...,
     *   contextWindow: ...,
     *   costType: ...,
     *   deploymentID: ...,
     *   environmentID: ...,
     *   inferenceGeo: ...,
     *   model: ...,
     *   product: ...,
     *   rbacGroupID: ...,
     *   serviceTier: ...,
     *   sessionID: ...,
     *   slackChannelID: ...,
     *   speed: ...,
     *   tokenType: ...,
     *   userProfileID: ...,
     *   workspaceID: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaAnalyticsCostGroup())
     *   ->withActor(...)
     *   ->withActorType(...)
     *   ->withAgentID(...)
     *   ->withAPIKeyID(...)
     *   ->withClaudeTagCategory(...)
     *   ->withClaudeTagUserID(...)
     *   ->withContextWindow(...)
     *   ->withCostType(...)
     *   ->withDeploymentID(...)
     *   ->withEnvironmentID(...)
     *   ->withInferenceGeo(...)
     *   ->withModel(...)
     *   ->withProduct(...)
     *   ->withRBACGroupID(...)
     *   ->withServiceTier(...)
     *   ->withSessionID(...)
     *   ->withSlackChannelID(...)
     *   ->withSpeed(...)
     *   ->withTokenType(...)
     *   ->withUserProfileID(...)
     *   ->withWorkspaceID(...)
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
     * @param AnalyticsActorShape|null $actor
     * @param AnalyticsActorType|value-of<AnalyticsActorType>|null $actorType
     * @param AnalyticsClaudeTagCategory|value-of<AnalyticsClaudeTagCategory>|null $claudeTagCategory
     * @param AnalyticsContextWindow|value-of<AnalyticsContextWindow>|null $contextWindow
     * @param AnalyticsGroupedCostType|value-of<AnalyticsGroupedCostType>|null $costType
     * @param AnalyticsUsageCostInferenceGeo|value-of<AnalyticsUsageCostInferenceGeo>|null $inferenceGeo
     * @param AnalyticsServiceTier|value-of<AnalyticsServiceTier>|null $serviceTier
     * @param AnalyticsSpeed|value-of<AnalyticsSpeed>|null $speed
     * @param AnalyticsTokenType|value-of<AnalyticsTokenType>|null $tokenType
     */
    public static function with(
        AnalyticsReportUserActor|array|AnalyticsServiceAccountActor|AnalyticsFederatedActor|AnalyticsAPIActor|null $actor,
        AnalyticsActorType|string|null $actorType,
        ?string $agentID,
        ?string $apiKeyID,
        AnalyticsClaudeTagCategory|string|null $claudeTagCategory,
        ?string $claudeTagUserID,
        AnalyticsContextWindow|string|null $contextWindow,
        AnalyticsGroupedCostType|string|null $costType,
        ?string $deploymentID,
        ?string $environmentID,
        AnalyticsUsageCostInferenceGeo|string|null $inferenceGeo,
        ?string $model,
        ?string $product,
        ?string $rbacGroupID,
        AnalyticsServiceTier|string|null $serviceTier,
        ?string $sessionID,
        ?string $slackChannelID,
        AnalyticsSpeed|string|null $speed,
        AnalyticsTokenType|string|null $tokenType,
        ?string $userProfileID,
        ?string $workspaceID,
    ): self {
        $self = new self;

        $self['actor'] = $actor;
        $self['actorType'] = $actorType;
        $self['agentID'] = $agentID;
        $self['apiKeyID'] = $apiKeyID;
        $self['claudeTagCategory'] = $claudeTagCategory;
        $self['claudeTagUserID'] = $claudeTagUserID;
        $self['contextWindow'] = $contextWindow;
        $self['costType'] = $costType;
        $self['deploymentID'] = $deploymentID;
        $self['environmentID'] = $environmentID;
        $self['inferenceGeo'] = $inferenceGeo;
        $self['model'] = $model;
        $self['product'] = $product;
        $self['rbacGroupID'] = $rbacGroupID;
        $self['serviceTier'] = $serviceTier;
        $self['sessionID'] = $sessionID;
        $self['slackChannelID'] = $slackChannelID;
        $self['speed'] = $speed;
        $self['tokenType'] = $tokenType;
        $self['userProfileID'] = $userProfileID;
        $self['workspaceID'] = $workspaceID;

        return $self;
    }

    /**
     * The identity the usage is attributed to: the user if one is attributed, else the service account, else the federated (cloud-platform) identity, else the API key. Populated only when `actor` is in `group_by[]`; null for usage with no attributable identity, and for users' and federated identities' usage when the reader is a member who can see only some workspaces. Distinct identities the server cannot render also read null, each as its own row.
     *
     * @param AnalyticsActorShape|null $actor
     */
    public function withActor(
        AnalyticsReportUserActor|array|AnalyticsServiceAccountActor|AnalyticsFederatedActor|AnalyticsAPIActor|null $actor,
    ): self {
        $self = clone $this;
        $self['actor'] = $actor;

        return $self;
    }

    /**
     * Kind of identity the usage is attributed to; matches `actor.type` when `actor` is set. Populated only when `actor_type` is in `group_by[]`.
     *
     * @param AnalyticsActorType|value-of<AnalyticsActorType>|null $actorType
     */
    public function withActorType(
        AnalyticsActorType|string|null $actorType
    ): self {
        $self = clone $this;
        $self['actorType'] = $actorType;

        return $self;
    }

    /**
     * Claude Managed Agents agent whose session incurred the usage. Populated only when `agent_id` is in `group_by[]`; null for usage outside a managed session.
     */
    public function withAgentID(?string $agentID): self
    {
        $self = clone $this;
        $self['agentID'] = $agentID;

        return $self;
    }

    /**
     * API key that authenticated the requests, as a tagged API key ID, whichever identity `actor` resolves to. Populated only when `api_key_id` is in `group_by[]`; null for usage not authenticated by an API key.
     */
    public function withAPIKeyID(?string $apiKeyID): self
    {
        $self = clone $this;
        $self['apiKeyID'] = $apiKeyID;

        return $self;
    }

    /**
     * Claude Tag (Claude in Slack) spend category: `engaged` (a person addressed Claude in a channel or thread), `proactive` (Claude responded without being addressed), `scheduled` (a scheduled routine ran), `monitoring` (Claude watching a channel it was asked to monitor), or `dm` (direct messages with Claude). Populated only when `claude_tag_category` is in `group_by[]`; null for usage that is not Claude Tag. Direct-message usage is billed to the individual user and is reported under that user's product, not under `claude_tag`. New categories may be added over time.
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
     * Cost component breakdown; null when returning the combined total.
     *
     * @param AnalyticsGroupedCostType|value-of<AnalyticsGroupedCostType>|null $costType
     */
    public function withCostType(
        AnalyticsGroupedCostType|string|null $costType
    ): self {
        $self = clone $this;
        $self['costType'] = $costType;

        return $self;
    }

    /**
     * Deployment that started the Claude Managed Agents session. Populated only when `deployment_id` is in `group_by[]`; null for usage outside a managed session and for sessions no deployment started.
     */
    public function withDeploymentID(?string $deploymentID): self
    {
        $self = clone $this;
        $self['deploymentID'] = $deploymentID;

        return $self;
    }

    /**
     * Claude Managed Agents environment the session ran in. Populated only when `environment_id` is in `group_by[]`; null for usage outside a managed session.
     */
    public function withEnvironmentID(?string $environmentID): self
    {
        $self = clone $this;
        $self['environmentID'] = $environmentID;

        return $self;
    }

    /**
     * Inference region of the usage or cost. Null unless `inference_geo` is in `group_by[]`; it can also be null on grouped rows where the region is not set (the rows that `inference_geos[]=not_available` matches).
     *
     * @param AnalyticsUsageCostInferenceGeo|value-of<AnalyticsUsageCostInferenceGeo>|null $inferenceGeo
     */
    public function withInferenceGeo(
        AnalyticsUsageCostInferenceGeo|string|null $inferenceGeo
    ): self {
        $self = clone $this;
        $self['inferenceGeo'] = $inferenceGeo;

        return $self;
    }

    /**
     * Model that produced the usage or cost, as a model name in the form the `models[]` filter accepts (for example, `claude-opus-5-5`). Null unless `model` is in `group_by[]`; it can also be null on grouped rows whose usage or cost is not attributed to a specific model, such as code execution.
     */
    public function withModel(?string $model): self
    {
        $self = clone $this;
        $self['model'] = $model;

        return $self;
    }

    /**
     * Product surface that produced the usage or cost. Null unless product is in `group_by[]`; it can also be null on grouped rows whose usage cannot be attributed to a known surface. Values include `chat`, `claude_code`, `cowork`, `office_agent`, `claude_in_chrome`, `claude_design`, `claude_tag`, and `chat_cowork_unified`. `claude_tag` is Claude Tag, the Claude product in Slack. `chat_cowork_unified` is Chat and Cowork unified, Cowork's features inside claude.ai chat: chat and Cowork usage by a member who has it turned on is reported under this value instead of `chat` or `cowork`. It is accepted as a filter only on deployments that offer Chat and Cowork unified. Some unattributed usage is reported as "other".
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
     * Service tier the usage was served at. Populated only when `service_tier` is in `group_by[]`; null for usage with no service tier (for example, code execution) and for Claude Enterprise usage.
     *
     * @param AnalyticsServiceTier|value-of<AnalyticsServiceTier>|null $serviceTier
     */
    public function withServiceTier(
        AnalyticsServiceTier|string|null $serviceTier
    ): self {
        $self = clone $this;
        $self['serviceTier'] = $serviceTier;

        return $self;
    }

    /**
     * Claude Managed Agents session that incurred the usage. Populated only when `session_id` is in `group_by[]`; null for usage outside a managed session.
     */
    public function withSessionID(?string $sessionID): self
    {
        $self = clone $this;
        $self['sessionID'] = $sessionID;

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
     * @param AnalyticsSpeed|value-of<AnalyticsSpeed>|null $speed
     */
    public function withSpeed(AnalyticsSpeed|string|null $speed): self
    {
        $self = clone $this;
        $self['speed'] = $speed;

        return $self;
    }

    /**
     * Token type when `cost_type` is `tokens`; null otherwise.
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

    /**
     * User profile the usage was attributed to, as a tagged `uprof_` ID. Populated only when `user_profile_id` is in `group_by[]`; null for usage that named no profile and for Claude Enterprise usage.
     */
    public function withUserProfileID(?string $userProfileID): self
    {
        $self = clone $this;
        $self['userProfileID'] = $userProfileID;

        return $self;
    }

    /**
     * Workspace the usage occurred in, as a tagged workspace ID, including the organization's default workspace. Populated only when `workspace_id` is in `group_by[]`; null for Claude Enterprise usage.
     */
    public function withWorkspaceID(?string $workspaceID): self
    {
        $self = clone $this;
        $self['workspaceID'] = $workspaceID;

        return $self;
    }
}
