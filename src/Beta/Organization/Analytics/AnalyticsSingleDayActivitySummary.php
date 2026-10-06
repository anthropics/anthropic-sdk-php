<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Analytics;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Per-day entry in the /summaries response.
 *
 * @phpstan-type AnalyticsSingleDayActivitySummaryShape = array{
 *   assignedSeatCount: int|null,
 *   coworkDailyActiveUserCount: int,
 *   coworkMonthlyActiveUserCount: int,
 *   coworkWeeklyActiveUserCount: int,
 *   dailyActiveUserCount: int,
 *   dailyAdoptionRate: float|null,
 *   endingAt: \DateTimeInterface,
 *   monthlyActiveUserCount: int,
 *   monthlyAdoptionRate: float|null,
 *   pendingInviteCount: int|null,
 *   startingAt: \DateTimeInterface,
 *   weeklyActiveUserCount: int,
 *   weeklyAdoptionRate: float|null,
 *   chatDailyActiveUserCount?: int|null,
 *   chatMonthlyActiveUserCount?: int|null,
 *   chatWeeklyActiveUserCount?: int|null,
 *   claudeCodeDailyActiveUserCount?: int|null,
 *   claudeCodeMonthlyActiveUserCount?: int|null,
 *   claudeCodeWeeklyActiveUserCount?: int|null,
 *   claudeDesignDailyActiveUserCount?: int|null,
 *   claudeDesignMonthlyActiveUserCount?: int|null,
 *   claudeDesignWeeklyActiveUserCount?: int|null,
 *   officeAgentDailyActiveUserCount?: int|null,
 *   officeAgentMonthlyActiveUserCount?: int|null,
 *   officeAgentWeeklyActiveUserCount?: int|null,
 *   scienceDailyActiveUserCount?: int|null,
 *   scienceEntitledUserCount?: int|null,
 *   scienceMonthlyActiveUserCount?: int|null,
 *   scienceWeeklyActiveUserCount?: int|null,
 * }
 */
final class AnalyticsSingleDayActivitySummary implements BaseModel
{
    /** @use SdkModel<AnalyticsSingleDayActivitySummaryShape> */
    use SdkModel;

    /**
     * Number of seats currently assigned to members. Null when the response is scoped to an RBAC group — seat assignment is org-wide and has no per-group analogue.
     */
    #[Required('assigned_seat_count')]
    public ?int $assignedSeatCount;

    /**
     * Number of users with Cowork activity on the requested day.
     */
    #[Required('cowork_daily_active_user_count')]
    public int $coworkDailyActiveUserCount;

    /**
     * Number of users with Cowork activity in the 30-day rolling window.
     */
    #[Required('cowork_monthly_active_user_count')]
    public int $coworkMonthlyActiveUserCount;

    /**
     * Number of users with Cowork activity in the 7-day rolling window.
     */
    #[Required('cowork_weekly_active_user_count')]
    public int $coworkWeeklyActiveUserCount;

    /**
     * Number of users with token consumption on the requested day.
     */
    #[Required('daily_active_user_count')]
    public int $dailyActiveUserCount;

    /**
     * Percentage of assigned seats with activity on the requested day (`DAU / assigned_seat_count * 100`). Null when the response is scoped to an RBAC group.
     */
    #[Required('daily_adoption_rate')]
    public ?float $dailyAdoptionRate;

    /**
     * End of the aggregation period (exclusive), UTC midnight in RFC 3339 format (e.g. `2026-01-16T00:00:00Z`).
     */
    #[Required('ending_at')]
    public \DateTimeInterface $endingAt;

    /**
     * Number of users with token consumption in the 30-day rolling window.
     */
    #[Required('monthly_active_user_count')]
    public int $monthlyActiveUserCount;

    /**
     * Percentage of assigned seats with activity in the 30-day rolling window (`MAU / assigned_seat_count * 100`). Null when the response is scoped to an RBAC group.
     */
    #[Required('monthly_adoption_rate')]
    public ?float $monthlyAdoptionRate;

