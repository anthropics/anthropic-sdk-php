<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Analytics\AnalyticsUserActivity;

use Anthropic\Beta\Organization\Analytics\AnalyticsChatCoworkUnifiedChatMetrics;
use Anthropic\Beta\Organization\Analytics\AnalyticsChatCoworkUnifiedSessionsMetrics;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Activity recorded while the member had Chat and Cowork unified (Cowork's features inside claude.ai chat) turned on, split into `chat` (chat activity) and `sessions` (Cowork activity). Omitted from the response on deployments that do not offer Chat and Cowork unified.
 *
 * @phpstan-import-type AnalyticsChatCoworkUnifiedChatMetricsShape from \Anthropic\Beta\Organization\Analytics\AnalyticsChatCoworkUnifiedChatMetrics
 * @phpstan-import-type AnalyticsChatCoworkUnifiedSessionsMetricsShape from \Anthropic\Beta\Organization\Analytics\AnalyticsChatCoworkUnifiedSessionsMetrics
 *
 * @phpstan-type ChatCoworkUnifiedMetricsShape = array{
 *   chat: AnalyticsChatCoworkUnifiedChatMetrics|AnalyticsChatCoworkUnifiedChatMetricsShape,
 *   sessions: AnalyticsChatCoworkUnifiedSessionsMetrics|AnalyticsChatCoworkUnifiedSessionsMetricsShape,
 * }
 */
final class ChatCoworkUnifiedMetrics implements BaseModel
{
    /** @use SdkModel<ChatCoworkUnifiedMetricsShape> */
    use SdkModel;

    /**
     * Chat activity recorded while members had Chat and Cowork unified turned
     * on.
     */
    #[Required]
    public AnalyticsChatCoworkUnifiedChatMetrics $chat;

    /**
     * Cowork session activity recorded while members had Chat and Cowork
     * unified turned on.
     */
    #[Required]
    public AnalyticsChatCoworkUnifiedSessionsMetrics $sessions;

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
     * @param AnalyticsChatCoworkUnifiedChatMetrics|AnalyticsChatCoworkUnifiedChatMetricsShape $chat
     * @param AnalyticsChatCoworkUnifiedSessionsMetrics|AnalyticsChatCoworkUnifiedSessionsMetricsShape $sessions
     */
    public static function with(
        AnalyticsChatCoworkUnifiedChatMetrics|array $chat,
        AnalyticsChatCoworkUnifiedSessionsMetrics|array $sessions,
    ): self {
        $self = new self;

        $self['chat'] = $chat;
        $self['sessions'] = $sessions;

        return $self;
    }

    /**
     * Chat activity recorded while members had Chat and Cowork unified turned
     * on.
     *
     * @param AnalyticsChatCoworkUnifiedChatMetrics|AnalyticsChatCoworkUnifiedChatMetricsShape $chat
     */
    public function withChat(
        AnalyticsChatCoworkUnifiedChatMetrics|array $chat
    ): self {
        $self = clone $this;
        $self['chat'] = $chat;

        return $self;
    }

    /**
     * Cowork session activity recorded while members had Chat and Cowork
     * unified turned on.
     *
     * @param AnalyticsChatCoworkUnifiedSessionsMetrics|AnalyticsChatCoworkUnifiedSessionsMetricsShape $sessions
     */
    public function withSessions(
        AnalyticsChatCoworkUnifiedSessionsMetrics|array $sessions
    ): self {
        $self = clone $this;
        $self['sessions'] = $sessions;

        return $self;
    }
}
