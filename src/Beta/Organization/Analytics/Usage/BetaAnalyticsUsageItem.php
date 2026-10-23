<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Analytics\Usage;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type BetaAnalyticsUsageGroupShape from \Anthropic\Beta\Organization\Analytics\Usage\BetaAnalyticsUsageGroup
 * @phpstan-import-type BetaAnalyticsUsageMetricsShape from \Anthropic\Beta\Organization\Analytics\Usage\BetaAnalyticsUsageMetrics
 *
 * @phpstan-type BetaAnalyticsUsageItemShape = array{
 *   endingAt: \DateTimeInterface,
 *   group: BetaAnalyticsUsageGroup|BetaAnalyticsUsageGroupShape,
 *   startingAt: \DateTimeInterface,
 *   usage: BetaAnalyticsUsageMetrics|BetaAnalyticsUsageMetricsShape,
 * }
 */
final class BetaAnalyticsUsageItem implements BaseModel
{
    /** @use SdkModel<BetaAnalyticsUsageItemShape> */
    use SdkModel;

    /**
     * End of the period this row covers (exclusive), as an RFC 3339 UTC timestamp: the end of the row's time bucket when a time-bucket width is set; otherwise the requested `ending_at` (or, when omitted, the earlier of now and `starting_at` plus 31 days) rounded down to the hour, because without a time bucket the report covers whole hours.
     */
    #[Required('ending_at')]
    public \DateTimeInterface $endingAt;

    /**
     * The dimension values this row's usage is broken out by.
     */
    #[Required]
    public BetaAnalyticsUsageGroup $group;

    /**
     * Start of the period this row covers (inclusive), as an RFC 3339 UTC timestamp: the start of the row's time bucket when a time-bucket width is set, otherwise the requested `starting_at` rounded down to the hour.
     */
    #[Required('starting_at')]
    public \DateTimeInterface $startingAt;

    /**
     * Token usage for this row.
     */
    #[Required]
    public BetaAnalyticsUsageMetrics $usage;

    /**
     * `new BetaAnalyticsUsageItem()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaAnalyticsUsageItem::with(
     *   endingAt: ..., group: ..., startingAt: ..., usage: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaAnalyticsUsageItem())
     *   ->withEndingAt(...)
     *   ->withGroup(...)
     *   ->withStartingAt(...)
     *   ->withUsage(...)
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
     * @param BetaAnalyticsUsageGroup|BetaAnalyticsUsageGroupShape $group
     * @param BetaAnalyticsUsageMetrics|BetaAnalyticsUsageMetricsShape $usage
     */
    public static function with(
        \DateTimeInterface $endingAt,
        BetaAnalyticsUsageGroup|array $group,
        \DateTimeInterface $startingAt,
        BetaAnalyticsUsageMetrics|array $usage,
    ): self {
        $self = new self;

        $self['endingAt'] = $endingAt;
        $self['group'] = $group;
        $self['startingAt'] = $startingAt;
        $self['usage'] = $usage;

        return $self;
    }

    /**
     * End of the period this row covers (exclusive), as an RFC 3339 UTC timestamp: the end of the row's time bucket when a time-bucket width is set; otherwise the requested `ending_at` (or, when omitted, the earlier of now and `starting_at` plus 31 days) rounded down to the hour, because without a time bucket the report covers whole hours.
     */
    public function withEndingAt(\DateTimeInterface $endingAt): self
    {
        $self = clone $this;
        $self['endingAt'] = $endingAt;

        return $self;
    }

    /**
     * The dimension values this row's usage is broken out by.
     *
     * @param BetaAnalyticsUsageGroup|BetaAnalyticsUsageGroupShape $group
     */
    public function withGroup(BetaAnalyticsUsageGroup|array $group): self
    {
        $self = clone $this;
        $self['group'] = $group;

        return $self;
    }

    /**
     * Start of the period this row covers (inclusive), as an RFC 3339 UTC timestamp: the start of the row's time bucket when a time-bucket width is set, otherwise the requested `starting_at` rounded down to the hour.
     */
    public function withStartingAt(\DateTimeInterface $startingAt): self
    {
        $self = clone $this;
        $self['startingAt'] = $startingAt;

        return $self;
    }

    /**
     * Token usage for this row.
     *
     * @param BetaAnalyticsUsageMetrics|BetaAnalyticsUsageMetricsShape $usage
     */
    public function withUsage(BetaAnalyticsUsageMetrics|array $usage): self
    {
        $self = clone $this;
        $self['usage'] = $usage;

        return $self;
    }
}
