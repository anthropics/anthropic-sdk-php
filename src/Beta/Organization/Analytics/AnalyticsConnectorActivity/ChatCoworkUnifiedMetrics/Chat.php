<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Analytics\AnalyticsConnectorActivity\ChatCoworkUnifiedMetrics;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * A connector's use in chat conversations recorded while members had
 * Chat and Cowork unified turned on.
 *
 * @phpstan-type ChatShape = array{
 *   distinctConversationConnectorUsedCount: int|null
 * }
 */
final class Chat implements BaseModel
{
    /** @use SdkModel<ChatShape> */
    use SdkModel;

    /**
     * Same measure as `chat_metrics.distinct_conversation_connector_used_count`, for activity recorded while members had Chat and Cowork unified turned on. Approximate (HLL, typical error <2%) in date-range mode. Null on aggregated rows where a distinct count cannot be computed.
     */
    #[Required('distinct_conversation_connector_used_count')]
    public ?int $distinctConversationConnectorUsedCount;

    /**
     * `new Chat()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Chat::with(distinctConversationConnectorUsedCount: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Chat())->withDistinctConversationConnectorUsedCount(...)
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
     * Same measure as `chat_metrics.distinct_conversation_connector_used_count`, for activity recorded while members had Chat and Cowork unified turned on. Approximate (HLL, typical error <2%) in date-range mode. Null on aggregated rows where a distinct count cannot be computed.
     */
    public function withDistinctConversationConnectorUsedCount(
        ?int $distinctConversationConnectorUsedCount
    ): self {
        $self = clone $this;
        $self['distinctConversationConnectorUsedCount'] = $distinctConversationConnectorUsedCount;

        return $self;
    }
}
