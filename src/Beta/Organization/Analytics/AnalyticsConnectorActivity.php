<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Analytics;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Per-connector activity data for a given day.
 *
 * @phpstan-import-type AnalyticsConnectorChatMetricsShape from \Anthropic\Beta\Organization\Analytics\AnalyticsConnectorChatMetrics
 * @phpstan-import-type AnalyticsConnectorClaudeCodeMetricsShape from \Anthropic\Beta\Organization\Analytics\AnalyticsConnectorClaudeCodeMetrics
 * @phpstan-import-type AnalyticsConnectorCoworkMetricsShape from \Anthropic\Beta\Organization\Analytics\AnalyticsConnectorCoworkMetrics
 * @phpstan-import-type AnalyticsConnectorOfficeMetricsShape from \Anthropic\Beta\Organization\Analytics\AnalyticsConnectorOfficeMetrics
 *
 * @phpstan-type AnalyticsConnectorActivityShape = array{
 *   chatMetrics: AnalyticsConnectorChatMetrics|AnalyticsConnectorChatMetricsShape,
 *   claudeCodeMetrics: AnalyticsConnectorClaudeCodeMetrics|AnalyticsConnectorClaudeCodeMetricsShape,
 *   connectorName: string,
 *   coworkMetrics: AnalyticsConnectorCoworkMetrics|AnalyticsConnectorCoworkMetricsShape,
 *   distinctUserCount: int,
 *   officeMetrics: AnalyticsConnectorOfficeMetrics|AnalyticsConnectorOfficeMetricsShape,
 *   connectorDisplayName?: string|null,
 *   individualAuthDistinctUserCount?: int|null,
 *   managedAuthDistinctUserCount?: int|null,
 *   product?: string|null,
 *   rbacGroupID?: string|null,
 *   rbacGroupName?: string|null,
 *   readCallCount?: int|null,
 *   unclassifiedCallCount?: int|null,
 *   userID?: string|null,
 *   writeCallCount?: int|null,
 * }
 */
final class AnalyticsConnectorActivity implements BaseModel
{
    /** @use SdkModel<AnalyticsConnectorActivityShape> */
    use SdkModel;

    /**
     * Claude.ai activity metrics for a single connector on a given day.
     */
    #[Required('chat_metrics')]
    public AnalyticsConnectorChatMetrics $chatMetrics;

    /**
     * Claude Code activity metrics for a single connector on a given day.
     */
    #[Required('claude_code_metrics')]
    public AnalyticsConnectorClaudeCodeMetrics $claudeCodeMetrics;

    /**
     * Name of the connector. Some rows carry an opaque connector id here instead of a readable name; `connector_display_name` holds the resolved name for those rows.
     */
    #[Required('connector_name')]
    public string $connectorName;

    /**
     * Cowork activity metrics for a single connector on a given day.
     */
    #[Required('cowork_metrics')]
    public AnalyticsConnectorCoworkMetrics $coworkMetrics;

    /**
     * Number of distinct users who used the connector on the requested day, or, in date-range mode, over the requested window — recomputed as an exact distinct count over the window's per-member daily rows, never a sum of per-day values.
     */
    #[Required('distinct_user_count')]
    public int $distinctUserCount;

    /**
     * Office Agent activity metrics for a single connector on a given day, broken out by Office product.
     */
    #[Required('office_metrics')]
    public AnalyticsConnectorOfficeMetrics $officeMetrics;

    /**
     * Human-readable display name for rows whose `connector_name` is an opaque connector id rather than a readable name, resolved at request time from the organization's connectors (including connectors that have since been removed). `connector_name` remains the row's stable key for sorting and pagination, and `filter[]=connector_name:{value}` also matches these rows by display name. Display names are not unique, and the same connector's claude.ai usage can appear under a separate row with a readable `connector_name`. Null when `connector_name` is already a readable name, when the id cannot be resolved to one of the organization's connectors, or when display-name resolution is not enabled for this organization.
     */
    #[Optional('connector_display_name', nullable: true)]
    public ?string $connectorDisplayName;

    /**
     * Number of distinct users whose use of this connector on the requested day ran on their own individual credential, connected through their own consent flow. Companion bucket to `managed_auth_distinct_user_count`, which carries the measurement, attribution, and null rules. Users whose requests used no stored credential count in neither bucket.
     */
    #[Optional('individual_auth_distinct_user_count', nullable: true)]
    public ?int $individualAuthDistinctUserCount;

