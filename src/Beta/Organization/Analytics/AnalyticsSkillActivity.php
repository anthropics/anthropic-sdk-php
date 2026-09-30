<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Analytics;

use Anthropic\Beta\Organization\Analytics\AnalyticsSkillActivity\ShareStatus;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Per-skill activity data for a given day.
 *
 * @phpstan-import-type AnalyticsSkillChatMetricsShape from \Anthropic\Beta\Organization\Analytics\AnalyticsSkillChatMetrics
 * @phpstan-import-type AnalyticsSkillClaudeCodeMetricsShape from \Anthropic\Beta\Organization\Analytics\AnalyticsSkillClaudeCodeMetrics
 * @phpstan-import-type AnalyticsSkillCoworkMetricsShape from \Anthropic\Beta\Organization\Analytics\AnalyticsSkillCoworkMetrics
 * @phpstan-import-type AnalyticsSkillOfficeMetricsShape from \Anthropic\Beta\Organization\Analytics\AnalyticsSkillOfficeMetrics
 *
 * @phpstan-type AnalyticsSkillActivityShape = array{
 *   chatMetrics: AnalyticsSkillChatMetrics|AnalyticsSkillChatMetricsShape,
 *   claudeCodeMetrics: AnalyticsSkillClaudeCodeMetrics|AnalyticsSkillClaudeCodeMetricsShape,
 *   coworkMetrics: AnalyticsSkillCoworkMetrics|AnalyticsSkillCoworkMetricsShape,
 *   distinctUserCount: int,
 *   officeMetrics: AnalyticsSkillOfficeMetrics|AnalyticsSkillOfficeMetricsShape,
 *   skillName: string,
 *   attributedListPrice?: string|null,
 *   currency?: string|null,
 *   enableCount?: int|null,
 *   estimatedOverageSpend?: string|null,
 *   invocationCount?: int|null,
 *   product?: string|null,
 *   rbacGroupID?: string|null,
 *   rbacGroupName?: string|null,
 *   shareStatus?: null|ShareStatus|value-of<ShareStatus>,
 *   skillDisplayName?: string|null,
 *   userID?: string|null,
 * }
 */
final class AnalyticsSkillActivity implements BaseModel
{
    /** @use SdkModel<AnalyticsSkillActivityShape> */
    use SdkModel;

    /**
     * Claude.ai activity metrics for a single skill on a given day.
     */
    #[Required('chat_metrics')]
    public AnalyticsSkillChatMetrics $chatMetrics;

    /**
     * Claude Code activity metrics for a single skill on a given day.
     */
    #[Required('claude_code_metrics')]
    public AnalyticsSkillClaudeCodeMetrics $claudeCodeMetrics;

    /**
     * Cowork activity metrics for a single skill on a given day.
     */
    #[Required('cowork_metrics')]
    public AnalyticsSkillCoworkMetrics $coworkMetrics;

    /**
     * Number of distinct users who used the skill on the requested day, or, in date-range mode, over the requested window — recomputed as an exact distinct count over the window's per-member daily rows, never a sum of per-day values. A skill counts as used only when it is explicitly activated — the model (or the user, via the skill's slash command) invokes it, reading its instructions into context as part of that activation. Skills that are merely installed or listed as available, or whose content reaches the context without an activation (preloaded, hook-injected, or read as a plain file), are not counted.
     */
    #[Required('distinct_user_count')]
    public int $distinctUserCount;

    /**
     * Office Agent activity metrics for a single skill on a given day, broken out by Office product.
     */
    #[Required('office_metrics')]
    public AnalyticsSkillOfficeMetrics $officeMetrics;

    /**
     * Name of the skill.
     */
    #[Required('skill_name')]
    public string $skillName;

