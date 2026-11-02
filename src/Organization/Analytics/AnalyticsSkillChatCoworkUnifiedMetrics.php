<?php

declare(strict_types=1);

namespace Anthropic\Organization\Analytics;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * A skill's use in Chat and Cowork unified on one day: `chat` holds its use
 * in chat conversations and `sessions` its use in Cowork sessions.
 *
 * @phpstan-import-type AnalyticsSkillChatCoworkUnifiedChatMetricsShape from \Anthropic\Organization\Analytics\AnalyticsSkillChatCoworkUnifiedChatMetrics
 * @phpstan-import-type AnalyticsSkillChatCoworkUnifiedSessionsMetricsShape from \Anthropic\Organization\Analytics\AnalyticsSkillChatCoworkUnifiedSessionsMetrics
 *
 * @phpstan-type AnalyticsSkillChatCoworkUnifiedMetricsShape = array{
 *   chat: AnalyticsSkillChatCoworkUnifiedChatMetrics|AnalyticsSkillChatCoworkUnifiedChatMetricsShape,
 *   sessions: AnalyticsSkillChatCoworkUnifiedSessionsMetrics|AnalyticsSkillChatCoworkUnifiedSessionsMetricsShape,
 * }
 */
final class AnalyticsSkillChatCoworkUnifiedMetrics implements BaseModel
{
    /** @use SdkModel<AnalyticsSkillChatCoworkUnifiedMetricsShape> */
    use SdkModel;

    /**
     * A skill's use in chat conversations recorded while members had
     * Chat and Cowork unified turned on.
     */
    #[Required]
    public AnalyticsSkillChatCoworkUnifiedChatMetrics $chat;

    /**
     * A skill's use in Cowork sessions recorded while members had Chat
     * and Cowork unified turned on.
     */
    #[Required]
    public AnalyticsSkillChatCoworkUnifiedSessionsMetrics $sessions;

    /**
     * `new AnalyticsSkillChatCoworkUnifiedMetrics()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * AnalyticsSkillChatCoworkUnifiedMetrics::with(chat: ..., sessions: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new AnalyticsSkillChatCoworkUnifiedMetrics())->withChat(...)->withSessions(...)
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
     *
     * @param AnalyticsSkillChatCoworkUnifiedChatMetrics|AnalyticsSkillChatCoworkUnifiedChatMetricsShape $chat
     * @param AnalyticsSkillChatCoworkUnifiedSessionsMetrics|AnalyticsSkillChatCoworkUnifiedSessionsMetricsShape $sessions
     */
    public static function with(
        AnalyticsSkillChatCoworkUnifiedChatMetrics|array $chat,
        AnalyticsSkillChatCoworkUnifiedSessionsMetrics|array $sessions,
    ): self {
        $self = new self;

        $self['chat'] = $chat;
        $self['sessions'] = $sessions;

        return $self;
    }

    /**
     * A skill's use in chat conversations recorded while members had
     * Chat and Cowork unified turned on.
     *
     * @param AnalyticsSkillChatCoworkUnifiedChatMetrics|AnalyticsSkillChatCoworkUnifiedChatMetricsShape $chat
     */
    public function withChat(
        AnalyticsSkillChatCoworkUnifiedChatMetrics|array $chat
    ): self {
        $self = clone $this;
        $self['chat'] = $chat;

        return $self;
    }

    /**
     * A skill's use in Cowork sessions recorded while members had Chat
     * and Cowork unified turned on.
     *
     * @param AnalyticsSkillChatCoworkUnifiedSessionsMetrics|AnalyticsSkillChatCoworkUnifiedSessionsMetricsShape $sessions
     */
    public function withSessions(
        AnalyticsSkillChatCoworkUnifiedSessionsMetrics|array $sessions
    ): self {
        $self = clone $this;
        $self['sessions'] = $sessions;

        return $self;
    }
}