    /**
     * Number of pending invitations to join the organization. Null when the response is scoped to an RBAC group.
     */
    #[Required('pending_invite_count')]
    public ?int $pendingInviteCount;

    /**
     * Start of the aggregation period (inclusive), UTC midnight in RFC 3339 format (e.g. `2026-01-15T00:00:00Z`).
     */
    #[Required('starting_at')]
    public \DateTimeInterface $startingAt;

    /**
     * Number of users with token consumption in the 7-day rolling window.
     */
    #[Required('weekly_active_user_count')]
    public int $weeklyActiveUserCount;

    /**
     * Percentage of assigned seats with activity in the 7-day rolling window (`WAU / assigned_seat_count * 100`). Null when the response is scoped to an RBAC group.
     */
    #[Required('weekly_adoption_rate')]
    public ?float $weeklyAdoptionRate;

    /**
     * Number of users with claude.ai (chat) activity on the requested day. Omitted from the response while the per-product breakdown is not enabled for this organization.
     */
    #[Optional('chat_daily_active_user_count', nullable: true)]
    public ?int $chatDailyActiveUserCount;

    /**
     * Number of users with claude.ai (chat) activity in the 30-day rolling window. Omitted from the response while the per-product breakdown is not enabled for this organization.
     */
    #[Optional('chat_monthly_active_user_count', nullable: true)]
    public ?int $chatMonthlyActiveUserCount;

    /**
     * Number of users with claude.ai (chat) activity in the 7-day rolling window. Omitted from the response while the per-product breakdown is not enabled for this organization.
     */
    #[Optional('chat_weekly_active_user_count', nullable: true)]
    public ?int $chatWeeklyActiveUserCount;

    /**
     * Number of users with Claude Code activity on the requested day. Omitted from the response while the per-product breakdown is not enabled for this organization.
     */
    #[Optional('claude_code_daily_active_user_count', nullable: true)]
    public ?int $claudeCodeDailyActiveUserCount;

    /**
     * Number of users with Claude Code activity in the 30-day rolling window. Omitted from the response while the per-product breakdown is not enabled for this organization.
     */
    #[Optional('claude_code_monthly_active_user_count', nullable: true)]
    public ?int $claudeCodeMonthlyActiveUserCount;

    /**
     * Number of users with Claude Code activity in the 7-day rolling window. Omitted from the response while the per-product breakdown is not enabled for this organization.
     */
    #[Optional('claude_code_weekly_active_user_count', nullable: true)]
    public ?int $claudeCodeWeeklyActiveUserCount;

    /**
     * Number of users with Claude Design activity on the requested day. Omitted from the response while the per-product breakdown is not enabled for this organization.
     */
    #[Optional('claude_design_daily_active_user_count', nullable: true)]
    public ?int $claudeDesignDailyActiveUserCount;

    /**
     * Number of users with Claude Design activity in the 30-day rolling window. Omitted from the response while the per-product breakdown is not enabled for this organization.
     */
    #[Optional('claude_design_monthly_active_user_count', nullable: true)]
    public ?int $claudeDesignMonthlyActiveUserCount;

    /**
     * Number of users with Claude Design activity in the 7-day rolling window. Omitted from the response while the per-product breakdown is not enabled for this organization.
     */
    #[Optional('claude_design_weekly_active_user_count', nullable: true)]
    public ?int $claudeDesignWeeklyActiveUserCount;

    /**
     * Number of users with Claude in Office activity on the requested day. Omitted from the response while the per-product breakdown is not enabled for this organization.
     */
    #[Optional('office_agent_daily_active_user_count', nullable: true)]
    public ?int $officeAgentDailyActiveUserCount;

