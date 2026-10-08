<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Analytics\AnalyticsPluginActivity;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Plugin use recorded while members had Chat and Cowork unified (Cowork's features inside claude.ai chat) turned on. A count is null in date-range mode where it cannot be computed. Omitted from the response on deployments that do not offer Chat and Cowork unified.
 *
 * @phpstan-type ChatCoworkUnifiedMetricsShape = array{
 *   distinctSessionPluginUsedCount: int|null
 * }
 */
final class ChatCoworkUnifiedMetrics implements BaseModel
{
    /** @use SdkModel<ChatCoworkUnifiedMetricsShape> */
    use SdkModel;

    /**
     * Same measure as `cowork_metrics.distinct_session_plugin_used_count`, for activity recorded while members had Chat and Cowork unified turned on. Null on aggregated rows where a distinct count cannot be computed.
     */
    #[Required('distinct_session_plugin_used_count')]
    public ?int $distinctSessionPluginUsedCount;

    /**
     * `new ChatCoworkUnifiedMetrics()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ChatCoworkUnifiedMetrics::with(distinctSessionPluginUsedCount: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ChatCoworkUnifiedMetrics())->withDistinctSessionPluginUsedCount(...)
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
