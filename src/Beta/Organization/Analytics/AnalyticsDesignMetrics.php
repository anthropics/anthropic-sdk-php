<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Analytics;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Claude Design activity metrics for a single user on a given day.
 *
 * @phpstan-type AnalyticsDesignMetricsShape = array{
 *   distinctProjectsCreatedCount: int,
 *   distinctProjectsUsedCount: int|null,
 *   distinctSessionCount: int|null,
 *   messageCount: int,
 * }
 */
final class AnalyticsDesignMetrics implements BaseModel
{
    /** @use SdkModel<AnalyticsDesignMetricsShape> */
    use SdkModel;

    /**
     * Number of distinct Claude Design projects created. Exact in date-range mode: a creation belongs to exactly one day, so the per-day counts never overlap and their sum over the window is the exact count of distinct creations in it.
     */
    #[Required('distinct_projects_created_count')]
    public int $distinctProjectsCreatedCount;

    /**
     * Number of distinct Claude Design projects the user worked in. Approximate (HLL, typical error <2%) in date-range mode. Null on aggregated rows where a distinct count cannot be computed.
     */
    #[Required('distinct_projects_used_count')]
    public ?int $distinctProjectsUsedCount;

    /**
     * Number of distinct Claude Design sessions. Approximate (HLL, typical error <2%) in date-range mode. Null on aggregated rows where a distinct count cannot be computed.
     */
    #[Required('distinct_session_count')]
    public ?int $distinctSessionCount;

    /**
     * Number of messages sent in Claude Design sessions.
     */
    #[Required('message_count')]
    public int $messageCount;

    /**
     * `new AnalyticsDesignMetrics()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * AnalyticsDesignMetrics::with(
     *   distinctProjectsCreatedCount: ...,
     *   distinctProjectsUsedCount: ...,
     *   distinctSessionCount: ...,
     *   messageCount: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new AnalyticsDesignMetrics)
     *   ->withDistinctProjectsCreatedCount(...)
     *   ->withDistinctProjectsUsedCount(...)
     *   ->withDistinctSessionCount(...)
     *   ->withMessageCount(...)
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
        int $distinctProjectsCreatedCount,
        ?int $distinctProjectsUsedCount,
        ?int $distinctSessionCount,
        int $messageCount,
    ): self {
        $self = new self;

        $self['distinctProjectsCreatedCount'] = $distinctProjectsCreatedCount;
        $self['distinctProjectsUsedCount'] = $distinctProjectsUsedCount;
        $self['distinctSessionCount'] = $distinctSessionCount;
        $self['messageCount'] = $messageCount;

        return $self;
    }

    /**
     * Number of distinct Claude Design projects created. Exact in date-range mode: a creation belongs to exactly one day, so the per-day counts never overlap and their sum over the window is the exact count of distinct creations in it.
     */
    public function withDistinctProjectsCreatedCount(
        int $distinctProjectsCreatedCount
    ): self {
        $self = clone $this;
        $self['distinctProjectsCreatedCount'] = $distinctProjectsCreatedCount;

        return $self;
    }

    /**
     * Number of distinct Claude Design projects the user worked in. Approximate (HLL, typical error <2%) in date-range mode. Null on aggregated rows where a distinct count cannot be computed.
     */
    public function withDistinctProjectsUsedCount(
        ?int $distinctProjectsUsedCount
    ): self {
        $self = clone $this;
        $self['distinctProjectsUsedCount'] = $distinctProjectsUsedCount;

        return $self;
    }

    /**
     * Number of distinct Claude Design sessions. Approximate (HLL, typical error <2%) in date-range mode. Null on aggregated rows where a distinct count cannot be computed.
     */
    public function withDistinctSessionCount(?int $distinctSessionCount): self
    {
        $self = clone $this;
        $self['distinctSessionCount'] = $distinctSessionCount;

        return $self;
    }

    /**
     * Number of messages sent in Claude Design sessions.
     */
    public function withMessageCount(int $messageCount): self
    {
        $self = clone $this;
        $self['messageCount'] = $messageCount;

        return $self;
    }
}
