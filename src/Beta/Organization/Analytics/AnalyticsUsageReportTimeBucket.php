<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Analytics;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type AnalyticsUsageBucketedResultShape from \Anthropic\Beta\Organization\Analytics\AnalyticsUsageBucketedResult
 *
 * @phpstan-type AnalyticsUsageReportTimeBucketShape = array{
 *   endingAt: \DateTimeInterface,
 *   results: list<AnalyticsUsageBucketedResult|AnalyticsUsageBucketedResultShape>,
 *   startingAt: \DateTimeInterface,
 * }
 */
final class AnalyticsUsageReportTimeBucket implements BaseModel
{
    /** @use SdkModel<AnalyticsUsageReportTimeBucketShape> */
    use SdkModel;

    /**
     * End of the time bucket (exclusive) in RFC 3339 format.
     */
    #[Required('ending_at')]
    public \DateTimeInterface $endingAt;

    /**
     * Rows for this time bucket. Empty when the bucket has no data; otherwise a single combined row when `group_by[]` is omitted, or one row per group (subject to the per-bucket group cap described on the `group_by[]` parameter).
     *
     * @var list<AnalyticsUsageBucketedResult> $results
     */
    #[Required(list: AnalyticsUsageBucketedResult::class)]
    public array $results;

    /**
     * Start of the time bucket (inclusive) in RFC 3339 format.
     */
    #[Required('starting_at')]
    public \DateTimeInterface $startingAt;

    /**
     * `new AnalyticsUsageReportTimeBucket()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * AnalyticsUsageReportTimeBucket::with(
     *   endingAt: ..., results: ..., startingAt: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new AnalyticsUsageReportTimeBucket())
     *   ->withEndingAt(...)
     *   ->withResults(...)
     *   ->withStartingAt(...)
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
     * @param list<AnalyticsUsageBucketedResult|AnalyticsUsageBucketedResultShape> $results
     */
    public static function with(
        \DateTimeInterface $endingAt,
        array $results,
        \DateTimeInterface $startingAt
    ): self {
        $self = new self;

        $self['endingAt'] = $endingAt;
        $self['results'] = $results;
        $self['startingAt'] = $startingAt;

        return $self;
    }

    /**
     * End of the time bucket (exclusive) in RFC 3339 format.
     */
    public function withEndingAt(\DateTimeInterface $endingAt): self
    {
        $self = clone $this;
        $self['endingAt'] = $endingAt;

        return $self;
    }

    /**
     * Rows for this time bucket. Empty when the bucket has no data; otherwise a single combined row when `group_by[]` is omitted, or one row per group (subject to the per-bucket group cap described on the `group_by[]` parameter).
     *
     * @param list<AnalyticsUsageBucketedResult|AnalyticsUsageBucketedResultShape> $results
     */
    public function withResults(array $results): self
    {
        $self = clone $this;
        $self['results'] = $results;

        return $self;
    }

    /**
     * Start of the time bucket (inclusive) in RFC 3339 format.
     */
    public function withStartingAt(\DateTimeInterface $startingAt): self
    {
        $self = clone $this;
        $self['startingAt'] = $startingAt;

        return $self;
    }
}