    /**
     * Number of users with Claude in Office activity in the 30-day rolling window. Omitted from the response while the per-product breakdown is not enabled for this organization.
     */
    #[Optional('office_agent_monthly_active_user_count', nullable: true)]
    public ?int $officeAgentMonthlyActiveUserCount;

    /**
     * Number of users with Claude in Office activity in the 7-day rolling window. Omitted from the response while the per-product breakdown is not enabled for this organization.
     */
    #[Optional('office_agent_weekly_active_user_count', nullable: true)]
    public ?int $officeAgentWeeklyActiveUserCount;

    /**
     * Number of users with Claude Science activity on the requested day. Omitted from the response while the per-product breakdown is not enabled for this organization.
     */
    #[Optional('science_daily_active_user_count', nullable: true)]
    public ?int $scienceDailyActiveUserCount;

    /**
     * Number of users with a Claude Science seat entitlement (per-seat RBAC) at the time of the daily snapshot. The funnel top; independent of the org-level Claude Science toggle. Null when the response is scoped to an RBAC group — entitlement is org-wide and has no per-group analogue. Omitted from the response while the per-product breakdown is not enabled for this organization.
     */
    #[Optional('science_entitled_user_count', nullable: true)]
    public ?int $scienceEntitledUserCount;

    /**
     * Number of users with Claude Science activity in the 30-day rolling window. Omitted from the response while the per-product breakdown is not enabled for this organization.
     */
    #[Optional('science_monthly_active_user_count', nullable: true)]
    public ?int $scienceMonthlyActiveUserCount;

    /**
     * Number of users with Claude Science activity in the 7-day rolling window. Omitted from the response while the per-product breakdown is not enabled for this organization.
     */
    #[Optional('science_weekly_active_user_count', nullable: true)]
    public ?int $scienceWeeklyActiveUserCount;