    /**
     * List-price (rate-card) value of the member requests attributed to this skill, as a decimal string in the minor unit of `currency` (cents for USD), from Claude Code, Cowork, and Office Agent request-level attribution — the value of requests that involved the skill, not the skill's incremental cost. Unlike `estimated_overage_spend` this reflects usage value regardless of how it was funded — seat-covered usage counts — but it is undiscounted and does not tie to billed spend or the organization's spend reporting. claude.ai chat usage carries no request-level attribution and contributes nothing: the field is null on `chat` product rows and on `office_agent` product cuts dated before 2026-06-18 (the Office Agent attribution data-start), and on ungrouped rows it covers the Claude Code + Cowork + Office Agent share only (null when no attributable usage exists). Also null under the same conditions as `estimated_overage_spend` (spend reporting not enabled for this organization, `office_agent` product cuts before the 2026-06-18 data-start). "0" means attributable usage existed but none was attributed to this skill. Addable across days: date-range rollup mode returns the window's sum. On `group_by[]` and `filter[]` shapes both amounts can total below the ungrouped value for the same skill over the same date or range: spend attributed to a member–skill pair with no counted usage on that day is excluded from those cuts.
     */
    #[Optional('attributed_list_price', nullable: true)]
    public ?string $attributedListPrice;

    /**
     * Currency for this row's monetary fields (`estimated_overage_spend` and `attributed_list_price`), as an uppercase ISO-4217 code. Always "USD" when either amount is populated; null whenever both amounts are null.
     */
    #[Optional(nullable: true)]
    public ?string $currency;

    /**
     * Distinct accounts that enabled this skill on the requested day (claude.ai only — the skill analog of plugin `install_count`). The count is org-wide: null when enable reporting is not enabled for this organization, or when the request scopes to `user_id` / `rbac_group_id` / `product` via `group_by[]` or `filter[]` (an org-wide count would be misleading on per-cut rows). A distinct count, not an event count: summing across days double-counts members who enable the skill on more than one day, so it is also null in date-range rollup mode (`starting_date`/`ending_date`).
     */
    #[Optional('enable_count', nullable: true)]
    public ?int $enableCount;

    /**
     * Estimated overage spend attributed to this skill, as a decimal string in the minor unit of `currency` (cents for USD; "1250" is $12.50, fractional cents possible) — an allocation of each member's daily post-discount, pre-credit metered overage spend (the same cost basis as the organization's spend reporting and the Cost & Usage API, so per-skill figures are directly comparable; spend with no skill attribution — including any member-day without skill invocations — is not represented, so skill rows sum to at most those totals) across the skills the member used. Overage only: usage covered by included seat allowances bills nothing and allocates $0 here — see `attributed_list_price` for the funding-independent usage-value companion. Claude Code, Cowork, and Office Agent spend use request-level skill attribution; claude.ai chat spend is approximated proportionally to skill-invoking messages. An estimate, not a billing number — and the cost of the requests/messages that involved the skill, not the skill's incremental cost (the same request would still have cost something without the skill active). "0" means no overage spend was attributed; null when spend reporting is not enabled for this organization, on `office_agent` product cuts dated before 2026-06-18 (the Office Agent attribution data-start). Addable across days: date-range rollup mode (`starting_date`/`ending_date`) returns the window's sum. With `group_by[]=user_id` each row carries the user's own attributed spend. On `group_by[]` and `filter[]` shapes both amounts can total below the ungrouped value for the same skill over the same date or range: spend attributed to a member–skill pair with no counted usage on that day is excluded from those cuts.
     */
    #[Optional('estimated_overage_spend', nullable: true)]
    public ?string $estimatedOverageSpend;

    /**
     * Total number of times this skill was invoked on the requested day (the skill analog of plugin `invocation_count`). Unlike `distinct_user_count` — which answers '# of users' — this is the true '# of uses'. A skill counts as used only when it is explicitly activated — the model (or the user, via the skill's slash command) invokes it, reading its instructions into context as part of that activation. Skills that are merely installed or listed as available, or whose content reaches the context without an activation (preloaded, hook-injected, or read as a plain file), are not counted. Null when invocation reporting is not enabled for this organization. Sum across a date range for total uses in the window — date-range rollup mode (`starting_date`/`ending_date`) returns this sum directly.
     */
    #[Optional('invocation_count', nullable: true)]
    public ?int $invocationCount;