    /**
     * Number of distinct users whose use of this connector on the requested day ran on Enterprise Managed Auth (an organization-managed credential provisioned through the organization's identity provider), read from the token record each request used. Null, never 0, when managed-auth reporting is not enabled for the organization, the value cannot be attributed to the row, no credentialed requests and no managed-token mint events (a managed credential being provisioned for a user's use of the connector) were observed that day, or the day predates 2026-07-01, the first day the backing data exists (forward-only data, no backfill). When credentialed requests or mint events were observed and attributed, both managed-auth fields populate, reporting 0 for a bucket with no users; the two counts are independent, not a partition — a user whose requests that day used both kinds of credential counts in both. Mint events carry user but not surface attribution, so they count as observed auth activity on `user_id` and `rbac_group_id` cuts — attributed to the user the credential was provisioned for — but never on a cut that references `product` (group or filter). Date-range rollup mode (`starting_date`/`ending_date`) computes both fields exactly over the window — distinct users with at least one qualifying day — when the whole window starts on or after 2026-07-01, with the null-versus-0 and mint-event rules applying with the window in place of the day; a range starting earlier reports every managed-auth field as null, never a partial-window value.
     */
    #[Optional('managed_auth_distinct_user_count', nullable: true)]
    public ?int $managedAuthDistinctUserCount;

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
     * Number of connector tool calls on the requested day whose trusted read-only annotation marked them read-only. Call count, not distinct users. Every call recorded on a classified surface lands in exactly one of `read_call_count`, `write_call_count`, or `unclassified_call_count`, so the three sum to the day's classified calls. Classification is forward-only per surface: claude.ai from 2026-06-01, Claude Code from 2026-05-30, Claude in Office from 2026-05-29, Cowork from 2026-06-02 (Cowork clients predating annotation forwarding land in `unclassified_call_count`). Null, never 0, when the value cannot be stated: the read/write split is not enabled for this organization, or the day predates 2026-05-29. For a date-range total, sum the per-day values, but treat a window that extends before 2026-05-29 as null rather than summing only its covered days — date-range rollup mode (`starting_date`/`ending_date`) applies both rules server-side.
     */
    #[Optional('read_call_count', nullable: true)]
    public ?int $readCallCount;

    /**
     * Number of connector tool calls on the requested day with no trusted read-only annotation — the annotation is optional in the MCP spec and is discarded when connector access controls are active, so unclassified calls are common. This field shows how much of the day's classified activity the read/write split actually covers. Call count, not distinct users. One of the three call-classification buckets; see `read_call_count` for the per-surface data-start dates, null conditions, and date-range guidance.
     */
    #[Optional('unclassified_call_count', nullable: true)]
    public ?int $unclassifiedCallCount;

    /**
     * Tagged user identifier (e.g. `user_...`). Present only when the request grouped by `user_id`.
     */
    #[Optional('user_id', nullable: true)]
    public ?string $userID;

    /**
     * Number of connector tool calls on the requested day whose trusted read-only annotation marked them not read-only. Call count, not distinct users. One of the three call-classification buckets; see `read_call_count` for the per-surface data-start dates, null conditions, and date-range guidance.
     */
    #[Optional('write_call_count', nullable: true)]
    public ?int $writeCallCount;

