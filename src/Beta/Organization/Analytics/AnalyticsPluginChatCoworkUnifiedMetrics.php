<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Analytics;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * A plugin's use in Cowork sessions recorded while members had Chat
 * and Cowork unified turned on.
 *
 * @phpstan-type AnalyticsPluginChatCoworkUnifiedMetricsShape = array{
 *   distinctSessionPluginUsedCount: int|null
 * }
 */
final class AnalyticsPluginChatCoworkUnifiedMetrics implements BaseModel
{
    /** @use SdkModel<AnalyticsPluginChatCoworkUnifiedMetricsShape> */
    use SdkModel;

    /**
     * Same measure as `cowork_metrics.distinct_session_plugin_used_count`, for activity recorded while members had Chat and Cowork unified turned on. Null on aggregated rows where a distinct count cannot be computed.
     */
    #[Required('distinct_session_plugin_used_count')]
    public ?int $distinctSessionPluginUsedCount;

    /**
     * `new AnalyticsPluginChatCoworkUnifiedMetrics()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * AnalyticsPluginChatCoworkUnifiedMetrics::with(
     *   distinctSessionPluginUsedCount: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new AnalyticsPluginChatCoworkUnifiedMetrics())
     *   ->withDistinctSessionPluginUsedCount(...)
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
     * Same measure as `cowork_metrics.distinct_session_plugin_used_count`, for activity recorded while members had Chat and Cowork unified turned on. Null on aggregated rows where a distinct count cannot be computed.
     */
    public function withDistinctSessionPluginUsedCount(
        ?int $distinctSessionPluginUsedCount
    ): self {
        $self = clone $this;
        $self['distinctSessionPluginUsedCount'] = $distinctSessionPluginUsedCount;

        return $self;
    }
}