    /**
     * Product that produced this row's activity: one of `chat`, `claude_code`, `cowork`, or `office_agent` (the canonical Cost & Usage product naming; an `office_agent` row's per-surface breakdown is in its `office_metrics`). On `/plugins` only `cowork` and `claude_code` occur (the only surfaces with plugin attribution); on `/artifacts` only `chat`, `claude_code`, and `cowork` occur (the surfaces that create artifacts); `/apps/chat/projects` does not support the product dimension (a `product` entry in `group_by[]` or `filter[]` there is rejected). Present only when the request grouped by `product`.
     */
    #[Optional(nullable: true)]
    public ?string $product;

    /**
     * Tagged RBAC group identifier (`rbac_group_...`), matching the spend-limits API spelling. Present only when the request grouped by `rbac_group_id`.
     */
    #[Optional('rbac_group_id', nullable: true)]
    public ?string $rbacGroupID;

    /**
     * Resolved RBAC group display name, alongside `rbac_group_id` when name resolution is available. Null if the group has been deleted or its name could not be resolved; `rbac_group_id` remains the stable key.
     */
    #[Optional('rbac_group_name', nullable: true)]
    public ?string $rbacGroupName;

    /**
     * Skill share status (claude.ai only): one of `private`, `organization`, or `public`. Null for skills used only in Claude Code or Office (no per-skill share-status concept) and when share-status reporting is not yet available for the organization. Filterable via `filter[]=share_status:{value}`.
     *
     * @var value-of<ShareStatus>|null $shareStatus
     */
    #[Optional('share_status', enum: ShareStatus::class, nullable: true)]
    public ?string $shareStatus;

    /**
     * Human-readable display name for rows whose `skill_name` is an opaque skill id (user/organization skill types and plugin-delivered skills, whose user-defined names usage reports generally withhold). Organization-shared skills and skills delivered by the organization's own plugins (its plugin marketplaces and its library) resolve; plugin skill names are shown without their 'plugin:' prefix. The literal 'unknown' bucket row gets a fixed 'Unknown skill' label. For a member's own skill (private or personal-plugin) it is null, except when the skill's owner used it from Claude Code or Cowork in the requested period: then it shows the name that client reported at the time. Apart from that, the names of members' own skills are not disclosed to analytics-key holders. Also null for Anthropic-provided plugin skills (not resolved), for an organization skill or plugin whose name can no longer be found (for example, one since deleted), when `skill_name` is already a display name, or when display-name resolution is not enabled for this organization.
     */
    #[Optional('skill_display_name', nullable: true)]
    public ?string $skillDisplayName;

    /**
     * Tagged user identifier (e.g. `user_...`). Present only when the request grouped by `user_id`.
     */
    #[Optional('user_id', nullable: true)]
    public ?string $userID;

