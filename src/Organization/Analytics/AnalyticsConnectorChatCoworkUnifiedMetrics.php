<?php

declare(strict_types=1);

namespace Anthropic\Organization\Analytics;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * A connector's use in Chat and Cowork unified on one day: `chat` holds its
 * use in chat conversations and `sessions` its use in Cowork sessions.
 *
 * @phpstan-import-type AnalyticsConnectorChatCoworkUnifiedChatMetricsShape from \Anthropic\Organization\Analytics\AnalyticsConnectorChatCoworkUnifiedChatMetrics
 * @phpstan-import-type AnalyticsConnectorChatCoworkUnifiedSessionsMetricsShape from \Anthropic\Organization\Analytics\AnalyticsConnectorChatCoworkUnifiedSessionsMetrics
 *
 * @phpstan-type AnalyticsConnectorChatCoworkUnifiedMetricsShape = array{
 *   chat: AnalyticsConnectorChatCoworkUnifiedChatMetrics|AnalyticsConnectorChatCoworkUnifiedChatMetricsShape,
 *   sessions: AnalyticsConnectorChatCoworkUnifiedSessionsMetrics|AnalyticsConnectorChatCoworkUnifiedSessionsMetricsShape,
 * }
 */
final class AnalyticsConnectorChatCoworkUnifiedMetrics implements BaseModel
{
    /** @use SdkModel<AnalyticsConnectorChatCoworkUnifiedMetricsShape> */
    use SdkModel;

    /**
     * A connector's use in chat conversations recorded while members had
     * Chat and Cowork unified turned on.
     */
    #[Required]
    public AnalyticsConnectorChatCoworkUnifiedChatMetrics $chat;

    /**
     * A connector's use in Cowork sessions recorded while members had
     * Chat and Cowork unified turned on.
     */
    #[Required]
    public AnalyticsConnectorChatCoworkUnifiedSessionsMetrics $sessions;

    /**
     * `new AnalyticsConnectorChatCoworkUnifiedMetrics()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * AnalyticsConnectorChatCoworkUnifiedMetrics::with(chat: ..., sessions: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new AnalyticsConnectorChatCoworkUnifiedMetrics())
     *   ->withChat(...)
     *   ->withSessions(...)
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
     * @param AnalyticsConnectorChatCoworkUnifiedChatMetrics|AnalyticsConnectorChatCoworkUnifiedChatMetricsShape $chat
     * @param AnalyticsConnectorChatCoworkUnifiedSessionsMetrics|AnalyticsConnectorChatCoworkUnifiedSessionsMetricsShape $sessions
     */
    public static function with(
        AnalyticsConnectorChatCoworkUnifiedChatMetrics|array $chat,
        AnalyticsConnectorChatCoworkUnifiedSessionsMetrics|array $sessions,
    ): self {
        $self = new self;

        $self['chat'] = $chat;
        $self['sessions'] = $sessions;

        return $self;
    }

    /**
     * A connector's use in chat conversations recorded while members had
     * Chat and Cowork unified turned on.
     *
     * @param AnalyticsConnectorChatCoworkUnifiedChatMetrics|AnalyticsConnectorChatCoworkUnifiedChatMetricsShape $chat
     */
    public function withChat(
        AnalyticsConnectorChatCoworkUnifiedChatMetrics|array $chat
    ): self {
        $self = clone $this;
        $self['chat'] = $chat;

        return $self;
    }

    /**
     * A connector's use in Cowork sessions recorded while members had
     * Chat and Cowork unified turned on.
     *
     * @param AnalyticsConnectorChatCoworkUnifiedSessionsMetrics|AnalyticsConnectorChatCoworkUnifiedSessionsMetricsShape $sessions
     */
    public function withSessions(
        AnalyticsConnectorChatCoworkUnifiedSessionsMetrics|array $sessions
    ): self {
        $self = clone $this;
        $self['sessions'] = $sessions;

        return $self;
    }
}