    /**
     * `new AnalyticsSingleDayActivitySummary()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * AnalyticsSingleDayActivitySummary::with(
     *   assignedSeatCount: ...,
     *   coworkDailyActiveUserCount: ...,
     *   coworkMonthlyActiveUserCount: ...,
     *   coworkWeeklyActiveUserCount: ...,
     *   dailyActiveUserCount: ...,
     *   dailyAdoptionRate: ...,
     *   endingAt: ...,
     *   monthlyActiveUserCount: ...,
     *   monthlyAdoptionRate: ...,
     *   pendingInviteCount: ...,
     *   startingAt: ...,
     *   weeklyActiveUserCount: ...,
     *   weeklyAdoptionRate: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new AnalyticsSingleDayActivitySummary())
     *   ->withAssignedSeatCount(...)
     *   ->withCoworkDailyActiveUserCount(...)
     *   ->withCoworkMonthlyActiveUserCount(...)
     *   ->withCoworkWeeklyActiveUserCount(...)
     *   ->withDailyActiveUserCount(...)
     *   ->withDailyAdoptionRate(...)
     *   ->withEndingAt(...)
     *   ->withMonthlyActiveUserCount(...)
     *   ->withMonthlyAdoptionRate(...)
     *   ->withPendingInviteCount(...)
     *   ->withStartingAt(...)
     *   ->withWeeklyActiveUserCount(...)
     *   ->withWeeklyAdoptionRate(...)
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
     */
    public static function with(
        ?int $assignedSeatCount,
        int $coworkDailyActiveUserCount,
        int $coworkMonthlyActiveUserCount,
        int $coworkWeeklyActiveUserCount,
        int $dailyActiveUserCount,
        ?float $dailyAdoptionRate,
        \DateTimeInterface $endingAt,
        int $monthlyActiveUserCount,
        ?float $monthlyAdoptionRate,
        ?int $pendingInviteCount,
        \DateTimeInterface $startingAt,
        int $weeklyActiveUserCount,
        ?float $weeklyAdoptionRate,
        ?int $chatDailyActiveUserCount = null,
        ?int $chatMonthlyActiveUserCount = null,
        ?int $chatWeeklyActiveUserCount = null,
        ?int $claudeCodeDailyActiveUserCount = null,
        ?int $claudeCodeMonthlyActiveUserCount = null,
        ?int $claudeCodeWeeklyActiveUserCount = null,
        ?int $claudeDesignDailyActiveUserCount = null,
        ?int $claudeDesignMonthlyActiveUserCount = null,
        ?int $claudeDesignWeeklyActiveUserCount = null,
        ?int $officeAgentDailyActiveUserCount = null,
        ?int $officeAgentMonthlyActiveUserCount = null,
        ?int $officeAgentWeeklyActiveUserCount = null,
        ?int $scienceDailyActiveUserCount = null,
        ?int $scienceEntitledUserCount = null,
        ?int $scienceMonthlyActiveUserCount = null,
        ?int $scienceWeeklyActiveUserCount = null,
    ): self {
        $self = new self;

        $self['assignedSeatCount'] = $assignedSeatCount;
        $self['coworkDailyActiveUserCount'] = $coworkDailyActiveUserCount;
        $self['coworkMonthlyActiveUserCount'] = $coworkMonthlyActiveUserCount;
        $self['coworkWeeklyActiveUserCount'] = $coworkWeeklyActiveUserCount;
        $self['dailyActiveUserCount'] = $dailyActiveUserCount;
        $self['dailyAdoptionRate'] = $dailyAdoptionRate;
        $self['endingAt'] = $endingAt;
        $self['monthlyActiveUserCount'] = $monthlyActiveUserCount;
        $self['monthlyAdoptionRate'] = $monthlyAdoptionRate;
        $self['pendingInviteCount'] = $pendingInviteCount;
        $self['startingAt'] = $startingAt;
        $self['weeklyActiveUserCount'] = $weeklyActiveUserCount;
        $self['weeklyAdoptionRate'] = $weeklyAdoptionRate;

        null !== $chatDailyActiveUserCount && $self['chatDailyActiveUserCount'] = $chatDailyActiveUserCount;
        null !== $chatMonthlyActiveUserCount && $self['chatMonthlyActiveUserCount'] = $chatMonthlyActiveUserCount;
        null !== $chatWeeklyActiveUserCount && $self['chatWeeklyActiveUserCount'] = $chatWeeklyActiveUserCount;
        null !== $claudeCodeDailyActiveUserCount && $self['claudeCodeDailyActiveUserCount'] = $claudeCodeDailyActiveUserCount;
        null !== $claudeCodeMonthlyActiveUserCount && $self['claudeCodeMonthlyActiveUserCount'] = $claudeCodeMonthlyActiveUserCount;
        null !== $claudeCodeWeeklyActiveUserCount && $self['claudeCodeWeeklyActiveUserCount'] = $claudeCodeWeeklyActiveUserCount;
        null !== $claudeDesignDailyActiveUserCount && $self['claudeDesignDailyActiveUserCount'] = $claudeDesignDailyActiveUserCount;
        null !== $claudeDesignMonthlyActiveUserCount && $self['claudeDesignMonthlyActiveUserCount'] = $claudeDesignMonthlyActiveUserCount;
        null !== $claudeDesignWeeklyActiveUserCount && $self['claudeDesignWeeklyActiveUserCount'] = $claudeDesignWeeklyActiveUserCount;
        null !== $officeAgentDailyActiveUserCount && $self['officeAgentDailyActiveUserCount'] = $officeAgentDailyActiveUserCount;
        null !== $officeAgentMonthlyActiveUserCount && $self['officeAgentMonthlyActiveUserCount'] = $officeAgentMonthlyActiveUserCount;
        null !== $officeAgentWeeklyActiveUserCount && $self['officeAgentWeeklyActiveUserCount'] = $officeAgentWeeklyActiveUserCount;
        null !== $scienceDailyActiveUserCount && $self['scienceDailyActiveUserCount'] = $scienceDailyActiveUserCount;
        null !== $scienceEntitledUserCount && $self['scienceEntitledUserCount'] = $scienceEntitledUserCount;
        null !== $scienceMonthlyActiveUserCount && $self['scienceMonthlyActiveUserCount'] = $scienceMonthlyActiveUserCount;
        null !== $scienceWeeklyActiveUserCount && $self['scienceWeeklyActiveUserCount'] = $scienceWeeklyActiveUserCount;

        return $self;
    }

