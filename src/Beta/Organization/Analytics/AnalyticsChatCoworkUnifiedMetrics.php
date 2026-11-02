<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Analytics;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Activity in Chat and Cowork unified for one user on one day: `chat` holds
 * chat activity and `sessions` holds Cowork session activity.
 *
 * @phpstan-import-type AnalyticsChatCoworkUnifiedChatMetricsShape from \Anthropic\Beta\Organization\Analytics\AnalyticsChatCoworkUnifiedChatMetrics
 * @phpstan-import-type AnalyticsChatCoworkUnifiedSessionsMetricsShape from \Anthropic\Beta\Organization\Analytics\AnalyticsChatCoworkUnifiedSessionsMetrics
 *
 * @phpstan-type AnalyticsChatCoworkUnifiedMetricsShape = array{
 *   chat: AnalyticsChatCoworkUnifiedChatMetrics|AnalyticsChatCoworkUnifiedChatMetricsShape,
 *   sessions: AnalyticsChatCoworkUnifiedSessionsMetrics|AnalyticsChatCoworkUnifiedSessionsMetricsShape,
 * }
 */
final class AnalyticsChatCoworkUnifiedMetrics implements BaseModel
{
    /** @use SdkModel<AnalyticsChatCoworkUnifiedMetricsShape> */
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
     * `new AnalyticsChatCoworkUnifiedMetrics()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * AnalyticsChatCoworkUnifiedMetrics::with(chat: ..., sessions: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new AnalyticsChatCoworkUnifiedMetrics())->withChat(...)->withSessions(...)
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
