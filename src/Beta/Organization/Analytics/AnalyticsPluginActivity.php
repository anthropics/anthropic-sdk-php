<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Analytics;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Per-plugin install + invocation activity for a given day.
 *
 * With `group_by[]=user_id` / `rbac_group_id` / `product` (`cowork` /
 * `claude_code` only on this endpoint) each row is one (plugin, user),
 * (plugin, group), or (plugin, product) cut: the flat `user_id` /
 * `rbac_group_id` / `product` keys carry the cut and the counts are
 * scoped to it.
 *
 * @phpstan-import-type AnalyticsPluginClaudeCodeMetricsShape from \Anthropic\Beta\Organization\Analytics\AnalyticsPluginClaudeCodeMetrics
 * @phpstan-import-type AnalyticsPluginCoworkMetricsShape from \Anthropic\Beta\Organization\Analytics\AnalyticsPluginCoworkMetrics
 *
 * @phpstan-type AnalyticsPluginActivityShape = array{
 *   claudeCodeMetrics: AnalyticsPluginClaudeCodeMetrics|AnalyticsPluginClaudeCodeMetricsShape,
 *   coworkMetrics: AnalyticsPluginCoworkMetrics|AnalyticsPluginCoworkMetricsShape,
 *   distinctUserCount: int,
 *   installCount: int|null,
 *   invocationCount: int,
 *   pluginName: string,
 *   pluginID?: string|null,
 *   product?: string|null,
 *   rbacGroupID?: string|null,
 *   rbacGroupName?: string|null,
 *   userID?: string|null,
 * }
 */
final class AnalyticsPluginActivity implements BaseModel
{
    /** @use SdkModel<AnalyticsPluginActivityShape> */
    use SdkModel;

    /**
     * Claude Code activity metrics for a single plugin on a given day.
     */
    #[Required('claude_code_metrics')]
    public AnalyticsPluginClaudeCodeMetrics $claudeCodeMetrics;

    /**
     * Cowork activity metrics for a single plugin on a given day.
     */
    #[Required('cowork_metrics')]
    public AnalyticsPluginCoworkMetrics $coworkMetrics;

    /**
     * Number of distinct users with recorded install or invocation activity for the plugin on the requested day (install-only users count), or, in date-range mode, over the requested window — recomputed as an exact distinct count over the window's per-member daily rows, never a sum of per-day values.
     */
    #[Required('distinct_user_count')]
    public int $distinctUserCount;

    /**
     * Number of distinct users who installed the plugin on the requested day, or, in date-range mode, over the requested window — recomputed as an exact distinct count over the window's per-member daily rows, never a sum of per-day values.
     */
    #[Required('install_count')]
    public ?int $installCount;

    /**
     * Number of plugin invocations on the requested day.
     */
    #[Required('invocation_count')]
    public int $invocationCount;

    /**
     * Name of the plugin.
     */
    #[Required('plugin_name')]
    public string $pluginName;

    /**
     * Stable plugin identifier when available (e.g. `serena@claude-plugins-official`). Null for third-party Claude Code plugins (redacted at the source) and Cowork slash commands that carry only a hashed id.
     */
    #[Optional('plugin_id', nullable: true)]
    public ?string $pluginID;

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
     * Tagged user identifier (e.g. `user_...`). Present only when the request grouped by `user_id`.
     */
    #[Optional('user_id', nullable: true)]
    public ?string $userID;

