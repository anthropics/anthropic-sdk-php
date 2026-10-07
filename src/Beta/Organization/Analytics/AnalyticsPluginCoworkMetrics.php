<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Analytics;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Cowork activity metrics for a single plugin on a given day.
 *
 * @phpstan-type AnalyticsPluginCoworkMetricsShape = array{
 *   distinctSessionPluginUsedCount: int|null
 * }
 */
final class AnalyticsPluginCoworkMetrics implements BaseModel
{
    /** @use SdkModel<AnalyticsPluginCoworkMetricsShape> */
    use SdkModel;

    /**
     * Number of distinct Cowork sessions in which the plugin was invoked. Null on aggregated rows where a distinct count cannot be computed.
     */
    #[Required('distinct_session_plugin_used_count')]
    public ?int $distinctSessionPluginUsedCount;

    /**
     * `new AnalyticsPluginCoworkMetrics()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * AnalyticsPluginCoworkMetrics::with(distinctSessionPluginUsedCount: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new AnalyticsPluginCoworkMetrics())->withDistinctSessionPluginUsedCount(...)
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
    public static function with(?int $distinctSessionPluginUsedCount): self
    {
        $self = new self;

        $self['distinctSessionPluginUsedCount'] = $distinctSessionPluginUsedCount;

        return $self;
    }

    /**
     * Number of distinct Cowork sessions in which the plugin was invoked. Null on aggregated rows where a distinct count cannot be computed.
     */
    public function withDistinctSessionPluginUsedCount(
        ?int $distinctSessionPluginUsedCount
    ): self {
        $self = clone $this;
        $self['distinctSessionPluginUsedCount'] = $distinctSessionPluginUsedCount;

        return $self;
    }
}