    /**
     * Number of seats currently assigned to members. Null when the response is scoped to an RBAC group — seat assignment is org-wide and has no per-group analogue.
     */
    public function withAssignedSeatCount(?int $assignedSeatCount): self
    {
        $self = clone $this;
        $self['assignedSeatCount'] = $assignedSeatCount;

        return $self;
    }

    /**
     * Number of users with Cowork activity on the requested day.
     */
    public function withCoworkDailyActiveUserCount(
        int $coworkDailyActiveUserCount
    ): self {
        $self = clone $this;
        $self['coworkDailyActiveUserCount'] = $coworkDailyActiveUserCount;

        return $self;
    }

    /**
     * Number of users with Cowork activity in the 30-day rolling window.
     */
    public function withCoworkMonthlyActiveUserCount(
        int $coworkMonthlyActiveUserCount
    ): self {
        $self = clone $this;
        $self['coworkMonthlyActiveUserCount'] = $coworkMonthlyActiveUserCount;

        return $self;
    }

    /**
     * Number of users with Cowork activity in the 7-day rolling window.
     */
    public function withCoworkWeeklyActiveUserCount(
        int $coworkWeeklyActiveUserCount
    ): self {
        $self = clone $this;
        $self['coworkWeeklyActiveUserCount'] = $coworkWeeklyActiveUserCount;

        return $self;
    }

    /**
     * Number of users with token consumption on the requested day.
     */
    public function withDailyActiveUserCount(int $dailyActiveUserCount): self
    {
        $self = clone $this;
        $self['dailyActiveUserCount'] = $dailyActiveUserCount;

        return $self;
    }

    /**
     * Percentage of assigned seats with activity on the requested day (`DAU / assigned_seat_count * 100`). Null when the response is scoped to an RBAC group.
     */
    public function withDailyAdoptionRate(?float $dailyAdoptionRate): self
    {
        $self = clone $this;
        $self['dailyAdoptionRate'] = $dailyAdoptionRate;

        return $self;
    }

    /**
     * End of the aggregation period (exclusive), UTC midnight in RFC 3339 format (e.g. `2026-01-16T00:00:00Z`).
     */
    public function withEndingAt(\DateTimeInterface $endingAt): self
    {
        $self = clone $this;
        $self['endingAt'] = $endingAt;

        return $self;
    }

    /**
     * Number of users with token consumption in the 30-day rolling window.
     */
    public function withMonthlyActiveUserCount(
        int $monthlyActiveUserCount
    ): self {
        $self = clone $this;
        $self['monthlyActiveUserCount'] = $monthlyActiveUserCount;

        return $self;
    }

    /**
     * Percentage of assigned seats with activity in the 30-day rolling window (`MAU / assigned_seat_count * 100`). Null when the response is scoped to an RBAC group.
     */
    public function withMonthlyAdoptionRate(?float $monthlyAdoptionRate): self
    {
        $self = clone $this;
        $self['monthlyAdoptionRate'] = $monthlyAdoptionRate;

        return $self;
    }

    /**
     * Number of pending invitations to join the organization. Null when the response is scoped to an RBAC group.
     */
    public function withPendingInviteCount(?int $pendingInviteCount): self
    {
        $self = clone $this;
        $self['pendingInviteCount'] = $pendingInviteCount;

        return $self;
    }

    /**
     * Start of the aggregation period (inclusive), UTC midnight in RFC 3339 format (e.g. `2026-01-15T00:00:00Z`).
     */
    public function withStartingAt(\DateTimeInterface $startingAt): self
    {
        $self = clone $this;
        $self['startingAt'] = $startingAt;

        return $self;
    }