    /**
     * `new AnalyticsPluginActivity()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * AnalyticsPluginActivity::with(
     *   claudeCodeMetrics: ...,
     *   coworkMetrics: ...,
     *   distinctUserCount: ...,
     *   installCount: ...,
     *   invocationCount: ...,
     *   pluginName: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new AnalyticsPluginActivity())
     *   ->withClaudeCodeMetrics(...)
     *   ->withCoworkMetrics(...)
     *   ->withDistinctUserCount(...)
     *   ->withInstallCount(...)
     *   ->withInvocationCount(...)
     *   ->withPluginName(...)
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
     * @param AnalyticsPluginClaudeCodeMetrics|AnalyticsPluginClaudeCodeMetricsShape $claudeCodeMetrics
     * @param AnalyticsPluginCoworkMetrics|AnalyticsPluginCoworkMetricsShape $coworkMetrics
     */
    public static function with(
        AnalyticsPluginClaudeCodeMetrics|array $claudeCodeMetrics,
        AnalyticsPluginCoworkMetrics|array $coworkMetrics,
        int $distinctUserCount,
        ?int $installCount,
        int $invocationCount,
        string $pluginName,
        ?string $pluginID = null,
        ?string $product = null,
        ?string $rbacGroupID = null,
        ?string $rbacGroupName = null,
        ?string $userID = null,
    ): self {
        $self = new self;

        $self['claudeCodeMetrics'] = $claudeCodeMetrics;
        $self['coworkMetrics'] = $coworkMetrics;
        $self['distinctUserCount'] = $distinctUserCount;
        $self['installCount'] = $installCount;
        $self['invocationCount'] = $invocationCount;
        $self['pluginName'] = $pluginName;

        null !== $pluginID && $self['pluginID'] = $pluginID;
        null !== $product && $self['product'] = $product;
        null !== $rbacGroupID && $self['rbacGroupID'] = $rbacGroupID;
        null !== $rbacGroupName && $self['rbacGroupName'] = $rbacGroupName;
        null !== $userID && $self['userID'] = $userID;

        return $self;
    }

    /**
     * Claude Code activity metrics for a single plugin on a given day.
     *
     * @param AnalyticsPluginClaudeCodeMetrics|AnalyticsPluginClaudeCodeMetricsShape $claudeCodeMetrics
     */
    public function withClaudeCodeMetrics(
        AnalyticsPluginClaudeCodeMetrics|array $claudeCodeMetrics
    ): self {
        $self = clone $this;
        $self['claudeCodeMetrics'] = $claudeCodeMetrics;

        return $self;
    }

    /**
     * Cowork activity metrics for a single plugin on a given day.
     *
     * @param AnalyticsPluginCoworkMetrics|AnalyticsPluginCoworkMetricsShape $coworkMetrics
     */
    public function withCoworkMetrics(
        AnalyticsPluginCoworkMetrics|array $coworkMetrics
    ): self {
        $self = clone $this;
        $self['coworkMetrics'] = $coworkMetrics;

        return $self;
    }

    /**
     * Number of distinct users with recorded install or invocation activity for the plugin on the requested day (install-only users count), or, in date-range mode, over the requested window — recomputed as an exact distinct count over the window's per-member daily rows, never a sum of per-day values.
     */
    public function withDistinctUserCount(int $distinctUserCount): self
    {
        $self = clone $this;
        $self['distinctUserCount'] = $distinctUserCount;

        return $self;
    }

    /**
     * Number of distinct users who installed the plugin on the requested day, or, in date-range mode, over the requested window — recomputed as an exact distinct count over the window's per-member daily rows, never a sum of per-day values.
     */
    public function withInstallCount(?int $installCount): self
    {
        $self = clone $this;
        $self['installCount'] = $installCount;

        return $self;
    }

    /**
     * Number of plugin invocations on the requested day.
     */
    public function withInvocationCount(int $invocationCount): self
    {
        $self = clone $this;
        $self['invocationCount'] = $invocationCount;

        return $self;
    }

    /**
     * Name of the plugin.
     */
    public function withPluginName(string $pluginName): self
    {
        $self = clone $this;
        $self['pluginName'] = $pluginName;

        return $self;
    }

    /**
     * Stable plugin identifier when available (e.g. `serena@claude-plugins-official`). Null for third-party Claude Code plugins (redacted at the source) and Cowork slash commands that carry only a hashed id.
     */
    public function withPluginID(?string $pluginID): self
    {
        $self = clone $this;
        $self['pluginID'] = $pluginID;

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
     * Tagged user identifier (e.g. `user_...`). Present only when the request grouped by `user_id`.
     */
    public function withUserID(?string $userID): self
    {
        $self = clone $this;
        $self['userID'] = $userID;

        return $self;
    }
}
