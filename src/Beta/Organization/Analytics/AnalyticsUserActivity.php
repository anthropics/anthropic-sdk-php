<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Analytics;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Per-user activity data for a given day.
 *
 * @phpstan-import-type AnalyticsChatMetricsShape from \Anthropic\Beta\Organization\Analytics\AnalyticsChatMetrics
 * @phpstan-import-type AnalyticsClaudeCodeMetricsShape from \Anthropic\Beta\Organization\Analytics\AnalyticsClaudeCodeMetrics
 * @phpstan-import-type AnalyticsCoworkMetricsShape from \Anthropic\Beta\Organization\Analytics\AnalyticsCoworkMetrics
 * @phpstan-import-type AnalyticsDesignMetricsShape from \Anthropic\Beta\Organization\Analytics\AnalyticsDesignMetrics
 * @phpstan-import-type AnalyticsOfficeMetricsShape from \Anthropic\Beta\Organization\Analytics\AnalyticsOfficeMetrics
 * @phpstan-import-type AnalyticsScienceMetricsShape from \Anthropic\Beta\Organization\Analytics\AnalyticsScienceMetrics
 * @phpstan-import-type AnalyticsUserShape from \Anthropic\Beta\Organization\Analytics\AnalyticsUser
 *
 * @phpstan-type AnalyticsUserActivityShape = array{
 *   chatMetrics: AnalyticsChatMetrics|AnalyticsChatMetricsShape,
 *   claudeCodeMetrics: AnalyticsClaudeCodeMetrics|AnalyticsClaudeCodeMetricsShape,
 *   coworkMetrics: AnalyticsCoworkMetrics|AnalyticsCoworkMetricsShape,
 *   designMetrics: AnalyticsDesignMetrics|AnalyticsDesignMetricsShape,
 *   officeMetrics: AnalyticsOfficeMetrics|AnalyticsOfficeMetricsShape,
 *   scienceMetrics: AnalyticsScienceMetrics|AnalyticsScienceMetricsShape,
 *   webSearchCount: int,
 *   distinctUserCount?: int|null,
 *   lastActivityDate?: string|null,
 *   rbacGroupID?: string|null,
 *   rbacGroupName?: string|null,
 *   user?: null|AnalyticsUser|AnalyticsUserShape,
 * }
 */
final class AnalyticsUserActivity implements BaseModel
{
    /** @use SdkModel<AnalyticsUserActivityShape> */
    use SdkModel;

    /**
     * Claude.ai activity metrics for a single user on a given day.
     */
    #[Required('chat_metrics')]
    public AnalyticsChatMetrics $chatMetrics;

    /**
     * Claude Code activity metrics for a single user on a given day.
     */
    #[Required('claude_code_metrics')]
    public AnalyticsClaudeCodeMetrics $claudeCodeMetrics;

    /**
     * Cowork activity metrics for a single user on a given day.
     */
    #[Required('cowork_metrics')]
    public AnalyticsCoworkMetrics $coworkMetrics;

    /**
     * Claude Design activity metrics for a single user on a given day.
     */
    #[Required('design_metrics')]
    public AnalyticsDesignMetrics $designMetrics;

    /**
     * Office Agent activity metrics for a single user on a given day, broken out by Office product.
     */
    #[Required('office_metrics')]
    public AnalyticsOfficeMetrics $officeMetrics;

    /**
     * Claude Science activity metrics for a single user on a given day.
     */
    #[Required('science_metrics')]
    public AnalyticsScienceMetrics $scienceMetrics;

    /**
     * Number of web searches performed.
     */
    #[Required('web_search_count')]
    public int $webSearchCount;

    /**
     * Number of distinct active users represented by this row. Only set for grouped rollups (`group_by[]`); null for per-user rows. In date-range mode, recomputed as an exact distinct count of the group's active members over the requested window, never a sum of per-day values.
     */
    #[Optional('distinct_user_count', nullable: true)]
    public ?int $distinctUserCount;

