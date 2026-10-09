<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Analytics;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * A skill's use in chat conversations recorded while members had
 * Chat and Cowork unified turned on.
 *
 * @phpstan-type AnalyticsSkillChatCoworkUnifiedChatMetricsShape = array{
 *   distinctConversationSkillUsedCount: int|null
 * }
 */
final class AnalyticsSkillChatCoworkUnifiedChatMetrics implements BaseModel
{
    /** @use SdkModel<AnalyticsSkillChatCoworkUnifiedChatMetricsShape> */
    use SdkModel;

    /**
     * Same measure as `chat_metrics.distinct_conversation_skill_used_count`, for activity recorded while members had Chat and Cowork unified turned on. Approximate (HLL, typical error <2%) in date-range mode. Null on aggregated rows where a distinct count cannot be computed.
     */
    #[Required('distinct_conversation_skill_used_count')]
    public ?int $distinctConversationSkillUsedCount;

    /**
     * `new AnalyticsSkillChatCoworkUnifiedChatMetrics()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * AnalyticsSkillChatCoworkUnifiedChatMetrics::with(
     *   distinctConversationSkillUsedCount: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new AnalyticsSkillChatCoworkUnifiedChatMetrics())
     *   ->withDistinctConversationSkillUsedCount(...)
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
    public static function with(?int $distinctConversationSkillUsedCount): self
    {
        $self = new self;

        $self['distinctConversationSkillUsedCount'] = $distinctConversationSkillUsedCount;

        return $self;
    }

    /**
     * Same measure as `chat_metrics.distinct_conversation_skill_used_count`, for activity recorded while members had Chat and Cowork unified turned on. Approximate (HLL, typical error <2%) in date-range mode. Null on aggregated rows where a distinct count cannot be computed.
     */
    public function withDistinctConversationSkillUsedCount(
        ?int $distinctConversationSkillUsedCount
    ): self {
        $self = clone $this;
        $self['distinctConversationSkillUsedCount'] = $distinctConversationSkillUsedCount;

        return $self;
    }
}
