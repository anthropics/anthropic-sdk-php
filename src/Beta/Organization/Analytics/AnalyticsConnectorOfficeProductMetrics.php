<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Analytics;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Office Agent activity metrics for a single connector on a given day within one Office product.
 *
 * @phpstan-type AnalyticsConnectorOfficeProductMetricsShape = array{
 *   distinctSessionConnectorUsedCount: int|null
 * }
 */
final class AnalyticsConnectorOfficeProductMetrics implements BaseModel
{
    /** @use SdkModel<AnalyticsConnectorOfficeProductMetricsShape> */
    use SdkModel;

    /**
     * Number of distinct Office Agent sessions in which the connector was used. Approximate (HLL, typical error <2%) in date-range mode. Null on aggregated rows where a distinct count cannot be computed.
     */
    #[Required('distinct_session_connector_used_count')]
    public ?int $distinctSessionConnectorUsedCount;

    /**
     * `new AnalyticsConnectorOfficeProductMetrics()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * AnalyticsConnectorOfficeProductMetrics::with(
     *   distinctSessionConnectorUsedCount: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new AnalyticsConnectorOfficeProductMetrics())
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
     * Number of distinct Office Agent sessions in which the connector was used. Approximate (HLL, typical error <2%) in date-range mode. Null on aggregated rows where a distinct count cannot be computed.
     */
    public function withDistinctSessionConnectorUsedCount(
        ?int $distinctSessionConnectorUsedCount
    ): self {
        $self = clone $this;
        $self['distinctSessionConnectorUsedCount'] = $distinctSessionConnectorUsedCount;

        return $self;
    }
}
