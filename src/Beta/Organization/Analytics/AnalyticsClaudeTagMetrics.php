<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Analytics;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Claude Tag activity metrics for a single linked user on a given day.
 *
 * @phpstan-type AnalyticsClaudeTagMetricsShape = array{
 *   activeDayCount: int|null, activeMessageCount: int|null
 * }
 */
final class AnalyticsClaudeTagMetrics implements BaseModel
{
    /** @use SdkModel<AnalyticsClaudeTagMetricsShape> */
    use SdkModel;

    /**
     * 1 on a day the user was active in Claude Tag in Slack, otherwise 0. Summed over the window in date-range mode, so it is the number of active days; on grouped rows, the total of each member's active days. Null when Claude Tag data cannot be read for the request. Otherwise, 0 on a row filtered by project, and null on any other row when no covered day was measured.
     */
    #[Required('active_day_count')]
    public ?int $activeDayCount;

    /**
     * Number of the user's Slack messages that made them active: @-mentions, direct messages, group direct message asks, and thread posts Claude answered. Other messages are not counted. Null when Claude Tag data cannot be read for the request. Otherwise, 0 on a row filtered by project, and null on any other row when no covered day was measured.
     */
    #[Required('active_message_count')]
    public ?int $activeMessageCount;

    /**
     * `new AnalyticsClaudeTagMetrics()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * AnalyticsClaudeTagMetrics::with(activeDayCount: ..., activeMessageCount: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new AnalyticsClaudeTagMetrics())
     *   ->withActiveDayCount(...)
     *   ->withActiveMessageCount(...)
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
        ?int $activeDayCount,
        ?int $activeMessageCount
    ): self {
        $self = new self;

        $self['activeDayCount'] = $activeDayCount;
        $self['activeMessageCount'] = $activeMessageCount;

        return $self;
    }

    /**
     * 1 on a day the user was active in Claude Tag in Slack, otherwise 0. Summed over the window in date-range mode, so it is the number of active days; on grouped rows, the total of each member's active days. Null when Claude Tag data cannot be read for the request. Otherwise, 0 on a row filtered by project, and null on any other row when no covered day was measured.
     */
    public function withActiveDayCount(?int $activeDayCount): self
    {
        $self = clone $this;
        $self['activeDayCount'] = $activeDayCount;

        return $self;
    }

    /**
     * Number of the user's Slack messages that made them active: @-mentions, direct messages, group direct message asks, and thread posts Claude answered. Other messages are not counted. Null when Claude Tag data cannot be read for the request. Otherwise, 0 on a row filtered by project, and null on any other row when no covered day was measured.
     */
    public function withActiveMessageCount(?int $activeMessageCount): self
    {
        $self = clone $this;
        $self['activeMessageCount'] = $activeMessageCount;

        return $self;
    }
}
