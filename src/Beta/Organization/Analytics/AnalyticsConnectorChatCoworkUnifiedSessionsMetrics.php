<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Analytics;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * A connector's use in Cowork sessions recorded while members had
 * Chat and Cowork unified turned on.
 *
 * @phpstan-type AnalyticsConnectorChatCoworkUnifiedSessionsMetricsShape = array{
 *   distinctSessionConnectorUsedCount: int|null
 * }
 */
final class AnalyticsConnectorChatCoworkUnifiedSessionsMetrics implements BaseModel
{
    /** @use SdkModel<AnalyticsConnectorChatCoworkUnifiedSessionsMetricsShape> */
    use SdkModel;

    /**
     * Same measure as `cowork_metrics.distinct_session_connector_used_count`, for activity recorded while members had Chat and Cowork unified turned on. Approximate (HLL, typical error <2%) in date-range mode. Null on aggregated rows where a distinct count cannot be computed.
     */
    #[Required('distinct_session_connector_used_count')]
    public ?int $distinctSessionConnectorUsedCount;

    /**
     * `new AnalyticsConnectorChatCoworkUnifiedSessionsMetrics()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * AnalyticsConnectorChatCoworkUnifiedSessionsMetrics::with(
     *   distinctSessionConnectorUsedCount: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new AnalyticsConnectorChatCoworkUnifiedSessionsMetrics())
     *   ->withDistinctSessionConnectorUsedCount(...)
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
    public static function with(?int $distinctSessionConnectorUsedCount): self
    {
        $self = new self;

        $self['distinctSessionConnectorUsedCount'] = $distinctSessionConnectorUsedCount;

        return $self;
    }

    /**
     * Same measure as `cowork_metrics.distinct_session_connector_used_count`, for activity recorded while members had Chat and Cowork unified turned on. Approximate (HLL, typical error <2%) in date-range mode. Null on aggregated rows where a distinct count cannot be computed.
     */
    public function withDistinctSessionConnectorUsedCount(
        ?int $distinctSessionConnectorUsedCount
    ): self {
        $self = clone $this;
        $self['distinctSessionConnectorUsedCount'] = $distinctSessionConnectorUsedCount;

        return $self;
    }
}
