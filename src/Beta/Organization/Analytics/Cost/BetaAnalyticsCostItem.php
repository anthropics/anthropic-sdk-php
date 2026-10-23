<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Analytics\Cost;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type BetaAnalyticsCostMetricsShape from \Anthropic\Beta\Organization\Analytics\Cost\BetaAnalyticsCostMetrics
 * @phpstan-import-type BetaAnalyticsCostGroupShape from \Anthropic\Beta\Organization\Analytics\Cost\BetaAnalyticsCostGroup
 *
 * @phpstan-type BetaAnalyticsCostItemShape = array{
 *   cost: BetaAnalyticsCostMetrics|BetaAnalyticsCostMetricsShape,
 *   endingAt: \DateTimeInterface,
 *   group: BetaAnalyticsCostGroup|BetaAnalyticsCostGroupShape,
 *   startingAt: \DateTimeInterface,
 * }
 */
final class BetaAnalyticsCostItem implements BaseModel
{
    /** @use SdkModel<BetaAnalyticsCostItemShape> */
    use SdkModel;

    /**
     * Cost for this row.
     */
    #[Required]
    public BetaAnalyticsCostMetrics $cost;

    /**
     * End of the period this row covers (exclusive), as an RFC 3339 UTC timestamp: the end of the row's time bucket when a time-bucket width is set; otherwise the requested `ending_at` (or, when omitted, the earlier of now and `starting_at` plus 31 days) rounded down to the hour, because without a time bucket the report covers whole hours.
     */
    #[Required('ending_at')]
    public \DateTimeInterface $endingAt;

    /**
     * The dimension values this row's cost is broken out by.
     */
    #[Required]
    public BetaAnalyticsCostGroup $group;

    /**
     * Start of the period this row covers (inclusive), as an RFC 3339 UTC timestamp: the start of the row's time bucket when a time-bucket width is set, otherwise the requested `starting_at` rounded down to the hour.
     */
    #[Required('starting_at')]
    public \DateTimeInterface $startingAt;

    /**
     * `new BetaAnalyticsCostItem()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaAnalyticsCostItem::with(
     *   cost: ..., endingAt: ..., group: ..., startingAt: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaAnalyticsCostItem())
     *   ->withCost(...)
     *   ->withEndingAt(...)
     *   ->withGroup(...)
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
     * @param BetaAnalyticsCostMetrics|BetaAnalyticsCostMetricsShape $cost
     * @param BetaAnalyticsCostGroup|BetaAnalyticsCostGroupShape $group
     */
    public static function with(
        BetaAnalyticsCostMetrics|array $cost,
        \DateTimeInterface $endingAt,
        BetaAnalyticsCostGroup|array $group,
        \DateTimeInterface $startingAt,
    ): self {
        $self = new self;

        $self['cost'] = $cost;
        $self['endingAt'] = $endingAt;
        $self['group'] = $group;
        $self['startingAt'] = $startingAt;

        return $self;
    }

    /**
     * Cost for this row.
     *
     * @param BetaAnalyticsCostMetrics|BetaAnalyticsCostMetricsShape $cost
     */
    public function withCost(BetaAnalyticsCostMetrics|array $cost): self
    {
        $self = clone $this;
        $self['cost'] = $cost;

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
     * The dimension values this row's cost is broken out by.
     *
     * @param BetaAnalyticsCostGroup|BetaAnalyticsCostGroupShape $group
     */
    public function withGroup(BetaAnalyticsCostGroup|array $group): self
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
}
