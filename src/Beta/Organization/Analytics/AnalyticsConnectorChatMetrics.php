<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Analytics;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Claude.ai activity metrics for a single connector on a given day.
 *
 * @phpstan-type AnalyticsConnectorChatMetricsShape = array{
 *   distinctConversationConnectorUsedCount: int|null
 * }
 */
final class AnalyticsConnectorChatMetrics implements BaseModel
{
    /** @use SdkModel<AnalyticsConnectorChatMetricsShape> */
    use SdkModel;

    /**
     * Number of distinct conversations in which the connector was used. Approximate (HLL, typical error <2%) in date-range mode. Null on aggregated rows where a distinct count cannot be computed.
     */
    #[Required('distinct_conversation_connector_used_count')]
    public ?int $distinctConversationConnectorUsedCount;

    /**
     * `new AnalyticsConnectorChatMetrics()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * AnalyticsConnectorChatMetrics::with(distinctConversationConnectorUsedCount: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new AnalyticsConnectorChatMetrics())
     *   ->withDistinctConversationConnectorUsedCount(...)
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
        ?int $distinctConversationConnectorUsedCount
    ): self {
        $self = new self;

        $self['distinctConversationConnectorUsedCount'] = $distinctConversationConnectorUsedCount;

        return $self;
    }

    /**
     * Number of distinct conversations in which the connector was used. Approximate (HLL, typical error <2%) in date-range mode. Null on aggregated rows where a distinct count cannot be computed.
     */
    public function withDistinctConversationConnectorUsedCount(
        ?int $distinctConversationConnectorUsedCount
    ): self {
        $self = clone $this;
        $self['distinctConversationConnectorUsedCount'] = $distinctConversationConnectorUsedCount;

        return $self;
    }
}