    /**
     * Number of users with token consumption in the 7-day rolling window.
     */
    public function withWeeklyActiveUserCount(int $weeklyActiveUserCount): self
    {
        $self = clone $this;
        $self['weeklyActiveUserCount'] = $weeklyActiveUserCount;

        return $self;
    }

    /**
     * Percentage of assigned seats with activity in the 7-day rolling window (`WAU / assigned_seat_count * 100`). Null when the response is scoped to an RBAC group.
     */
    public function withWeeklyAdoptionRate(?float $weeklyAdoptionRate): self
    {
        $self = clone $this;
        $self['weeklyAdoptionRate'] = $weeklyAdoptionRate;

        return $self;
    }

    /**
     * Number of users with claude.ai (chat) activity on the requested day. Omitted from the response while the per-product breakdown is not enabled for this organization.
     */
    public function withChatDailyActiveUserCount(
        ?int $chatDailyActiveUserCount
    ): self {
        $self = clone $this;
        $self['chatDailyActiveUserCount'] = $chatDailyActiveUserCount;

        return $self;
    }

    /**
     * Number of users with claude.ai (chat) activity in the 30-day rolling window. Omitted from the response while the per-product breakdown is not enabled for this organization.
     */
    public function withChatMonthlyActiveUserCount(
        ?int $chatMonthlyActiveUserCount
    ): self {
        $self = clone $this;
        $self['chatMonthlyActiveUserCount'] = $chatMonthlyActiveUserCount;

        return $self;
    }

    /**
     * Number of users with claude.ai (chat) activity in the 7-day rolling window. Omitted from the response while the per-product breakdown is not enabled for this organization.
     */
    public function withChatWeeklyActiveUserCount(
        ?int $chatWeeklyActiveUserCount
    ): self {
        $self = clone $this;
        $self['chatWeeklyActiveUserCount'] = $chatWeeklyActiveUserCount;

        return $self;
    }

    /**
     * Number of users with Claude Code activity on the requested day. Omitted from the response while the per-product breakdown is not enabled for this organization.
     */
    public function withClaudeCodeDailyActiveUserCount(
        ?int $claudeCodeDailyActiveUserCount
    ): self {
        $self = clone $this;
        $self['claudeCodeDailyActiveUserCount'] = $claudeCodeDailyActiveUserCount;

        return $self;
    }

    /**
     * Number of users with Claude Code activity in the 30-day rolling window. Omitted from the response while the per-product breakdown is not enabled for this organization.
     */
    public function withClaudeCodeMonthlyActiveUserCount(
        ?int $claudeCodeMonthlyActiveUserCount
    ): self {
        $self = clone $this;
        $self['claudeCodeMonthlyActiveUserCount'] = $claudeCodeMonthlyActiveUserCount;

        return $self;
    }

    /**
     * Number of users with Claude Code activity in the 7-day rolling window. Omitted from the response while the per-product breakdown is not enabled for this organization.
     */
    public function withClaudeCodeWeeklyActiveUserCount(
        ?int $claudeCodeWeeklyActiveUserCount
    ): self {
        $self = clone $this;
        $self['claudeCodeWeeklyActiveUserCount'] = $claudeCodeWeeklyActiveUserCount;

        return $self;
    }

    /**
     * Number of users with Claude Design activity on the requested day. Omitted from the response while the per-product breakdown is not enabled for this organization.
     */
    public function withClaudeDesignDailyActiveUserCount(
        ?int $claudeDesignDailyActiveUserCount
    ): self {
        $self = clone $this;
        $self['claudeDesignDailyActiveUserCount'] = $claudeDesignDailyActiveUserCount;

        return $self;
    }

