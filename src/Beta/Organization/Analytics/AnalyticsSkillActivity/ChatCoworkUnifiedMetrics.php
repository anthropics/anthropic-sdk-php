<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Analytics\AnalyticsSkillActivity;

use Anthropic\Beta\Organization\Analytics\AnalyticsSkillChatCoworkUnifiedChatMetrics;
use Anthropic\Beta\Organization\Analytics\AnalyticsSkillChatCoworkUnifiedSessionsMetrics;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Skill use recorded while members had Chat and Cowork unified (Cowork's features inside claude.ai chat) turned on, split into chat conversations and Cowork sessions. A count is null in date-range mode where it cannot be computed. Omitted from the response on deployments that do not offer Chat and Cowork unified.
 *
 * @phpstan-import-type AnalyticsSkillChatCoworkUnifiedChatMetricsShape from \Anthropic\Beta\Organization\Analytics\AnalyticsSkillChatCoworkUnifiedChatMetrics
 * @phpstan-import-type AnalyticsSkillChatCoworkUnifiedSessionsMetricsShape from \Anthropic\Beta\Organization\Analytics\AnalyticsSkillChatCoworkUnifiedSessionsMetrics
 *
 * @phpstan-type ChatCoworkUnifiedMetricsShape = array{
 *   chat: AnalyticsSkillChatCoworkUnifiedChatMetrics|AnalyticsSkillChatCoworkUnifiedChatMetricsShape,
 *   sessions: AnalyticsSkillChatCoworkUnifiedSessionsMetrics|AnalyticsSkillChatCoworkUnifiedSessionsMetricsShape,
 * }
 */
final class ChatCoworkUnifiedMetrics implements BaseModel
{
    /** @use SdkModel<ChatCoworkUnifiedMetricsShape> */
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
     * `new ChatCoworkUnifiedMetrics()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ChatCoworkUnifiedMetrics::with(chat: ..., sessions: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ChatCoworkUnifiedMetrics())->withChat(...)->withSessions(...)
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
