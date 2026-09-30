<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Analytics;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Accepted/rejected counts for a single Claude Code tool type.
 *
 * @phpstan-type AnalyticsToolActionCountsShape = array{
 *   acceptedCount: int, rejectedCount: int
 * }
 */
final class AnalyticsToolActionCounts implements BaseModel
{
    /** @use SdkModel<AnalyticsToolActionCountsShape> */
    use SdkModel;

    /**
     * Number of tool proposals accepted.
     */
    #[Required('accepted_count')]
    public int $acceptedCount;

    /**
     * Number of tool proposals rejected.
     */
    #[Required('rejected_count')]
    public int $rejectedCount;

    /**
     * `new AnalyticsToolActionCounts()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * AnalyticsToolActionCounts::with(acceptedCount: ..., rejectedCount: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new AnalyticsToolActionCounts)->withAcceptedCount(...)->withRejectedCount(...)
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
    public static function with(int $acceptedCount, int $rejectedCount): self
    {
        $self = new self;

        $self['acceptedCount'] = $acceptedCount;
        $self['rejectedCount'] = $rejectedCount;

        return $self;
    }

    /**
     * Number of tool proposals accepted.
     */
    public function withAcceptedCount(int $acceptedCount): self
    {
        $self = clone $this;
        $self['acceptedCount'] = $acceptedCount;

        return $self;
    }

    /**
     * Number of tool proposals rejected.
     */
    public function withRejectedCount(int $rejectedCount): self
    {
        $self = clone $this;
        $self['rejectedCount'] = $rejectedCount;

        return $self;
    }
}