    /**
     * Most recent UTC day (YYYY-MM-DD) on which the user had any counted activity, within the requested window: equal to the requested `date` in single-day mode, and to the latest active day from `starting_date` (inclusive) to `ending_date` (exclusive) in date-range rollup mode — never a day earlier than the window start. On filtered requests (`filter[]`) only days matching the filter count: with `filter[]=rbac_group_id:{id}` it is the last day the user was active while a member of that group, consistent with the row's other metrics. On grouped (`group_by[]`) rows it is the latest day any member of the group was active (the requested `date` in single-day mode). Omitted from the response while last-activity reporting is not enabled for this organization.
     */
    #[Optional('last_activity_date', nullable: true)]
    public ?string $lastActivityDate;

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
     * The user this row describes. Null on rows aggregated across users.
     */
    #[Optional(nullable: true)]
    public ?AnalyticsUser $user;

    /**
     * `new AnalyticsUserActivity()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * AnalyticsUserActivity::with(
     *   chatMetrics: ...,
     *   claudeCodeMetrics: ...,
     *   coworkMetrics: ...,
     *   designMetrics: ...,
     *   officeMetrics: ...,
     *   scienceMetrics: ...,
     *   webSearchCount: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new AnalyticsUserActivity)
     *   ->withChatMetrics(...)
     *   ->withClaudeCodeMetrics(...)
     *   ->withCoworkMetrics(...)
     *   ->withDesignMetrics(...)
     *   ->withOfficeMetrics(...)
     *   ->withScienceMetrics(...)
     *   ->withWebSearchCount(...)
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
     * @param AnalyticsChatMetrics|AnalyticsChatMetricsShape $chatMetrics
     * @param AnalyticsClaudeCodeMetrics|AnalyticsClaudeCodeMetricsShape $claudeCodeMetrics
     * @param AnalyticsCoworkMetrics|AnalyticsCoworkMetricsShape $coworkMetrics
     * @param AnalyticsDesignMetrics|AnalyticsDesignMetricsShape $designMetrics
     * @param AnalyticsOfficeMetrics|AnalyticsOfficeMetricsShape $officeMetrics
     * @param AnalyticsScienceMetrics|AnalyticsScienceMetricsShape $scienceMetrics
     * @param AnalyticsUser|AnalyticsUserShape|null $user
     */
    public static function with(
        AnalyticsChatMetrics|array $chatMetrics,
        AnalyticsClaudeCodeMetrics|array $claudeCodeMetrics,
        AnalyticsCoworkMetrics|array $coworkMetrics,
        AnalyticsDesignMetrics|array $designMetrics,
        AnalyticsOfficeMetrics|array $officeMetrics,
        AnalyticsScienceMetrics|array $scienceMetrics,
        int $webSearchCount,
        ?int $distinctUserCount = null,
        ?string $lastActivityDate = null,
        ?string $rbacGroupID = null,
        ?string $rbacGroupName = null,
        AnalyticsUser|array|null $user = null,
    ): self {
        $self = new self;

        $self['chatMetrics'] = $chatMetrics;
        $self['claudeCodeMetrics'] = $claudeCodeMetrics;
        $self['coworkMetrics'] = $coworkMetrics;
        $self['designMetrics'] = $designMetrics;
        $self['officeMetrics'] = $officeMetrics;
        $self['scienceMetrics'] = $scienceMetrics;
        $self['webSearchCount'] = $webSearchCount;

        null !== $distinctUserCount && $self['distinctUserCount'] = $distinctUserCount;
        null !== $lastActivityDate && $self['lastActivityDate'] = $lastActivityDate;
        null !== $rbacGroupID && $self['rbacGroupID'] = $rbacGroupID;
        null !== $rbacGroupName && $self['rbacGroupName'] = $rbacGroupName;
        null !== $user && $self['user'] = $user;

        return $self;
    }

    /**
     * Claude.ai activity metrics for a single user on a given day.
     *
     * @param AnalyticsChatMetrics|AnalyticsChatMetricsShape $chatMetrics
     */
    public function withChatMetrics(
        AnalyticsChatMetrics|array $chatMetrics
    ): self {
        $self = clone $this;
        $self['chatMetrics'] = $chatMetrics;

        return $self;
    }