    /**
     * `new AnalyticsSkillActivity()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * AnalyticsSkillActivity::with(
     *   chatMetrics: ...,
     *   claudeCodeMetrics: ...,
     *   coworkMetrics: ...,
     *   distinctUserCount: ...,
     *   officeMetrics: ...,
     *   skillName: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new AnalyticsSkillActivity)
     *   ->withChatMetrics(...)
     *   ->withClaudeCodeMetrics(...)
     *   ->withCoworkMetrics(...)
     *   ->withDistinctUserCount(...)
     *   ->withOfficeMetrics(...)
     *   ->withSkillName(...)
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
     * @param AnalyticsSkillChatMetrics|AnalyticsSkillChatMetricsShape $chatMetrics
     * @param AnalyticsSkillClaudeCodeMetrics|AnalyticsSkillClaudeCodeMetricsShape $claudeCodeMetrics
     * @param AnalyticsSkillCoworkMetrics|AnalyticsSkillCoworkMetricsShape $coworkMetrics
     * @param AnalyticsSkillOfficeMetrics|AnalyticsSkillOfficeMetricsShape $officeMetrics
     * @param ShareStatus|value-of<ShareStatus>|null $shareStatus
     */
    public static function with(
        AnalyticsSkillChatMetrics|array $chatMetrics,
        AnalyticsSkillClaudeCodeMetrics|array $claudeCodeMetrics,
        AnalyticsSkillCoworkMetrics|array $coworkMetrics,
        int $distinctUserCount,
        AnalyticsSkillOfficeMetrics|array $officeMetrics,
        string $skillName,
        ?string $attributedListPrice = null,
        ?string $currency = null,
        ?int $enableCount = null,
        ?string $estimatedOverageSpend = null,
        ?int $invocationCount = null,
        ?string $product = null,
        ?string $rbacGroupID = null,
        ?string $rbacGroupName = null,
        ShareStatus|string|null $shareStatus = null,
        ?string $skillDisplayName = null,
        ?string $userID = null,
    ): self {
        $self = new self;

        $self['chatMetrics'] = $chatMetrics;
        $self['claudeCodeMetrics'] = $claudeCodeMetrics;
        $self['coworkMetrics'] = $coworkMetrics;
        $self['distinctUserCount'] = $distinctUserCount;
        $self['officeMetrics'] = $officeMetrics;
        $self['skillName'] = $skillName;

        null !== $attributedListPrice && $self['attributedListPrice'] = $attributedListPrice;
        null !== $currency && $self['currency'] = $currency;
        null !== $enableCount && $self['enableCount'] = $enableCount;
        null !== $estimatedOverageSpend && $self['estimatedOverageSpend'] = $estimatedOverageSpend;
        null !== $invocationCount && $self['invocationCount'] = $invocationCount;
        null !== $product && $self['product'] = $product;
        null !== $rbacGroupID && $self['rbacGroupID'] = $rbacGroupID;
        null !== $rbacGroupName && $self['rbacGroupName'] = $rbacGroupName;
        null !== $shareStatus && $self['shareStatus'] = $shareStatus;
        null !== $skillDisplayName && $self['skillDisplayName'] = $skillDisplayName;
        null !== $userID && $self['userID'] = $userID;

        return $self;
    }

    /**
     * Claude.ai activity metrics for a single skill on a given day.
     *
     * @param AnalyticsSkillChatMetrics|AnalyticsSkillChatMetricsShape $chatMetrics
     */
    public function withChatMetrics(
        AnalyticsSkillChatMetrics|array $chatMetrics
    ): self {
        $self = clone $this;
        $self['chatMetrics'] = $chatMetrics;

        return $self;
    }

    /**
     * Claude Code activity metrics for a single skill on a given day.
     *
     * @param AnalyticsSkillClaudeCodeMetrics|AnalyticsSkillClaudeCodeMetricsShape $claudeCodeMetrics
     */
    public function withClaudeCodeMetrics(
        AnalyticsSkillClaudeCodeMetrics|array $claudeCodeMetrics
    ): self {
        $self = clone $this;
        $self['claudeCodeMetrics'] = $claudeCodeMetrics;

        return $self;
    }

    /**
     * Cowork activity metrics for a single skill on a given day.
     *
     * @param AnalyticsSkillCoworkMetrics|AnalyticsSkillCoworkMetricsShape $coworkMetrics
     */
    public function withCoworkMetrics(
        AnalyticsSkillCoworkMetrics|array $coworkMetrics
    ): self {
        $self = clone $this;
        $self['coworkMetrics'] = $coworkMetrics;

        return $self;
    }

    /**
     * Number of distinct users who used the skill on the requested day, or, in date-range mode, over the requested window — recomputed as an exact distinct count over the window's per-member daily rows, never a sum of per-day values. A skill counts as used only when it is explicitly activated — the model (or the user, via the skill's slash command) invokes it, reading its instructions into context as part of that activation. Skills that are merely installed or listed as available, or whose content reaches the context without an activation (preloaded, hook-injected, or read as a plain file), are not counted.
     */
    public function withDistinctUserCount(int $distinctUserCount): self
    {
        $self = clone $this;
        $self['distinctUserCount'] = $distinctUserCount;

        return $self;
    }

    /**
     * Office Agent activity metrics for a single skill on a given day, broken out by Office product.
     *
     * @param AnalyticsSkillOfficeMetrics|AnalyticsSkillOfficeMetricsShape $officeMetrics
     */
    public function withOfficeMetrics(
        AnalyticsSkillOfficeMetrics|array $officeMetrics
    ): self {
        $self = clone $this;
        $self['officeMetrics'] = $officeMetrics;

        return $self;
    }

