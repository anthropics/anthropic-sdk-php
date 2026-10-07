<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Analytics;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Claude.ai activity metrics for a single skill on a given day.
 *
 * @phpstan-type AnalyticsSkillChatMetricsShape = array{
 *   distinctConversationSkillUsedCount: int|null
 * }
 */
final class AnalyticsSkillChatMetrics implements BaseModel
{
    /** @use SdkModel<AnalyticsSkillChatMetricsShape> */
    use SdkModel;

    /**
     * Number of distinct conversations in which the skill was used. A skill counts as used only when it is explicitly activated — the model (or the user, via the skill's slash command) invokes it, reading its instructions into context as part of that activation. Skills that are merely installed or listed as available, or whose content reaches the context without an activation (preloaded, hook-injected, or read as a plain file), are not counted. Approximate (HLL, typical error <2%) in date-range mode. Null on aggregated rows where a distinct count cannot be computed.
     */
    #[Required('distinct_conversation_skill_used_count')]
    public ?int $distinctConversationSkillUsedCount;

    /**
     * `new AnalyticsSkillChatMetrics()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * AnalyticsSkillChatMetrics::with(distinctConversationSkillUsedCount: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new AnalyticsSkillChatMetrics())->withDistinctConversationSkillUsedCount(...)
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
     * Number of distinct conversations in which the skill was used. A skill counts as used only when it is explicitly activated — the model (or the user, via the skill's slash command) invokes it, reading its instructions into context as part of that activation. Skills that are merely installed or listed as available, or whose content reaches the context without an activation (preloaded, hook-injected, or read as a plain file), are not counted. Approximate (HLL, typical error <2%) in date-range mode. Null on aggregated rows where a distinct count cannot be computed.
     */
    public function withDistinctConversationSkillUsedCount(
        ?int $distinctConversationSkillUsedCount
    ): self {
        $self = clone $this;
        $self['distinctConversationSkillUsedCount'] = $distinctConversationSkillUsedCount;

        return $self;
    }
}
