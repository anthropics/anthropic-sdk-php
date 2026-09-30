<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Analytics;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Claude Science activity metrics for a single user on a given day.
 *
 * @phpstan-type AnalyticsScienceMetricsShape = array{
 *   delegationCount: int,
 *   distinctSessionCount: int|null,
 *   messageCount: int,
 *   remoteComputeJobCount: int,
 *   skillsUsedCount: int,
 * }
 */
final class AnalyticsScienceMetrics implements BaseModel
{
    /** @use SdkModel<AnalyticsScienceMetricsShape> */
    use SdkModel;

    /**
     * Number of delegations (handoffs to a specialized agent) in Claude Science sessions.
     */
    #[Required('delegation_count')]
    public int $delegationCount;

    /**
     * Number of distinct Claude Science sessions. Approximate (HLL, typical error <2%) in date-range mode. Null on aggregated rows where a distinct count cannot be computed.
     */
    #[Required('distinct_session_count')]
    public ?int $distinctSessionCount;

    /**
     * Number of messages sent in Claude Science sessions.
     */
    #[Required('message_count')]
    public int $messageCount;

    /**
     * Number of remote compute jobs launched from Claude Science sessions.
     */
    #[Required('remote_compute_job_count')]
    public int $remoteComputeJobCount;

    /**
     * Total number of skill invocations in Claude Science sessions.
     */
    #[Required('skills_used_count')]
    public int $skillsUsedCount;

    /**
     * `new AnalyticsScienceMetrics()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * AnalyticsScienceMetrics::with(
     *   delegationCount: ...,
     *   distinctSessionCount: ...,
     *   messageCount: ...,
     *   remoteComputeJobCount: ...,
     *   skillsUsedCount: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new AnalyticsScienceMetrics)
     *   ->withDelegationCount(...)
     *   ->withDistinctSessionCount(...)
     *   ->withMessageCount(...)
     *   ->withRemoteComputeJobCount(...)
     *   ->withSkillsUsedCount(...)
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
        int $delegationCount,
        ?int $distinctSessionCount,
        int $messageCount,
        int $remoteComputeJobCount,
        int $skillsUsedCount,
    ): self {
        $self = new self;

        $self['delegationCount'] = $delegationCount;
        $self['distinctSessionCount'] = $distinctSessionCount;
        $self['messageCount'] = $messageCount;
        $self['remoteComputeJobCount'] = $remoteComputeJobCount;
        $self['skillsUsedCount'] = $skillsUsedCount;

        return $self;
    }

    /**
     * Number of delegations (handoffs to a specialized agent) in Claude Science sessions.
     */
    public function withDelegationCount(int $delegationCount): self
    {
        $self = clone $this;
        $self['delegationCount'] = $delegationCount;

        return $self;
    }

    /**
     * Number of distinct Claude Science sessions. Approximate (HLL, typical error <2%) in date-range mode. Null on aggregated rows where a distinct count cannot be computed.
     */
    public function withDistinctSessionCount(?int $distinctSessionCount): self
    {
        $self = clone $this;
        $self['distinctSessionCount'] = $distinctSessionCount;

        return $self;
    }

    /**
     * Number of messages sent in Claude Science sessions.
     */
    public function withMessageCount(int $messageCount): self
    {
        $self = clone $this;
        $self['messageCount'] = $messageCount;

        return $self;
    }

    /**
     * Number of remote compute jobs launched from Claude Science sessions.
     */
    public function withRemoteComputeJobCount(int $remoteComputeJobCount): self
    {
        $self = clone $this;
        $self['remoteComputeJobCount'] = $remoteComputeJobCount;

        return $self;
    }

    /**
     * Total number of skill invocations in Claude Science sessions.
     */
    public function withSkillsUsedCount(int $skillsUsedCount): self
    {
        $self = clone $this;
        $self['skillsUsedCount'] = $skillsUsedCount;

        return $self;
    }
}