    /**
     * `new AnalyticsConnectorActivity()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * AnalyticsConnectorActivity::with(
     *   chatMetrics: ...,
     *   claudeCodeMetrics: ...,
     *   connectorName: ...,
     *   coworkMetrics: ...,
     *   distinctUserCount: ...,
     *   officeMetrics: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new AnalyticsConnectorActivity)
     *   ->withChatMetrics(...)
     *   ->withClaudeCodeMetrics(...)
     *   ->withConnectorName(...)
     *   ->withCoworkMetrics(...)
     *   ->withDistinctUserCount(...)
     *   ->withOfficeMetrics(...)
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
     * @param AnalyticsConnectorChatMetrics|AnalyticsConnectorChatMetricsShape $chatMetrics
     * @param AnalyticsConnectorClaudeCodeMetrics|AnalyticsConnectorClaudeCodeMetricsShape $claudeCodeMetrics
     * @param AnalyticsConnectorCoworkMetrics|AnalyticsConnectorCoworkMetricsShape $coworkMetrics
     * @param AnalyticsConnectorOfficeMetrics|AnalyticsConnectorOfficeMetricsShape $officeMetrics
     */
    public static function with(
        AnalyticsConnectorChatMetrics|array $chatMetrics,
        AnalyticsConnectorClaudeCodeMetrics|array $claudeCodeMetrics,
        string $connectorName,
        AnalyticsConnectorCoworkMetrics|array $coworkMetrics,
        int $distinctUserCount,
        AnalyticsConnectorOfficeMetrics|array $officeMetrics,
        ?string $connectorDisplayName = null,
        ?int $individualAuthDistinctUserCount = null,
        ?int $managedAuthDistinctUserCount = null,
        ?string $product = null,
        ?string $rbacGroupID = null,
        ?string $rbacGroupName = null,
        ?int $readCallCount = null,
        ?int $unclassifiedCallCount = null,
        ?string $userID = null,
        ?int $writeCallCount = null,
    ): self {
        $self = new self;

        $self['chatMetrics'] = $chatMetrics;
        $self['claudeCodeMetrics'] = $claudeCodeMetrics;
        $self['connectorName'] = $connectorName;
        $self['coworkMetrics'] = $coworkMetrics;
        $self['distinctUserCount'] = $distinctUserCount;
        $self['officeMetrics'] = $officeMetrics;

        null !== $connectorDisplayName && $self['connectorDisplayName'] = $connectorDisplayName;
        null !== $individualAuthDistinctUserCount && $self['individualAuthDistinctUserCount'] = $individualAuthDistinctUserCount;
        null !== $managedAuthDistinctUserCount && $self['managedAuthDistinctUserCount'] = $managedAuthDistinctUserCount;
        null !== $product && $self['product'] = $product;
        null !== $rbacGroupID && $self['rbacGroupID'] = $rbacGroupID;
        null !== $rbacGroupName && $self['rbacGroupName'] = $rbacGroupName;
        null !== $readCallCount && $self['readCallCount'] = $readCallCount;
        null !== $unclassifiedCallCount && $self['unclassifiedCallCount'] = $unclassifiedCallCount;
        null !== $userID && $self['userID'] = $userID;
        null !== $writeCallCount && $self['writeCallCount'] = $writeCallCount;

        return $self;
    }

    /**
     * Claude.ai activity metrics for a single connector on a given day.
     *
     * @param AnalyticsConnectorChatMetrics|AnalyticsConnectorChatMetricsShape $chatMetrics
     */
    public function withChatMetrics(
        AnalyticsConnectorChatMetrics|array $chatMetrics
    ): self {
        $self = clone $this;
        $self['chatMetrics'] = $chatMetrics;

        return $self;
    }

    /**
     * Claude Code activity metrics for a single connector on a given day.
     *
     * @param AnalyticsConnectorClaudeCodeMetrics|AnalyticsConnectorClaudeCodeMetricsShape $claudeCodeMetrics
     */
    public function withClaudeCodeMetrics(
        AnalyticsConnectorClaudeCodeMetrics|array $claudeCodeMetrics
    ): self {
        $self = clone $this;
        $self['claudeCodeMetrics'] = $claudeCodeMetrics;

        return $self;
    }

    /**
     * Name of the connector. Some rows carry an opaque connector id here instead of a readable name; `connector_display_name` holds the resolved name for those rows.
     */
    public function withConnectorName(string $connectorName): self
    {
        $self = clone $this;
        $self['connectorName'] = $connectorName;

        return $self;
    }

    /**
     * Cowork activity metrics for a single connector on a given day.
     *
     * @param AnalyticsConnectorCoworkMetrics|AnalyticsConnectorCoworkMetricsShape $coworkMetrics
     */
    public function withCoworkMetrics(
        AnalyticsConnectorCoworkMetrics|array $coworkMetrics
    ): self {
        $self = clone $this;
        $self['coworkMetrics'] = $coworkMetrics;

        return $self;
    }

    /**
     * Number of distinct users who used the connector on the requested day, or, in date-range mode, over the requested window — recomputed as an exact distinct count over the window's per-member daily rows, never a sum of per-day values.
     */
    public function withDistinctUserCount(int $distinctUserCount): self
    {
        $self = clone $this;
        $self['distinctUserCount'] = $distinctUserCount;

        return $self;
    }

    /**
     * Office Agent activity metrics for a single connector on a given day, broken out by Office product.
     *
     * @param AnalyticsConnectorOfficeMetrics|AnalyticsConnectorOfficeMetricsShape $officeMetrics
     */
    public function withOfficeMetrics(
        AnalyticsConnectorOfficeMetrics|array $officeMetrics
    ): self {
        $self = clone $this;
        $self['officeMetrics'] = $officeMetrics;

        return $self;
    }

