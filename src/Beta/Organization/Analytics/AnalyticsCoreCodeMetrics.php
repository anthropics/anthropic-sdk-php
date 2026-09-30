<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Analytics;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Core Claude Code activity metrics for a single user on a given day.
 *
 * @phpstan-import-type AnalyticsLinesOfCodeShape from \Anthropic\Beta\Organization\Analytics\AnalyticsLinesOfCode
 *
 * @phpstan-type AnalyticsCoreCodeMetricsShape = array{
 *   artifactsCreatedCount: int,
 *   commitCount: int,
 *   distinctSessionCount: int|null,
 *   linesOfCode: AnalyticsLinesOfCode|AnalyticsLinesOfCodeShape,
 *   pullRequestCount: int,
 * }
 */
final class AnalyticsCoreCodeMetrics implements BaseModel
{
    /** @use SdkModel<AnalyticsCoreCodeMetricsShape> */
    use SdkModel;

    /**
     * Number of artifacts created in Claude Code sessions: an artifact counts once, on the day a session first saves it. Counted from 2026-08-17; 0 on earlier days. Exact in date-range mode: a creation belongs to exactly one day, so the per-day counts never overlap and their sum over the window is the exact count of distinct creations in it.
     */
    #[Required('artifacts_created_count')]
    public int $artifactsCreatedCount;

    /**
     * Number of commits made via Claude Code.
     */
    #[Required('commit_count')]
    public int $commitCount;

    /**
     * Number of distinct Claude Code sessions. On aggregated rows and in date-range mode: summed per-day distinct counts. A session essentially never spans a UTC day, so the sum is in practice the true distinct count.
     */
    #[Required('distinct_session_count')]
    public ?int $distinctSessionCount;

    /**
     * Lines of code added and removed via Claude Code.
     */
    #[Required('lines_of_code')]
    public AnalyticsLinesOfCode $linesOfCode;

    /**
     * Number of pull requests created via Claude Code.
     */
    #[Required('pull_request_count')]
    public int $pullRequestCount;

    /**
     * `new AnalyticsCoreCodeMetrics()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * AnalyticsCoreCodeMetrics::with(
     *   artifactsCreatedCount: ...,
     *   commitCount: ...,
     *   distinctSessionCount: ...,
     *   linesOfCode: ...,
     *   pullRequestCount: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new AnalyticsCoreCodeMetrics)
     *   ->withArtifactsCreatedCount(...)
     *   ->withCommitCount(...)
     *   ->withDistinctSessionCount(...)
     *   ->withLinesOfCode(...)
     *   ->withPullRequestCount(...)
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
     * @param AnalyticsLinesOfCode|AnalyticsLinesOfCodeShape $linesOfCode
     */
    public static function with(
        int $artifactsCreatedCount,
        int $commitCount,
        ?int $distinctSessionCount,
        AnalyticsLinesOfCode|array $linesOfCode,
        int $pullRequestCount,
    ): self {
        $self = new self;

        $self['artifactsCreatedCount'] = $artifactsCreatedCount;
        $self['commitCount'] = $commitCount;
        $self['distinctSessionCount'] = $distinctSessionCount;
        $self['linesOfCode'] = $linesOfCode;
        $self['pullRequestCount'] = $pullRequestCount;

        return $self;
    }

    /**
     * Number of artifacts created in Claude Code sessions: an artifact counts once, on the day a session first saves it. Counted from 2026-08-17; 0 on earlier days. Exact in date-range mode: a creation belongs to exactly one day, so the per-day counts never overlap and their sum over the window is the exact count of distinct creations in it.
     */
    public function withArtifactsCreatedCount(int $artifactsCreatedCount): self
    {
        $self = clone $this;
        $self['artifactsCreatedCount'] = $artifactsCreatedCount;

        return $self;
    }

    /**
     * Number of commits made via Claude Code.
     */
    public function withCommitCount(int $commitCount): self
    {
        $self = clone $this;
        $self['commitCount'] = $commitCount;

        return $self;
    }

    /**
     * Number of distinct Claude Code sessions. On aggregated rows and in date-range mode: summed per-day distinct counts. A session essentially never spans a UTC day, so the sum is in practice the true distinct count.
     */
    public function withDistinctSessionCount(?int $distinctSessionCount): self
    {
        $self = clone $this;
        $self['distinctSessionCount'] = $distinctSessionCount;

        return $self;
    }

    /**
     * Lines of code added and removed via Claude Code.
     *
     * @param AnalyticsLinesOfCode|AnalyticsLinesOfCodeShape $linesOfCode
     */
    public function withLinesOfCode(
        AnalyticsLinesOfCode|array $linesOfCode
    ): self {
        $self = clone $this;
        $self['linesOfCode'] = $linesOfCode;

        return $self;
    }

    /**
     * Number of pull requests created via Claude Code.
     */
    public function withPullRequestCount(int $pullRequestCount): self
    {
        $self = clone $this;
        $self['pullRequestCount'] = $pullRequestCount;

        return $self;
    }
}