    /**
     * Name of the skill.
     */
    public function withSkillName(string $skillName): self
    {
        $self = clone $this;
        $self['skillName'] = $skillName;

        return $self;
    }

    /**
     * List-price (rate-card) value of the member requests attributed to this skill, as a decimal string in the minor unit of `currency` (cents for USD), from Claude Code, Cowork, and Office Agent request-level attribution — the value of requests that involved the skill, not the skill's incremental cost. Unlike `estimated_overage_spend` this reflects usage value regardless of how it was funded — seat-covered usage counts — but it is undiscounted and does not tie to billed spend or the organization's spend reporting. claude.ai chat usage carries no request-level attribution and contributes nothing: the field is null on `chat` product rows and on `office_agent` product cuts dated before 2026-06-18 (the Office Agent attribution data-start), and on ungrouped rows it covers the Claude Code + Cowork + Office Agent share only (null when no attributable usage exists). Also null under the same conditions as `estimated_overage_spend` (spend reporting not enabled for this organization, `office_agent` product cuts before the 2026-06-18 data-start). "0" means attributable usage existed but none was attributed to this skill. Addable across days: date-range rollup mode returns the window's sum. On `group_by[]` and `filter[]` shapes both amounts can total below the ungrouped value for the same skill over the same date or range: spend attributed to a member–skill pair with no counted usage on that day is excluded from those cuts.
     */
    public function withAttributedListPrice(?string $attributedListPrice): self
    {
        $self = clone $this;
        $self['attributedListPrice'] = $attributedListPrice;

        return $self;
    }

    /**
     * Currency for this row's monetary fields (`estimated_overage_spend` and `attributed_list_price`), as an uppercase ISO-4217 code. Always "USD" when either amount is populated; null whenever both amounts are null.
     */
    public function withCurrency(?string $currency): self
    {
        $self = clone $this;
        $self['currency'] = $currency;

        return $self;
    }

    /**
     * Distinct accounts that enabled this skill on the requested day (claude.ai only — the skill analog of plugin `install_count`). The count is org-wide: null when enable reporting is not enabled for this organization, or when the request scopes to `user_id` / `rbac_group_id` / `product` via `group_by[]` or `filter[]` (an org-wide count would be misleading on per-cut rows). A distinct count, not an event count: summing across days double-counts members who enable the skill on more than one day, so it is also null in date-range rollup mode (`starting_date`/`ending_date`).
     */
    public function withEnableCount(?int $enableCount): self
    {
        $self = clone $this;
        $self['enableCount'] = $enableCount;

        return $self;
    }

    /**
     * Estimated overage spend attributed to this skill, as a decimal string in the minor unit of `currency` (cents for USD; "1250" is $12.50, fractional cents possible) — an allocation of each member's daily post-discount, pre-credit metered overage spend (the same cost basis as the organization's spend reporting and the Cost & Usage API, so per-skill figures are directly comparable; spend with no skill attribution — including any member-day without skill invocations — is not represented, so skill rows sum to at most those totals) across the skills the member used. Overage only: usage covered by included seat allowances bills nothing and allocates $0 here — see `attributed_list_price` for the funding-independent usage-value companion. Claude Code, Cowork, and Office Agent spend use request-level skill attribution; claude.ai chat spend is approximated proportionally to skill-invoking messages. An estimate, not a billing number — and the cost of the requests/messages that involved the skill, not the skill's incremental cost (the same request would still have cost something without the skill active). "0" means no overage spend was attributed; null when spend reporting is not enabled for this organization, on `office_agent` product cuts dated before 2026-06-18 (the Office Agent attribution data-start). Addable across days: date-range rollup mode (`starting_date`/`ending_date`) returns the window's sum. With `group_by[]=user_id` each row carries the user's own attributed spend. On `group_by[]` and `filter[]` shapes both amounts can total below the ungrouped value for the same skill over the same date or range: spend attributed to a member–skill pair with no counted usage on that day is excluded from those cuts.
     */
    public function withEstimatedOverageSpend(
        ?string $estimatedOverageSpend
    ): self {
        $self = clone $this;
        $self['estimatedOverageSpend'] = $estimatedOverageSpend;

        return $self;
    }