    /**
     * Human-readable display name for rows whose `connector_name` is an opaque connector id rather than a readable name, resolved at request time from the organization's connectors (including connectors that have since been removed). `connector_name` remains the row's stable key for sorting and pagination, and `filter[]=connector_name:{value}` also matches these rows by display name. Display names are not unique, and the same connector's claude.ai usage can appear under a separate row with a readable `connector_name`. Null when `connector_name` is already a readable name, when the id cannot be resolved to one of the organization's connectors, or when display-name resolution is not enabled for this organization.
     */
    public function withConnectorDisplayName(
        ?string $connectorDisplayName
    ): self {
        $self = clone $this;
        $self['connectorDisplayName'] = $connectorDisplayName;

        return $self;
    }

    /**
     * Number of distinct users whose use of this connector on the requested day ran on their own individual credential, connected through their own consent flow. Companion bucket to `managed_auth_distinct_user_count`, which carries the measurement, attribution, and null rules. Users whose requests used no stored credential count in neither bucket.
     */
    public function withIndividualAuthDistinctUserCount(
        ?int $individualAuthDistinctUserCount
    ): self {
        $self = clone $this;
        $self['individualAuthDistinctUserCount'] = $individualAuthDistinctUserCount;

        return $self;
    }

    /**
     * Number of distinct users whose use of this connector on the requested day ran on Enterprise Managed Auth (an organization-managed credential provisioned through the organization's identity provider), read from the token record each request used. Null, never 0, when managed-auth reporting is not enabled for the organization, the value cannot be attributed to the row, no credentialed requests and no managed-token mint events (a managed credential being provisioned for a user's use of the connector) were observed that day, or the day predates 2026-07-01, the first day the backing data exists (forward-only data, no backfill). When credentialed requests or mint events were observed and attributed, both managed-auth fields populate, reporting 0 for a bucket with no users; the two counts are independent, not a partition — a user whose requests that day used both kinds of credential counts in both. Mint events carry user but not surface attribution, so they count as observed auth activity on `user_id` and `rbac_group_id` cuts — attributed to the user the credential was provisioned for — but never on a cut that references `product` (group or filter). Date-range rollup mode (`starting_date`/`ending_date`) computes both fields exactly over the window — distinct users with at least one qualifying day — when the whole window starts on or after 2026-07-01, with the null-versus-0 and mint-event rules applying with the window in place of the day; a range starting earlier reports every managed-auth field as null, never a partial-window value.
     */
    public function withManagedAuthDistinctUserCount(
        ?int $managedAuthDistinctUserCount
    ): self {
        $self = clone $this;
        $self['managedAuthDistinctUserCount'] = $managedAuthDistinctUserCount;

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
     * Number of connector tool calls on the requested day whose trusted read-only annotation marked them read-only. Call count, not distinct users. Every call recorded on a classified surface lands in exactly one of `read_call_count`, `write_call_count`, or `unclassified_call_count`, so the three sum to the day's classified calls. Classification is forward-only per surface: claude.ai from 2026-06-01, Claude Code from 2026-05-30, Claude in Office from 2026-05-29, Cowork from 2026-06-02 (Cowork clients predating annotation forwarding land in `unclassified_call_count`). Null, never 0, when the value cannot be stated: the read/write split is not enabled for this organization, or the day predates 2026-05-29. For a date-range total, sum the per-day values, but treat a window that extends before 2026-05-29 as null rather than summing only its covered days — date-range rollup mode (`starting_date`/`ending_date`) applies both rules server-side.
     */
    public function withReadCallCount(?int $readCallCount): self
    {
        $self = clone $this;
        $self['readCallCount'] = $readCallCount;

        return $self;
    }

    /**
     * Number of connector tool calls on the requested day with no trusted read-only annotation — the annotation is optional in the MCP spec and is discarded when connector access controls are active, so unclassified calls are common. This field shows how much of the day's classified activity the read/write split actually covers. Call count, not distinct users. One of the three call-classification buckets; see `read_call_count` for the per-surface data-start dates, null conditions, and date-range guidance.
     */
    public function withUnclassifiedCallCount(?int $unclassifiedCallCount): self
    {
        $self = clone $this;
        $self['unclassifiedCallCount'] = $unclassifiedCallCount;

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

    /**
     * Number of connector tool calls on the requested day whose trusted read-only annotation marked them not read-only. Call count, not distinct users. One of the three call-classification buckets; see `read_call_count` for the per-surface data-start dates, null conditions, and date-range guidance.
     */
    public function withWriteCallCount(?int $writeCallCount): self
    {
        $self = clone $this;
        $self['writeCallCount'] = $writeCallCount;

        return $self;
    }
}