    /**
     * Number of users with Claude Design activity in the 30-day rolling window. Omitted from the response while the per-product breakdown is not enabled for this organization.
     */
    public function withClaudeDesignMonthlyActiveUserCount(
        ?int $claudeDesignMonthlyActiveUserCount
    ): self {
        $self = clone $this;
        $self['claudeDesignMonthlyActiveUserCount'] = $claudeDesignMonthlyActiveUserCount;

        return $self;
    }

    /**
     * Number of users with Claude Design activity in the 7-day rolling window. Omitted from the response while the per-product breakdown is not enabled for this organization.
     */
    public function withClaudeDesignWeeklyActiveUserCount(
        ?int $claudeDesignWeeklyActiveUserCount
    ): self {
        $self = clone $this;
        $self['claudeDesignWeeklyActiveUserCount'] = $claudeDesignWeeklyActiveUserCount;

        return $self;
    }

    /**
     * Number of users with Claude in Office activity on the requested day. Omitted from the response while the per-product breakdown is not enabled for this organization.
     */
    public function withOfficeAgentDailyActiveUserCount(
        ?int $officeAgentDailyActiveUserCount
    ): self {
        $self = clone $this;
        $self['officeAgentDailyActiveUserCount'] = $officeAgentDailyActiveUserCount;

        return $self;
    }

    /**
     * Number of users with Claude in Office activity in the 30-day rolling window. Omitted from the response while the per-product breakdown is not enabled for this organization.
     */
    public function withOfficeAgentMonthlyActiveUserCount(
        ?int $officeAgentMonthlyActiveUserCount
    ): self {
        $self = clone $this;
        $self['officeAgentMonthlyActiveUserCount'] = $officeAgentMonthlyActiveUserCount;

        return $self;
    }

    /**
     * Number of users with Claude in Office activity in the 7-day rolling window. Omitted from the response while the per-product breakdown is not enabled for this organization.
     */
    public function withOfficeAgentWeeklyActiveUserCount(
        ?int $officeAgentWeeklyActiveUserCount
    ): self {
        $self = clone $this;
        $self['officeAgentWeeklyActiveUserCount'] = $officeAgentWeeklyActiveUserCount;

        return $self;
    }

    /**
     * Number of users with Claude Science activity on the requested day. Omitted from the response while the per-product breakdown is not enabled for this organization.
     */
    public function withScienceDailyActiveUserCount(
        ?int $scienceDailyActiveUserCount
    ): self {
        $self = clone $this;
        $self['scienceDailyActiveUserCount'] = $scienceDailyActiveUserCount;

        return $self;
    }

    /**
     * Number of users with a Claude Science seat entitlement (per-seat RBAC) at the time of the daily snapshot. The funnel top; independent of the org-level Claude Science toggle. Null when the response is scoped to an RBAC group — entitlement is org-wide and has no per-group analogue. Omitted from the response while the per-product breakdown is not enabled for this organization.
     */
    public function withScienceEntitledUserCount(
        ?int $scienceEntitledUserCount
    ): self {
        $self = clone $this;
        $self['scienceEntitledUserCount'] = $scienceEntitledUserCount;

        return $self;
    }

    /**
     * Number of users with Claude Science activity in the 30-day rolling window. Omitted from the response while the per-product breakdown is not enabled for this organization.
     */
    public function withScienceMonthlyActiveUserCount(
        ?int $scienceMonthlyActiveUserCount
    ): self {
        $self = clone $this;
        $self['scienceMonthlyActiveUserCount'] = $scienceMonthlyActiveUserCount;

        return $self;
    }

    /**
     * Number of users with Claude Science activity in the 7-day rolling window. Omitted from the response while the per-product breakdown is not enabled for this organization.
     */
    public function withScienceWeeklyActiveUserCount(
        ?int $scienceWeeklyActiveUserCount
    ): self {
        $self = clone $this;
        $self['scienceWeeklyActiveUserCount'] = $scienceWeeklyActiveUserCount;

        return $self;
    }
}