    /**
     * Total number of times this skill was invoked on the requested day (the skill analog of plugin `invocation_count`). Unlike `distinct_user_count` — which answers '# of users' — this is the true '# of uses'. A skill counts as used only when it is explicitly activated — the model (or the user, via the skill's slash command) invokes it, reading its instructions into context as part of that activation. Skills that are merely installed or listed as available, or whose content reaches the context without an activation (preloaded, hook-injected, or read as a plain file), are not counted. Null when invocation reporting is not enabled for this organization. Sum across a date range for total uses in the window — date-range rollup mode (`starting_date`/`ending_date`) returns this sum directly.
     */
    public function withInvocationCount(?int $invocationCount): self
    {
        $self = clone $this;
        $self['invocationCount'] = $invocationCount;

        return $self;
    }

    /**
     * Product that produced this row's activity: one of `chat`, `claude_code`, `cowork`, or `office_agent` (the canonical Cost & Usage product naming; an `office_agent` row's per-surface breakdown is in its `office_metrics`). On `/plugins` only `cowork` and `claude_code` occur (the only surfaces with plugin attribution); on `/artifacts` only `chat`, `claude_code`, and `cowork` occur (the surfaces that create artifacts); `/apps/chat/projects` does not support the product dimension (a `product` entry in `group_by[]` or `filter[]` there is rejected). Present only when the request grouped by `product`.
     */
    public function withProduct(?string $product): self
    {
        $self = clone $this;
        $self['product'] = $product;

        return $self;
    }

    /**
     * Tagged RBAC group identifier (`rbac_group_...`), matching the spend-limits API spelling. Present only when the request grouped by `rbac_group_id`.
     */
    public function withRBACGroupID(?string $rbacGroupID): self
    {
        $self = clone $this;
        $self['rbacGroupID'] = $rbacGroupID;

        return $self;
    }

    /**
     * Resolved RBAC group display name, alongside `rbac_group_id` when name resolution is available. Null if the group has been deleted or its name could not be resolved; `rbac_group_id` remains the stable key.
     */
    public function withRBACGroupName(?string $rbacGroupName): self
    {
        $self = clone $this;
        $self['rbacGroupName'] = $rbacGroupName;

        return $self;
    }

    /**
     * Skill share status (claude.ai only): one of `private`, `organization`, or `public`. Null for skills used only in Claude Code or Office (no per-skill share-status concept) and when share-status reporting is not yet available for the organization. Filterable via `filter[]=share_status:{value}`.
     *
     * @param ShareStatus|value-of<ShareStatus>|null $shareStatus
     */
    public function withShareStatus(ShareStatus|string|null $shareStatus): self
    {
        $self = clone $this;
        $self['shareStatus'] = $shareStatus;

        return $self;
    }

    /**
     * Human-readable display name for rows whose `skill_name` is an opaque skill id (user/organization skill types and plugin-delivered skills, whose user-defined names usage reports generally withhold). Organization-shared skills and skills delivered by the organization's own plugins (its plugin marketplaces and its library) resolve; plugin skill names are shown without their 'plugin:' prefix. The literal 'unknown' bucket row gets a fixed 'Unknown skill' label. For a member's own skill (private or personal-plugin) it is null, except when the skill's owner used it from Claude Code or Cowork in the requested period: then it shows the name that client reported at the time. Apart from that, the names of members' own skills are not disclosed to analytics-key holders. Also null for Anthropic-provided plugin skills (not resolved), for an organization skill or plugin whose name can no longer be found (for example, one since deleted), when `skill_name` is already a display name, or when display-name resolution is not enabled for this organization.
     */
    public function withSkillDisplayName(?string $skillDisplayName): self
    {
        $self = clone $this;
        $self['skillDisplayName'] = $skillDisplayName;

        return $self;
    }

    /**
     * Tagged user identifier (e.g. `user_...`). Present only when the request grouped by `user_id`.
     */
    public function withUserID(?string $userID): self
    {
        $self = clone $this;
        $self['userID'] = $userID;

        return $self;
    }
}