    /**
     * Claude Code activity metrics for a single user on a given day.
     *
     * @param AnalyticsClaudeCodeMetrics|AnalyticsClaudeCodeMetricsShape $claudeCodeMetrics
     */
    public function withClaudeCodeMetrics(
        AnalyticsClaudeCodeMetrics|array $claudeCodeMetrics
    ): self {
        $self = clone $this;
        $self['claudeCodeMetrics'] = $claudeCodeMetrics;

        return $self;
    }

    /**
     * Cowork activity metrics for a single user on a given day.
     *
     * @param AnalyticsCoworkMetrics|AnalyticsCoworkMetricsShape $coworkMetrics
     */
    public function withCoworkMetrics(
        AnalyticsCoworkMetrics|array $coworkMetrics
    ): self {
        $self = clone $this;
        $self['coworkMetrics'] = $coworkMetrics;

        return $self;
    }

    /**
     * Claude Design activity metrics for a single user on a given day.
     *
     * @param AnalyticsDesignMetrics|AnalyticsDesignMetricsShape $designMetrics
     */
    public function withDesignMetrics(
        AnalyticsDesignMetrics|array $designMetrics
    ): self {
        $self = clone $this;
        $self['designMetrics'] = $designMetrics;

        return $self;
    }

    /**
     * Office Agent activity metrics for a single user on a given day, broken out by Office product.
     *
     * @param AnalyticsOfficeMetrics|AnalyticsOfficeMetricsShape $officeMetrics
     */
    public function withOfficeMetrics(
        AnalyticsOfficeMetrics|array $officeMetrics
    ): self {
        $self = clone $this;
        $self['officeMetrics'] = $officeMetrics;

        return $self;
    }

    /**
     * Claude Science activity metrics for a single user on a given day.
     *
     * @param AnalyticsScienceMetrics|AnalyticsScienceMetricsShape $scienceMetrics
     */
    public function withScienceMetrics(
        AnalyticsScienceMetrics|array $scienceMetrics
    ): self {
        $self = clone $this;
        $self['scienceMetrics'] = $scienceMetrics;

        return $self;
    }

    /**
     * Number of web searches performed.
     */
    public function withWebSearchCount(int $webSearchCount): self
    {
        $self = clone $this;
        $self['webSearchCount'] = $webSearchCount;

        return $self;
    }

    /**
     * Number of distinct active users represented by this row. Only set for grouped rollups (`group_by[]`); null for per-user rows. In date-range mode, recomputed as an exact distinct count of the group's active members over the requested window, never a sum of per-day values.
     */
    public function withDistinctUserCount(?int $distinctUserCount): self
    {
        $self = clone $this;
        $self['distinctUserCount'] = $distinctUserCount;

        return $self;
    }

    /**
     * Most recent UTC day (YYYY-MM-DD) on which the user had any counted activity, within the requested window: equal to the requested `date` in single-day mode, and to the latest active day from `starting_date` (inclusive) to `ending_date` (exclusive) in date-range rollup mode — never a day earlier than the window start. On filtered requests (`filter[]`) only days matching the filter count: with `filter[]=rbac_group_id:{id}` it is the last day the user was active while a member of that group, consistent with the row's other metrics. On grouped (`group_by[]`) rows it is the latest day any member of the group was active (the requested `date` in single-day mode). Omitted from the response while last-activity reporting is not enabled for this organization.
     */
    public function withLastActivityDate(?string $lastActivityDate): self
    {
        $self = clone $this;
        $self['lastActivityDate'] = $lastActivityDate;

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
     * The user this row describes. Null on rows aggregated across users.
     *
     * @param AnalyticsUser|AnalyticsUserShape|null $user
     */
    public function withUser(AnalyticsUser|array|null $user): self
    {
        $self = clone $this;
        $self['user'] = $user;

        return $self;
    }
}
