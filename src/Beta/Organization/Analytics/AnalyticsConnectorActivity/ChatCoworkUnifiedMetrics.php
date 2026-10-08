<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Analytics\AnalyticsConnectorActivity;

use Anthropic\Beta\Organization\Analytics\AnalyticsConnectorActivity\ChatCoworkUnifiedMetrics\Chat;
use Anthropic\Beta\Organization\Analytics\AnalyticsConnectorActivity\ChatCoworkUnifiedMetrics\Sessions;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * Connector use recorded while members had Chat and Cowork unified (Cowork's features inside claude.ai chat) turned on, split into chat conversations and Cowork sessions. A count is null in date-range mode where it cannot be computed. Omitted from the response on deployments that do not offer Chat and Cowork unified.
 *
 * @phpstan-import-type ChatShape from \Anthropic\Beta\Organization\Analytics\AnalyticsConnectorActivity\ChatCoworkUnifiedMetrics\Chat
 * @phpstan-import-type SessionsShape from \Anthropic\Beta\Organization\Analytics\AnalyticsConnectorActivity\ChatCoworkUnifiedMetrics\Sessions
 *
 * @phpstan-type ChatCoworkUnifiedMetricsShape = array{
 *   chat: Chat|ChatShape, sessions: Sessions|SessionsShape
 * }
 */
final class ChatCoworkUnifiedMetrics implements BaseModel
{
    /** @use SdkModel<ChatCoworkUnifiedMetricsShape> */
    use SdkModel;

    /**
     * A connector's use in chat conversations recorded while members had
     * Chat and Cowork unified turned on.
     */
    #[Required]
    public Chat $chat;

    /**
     * A connector's use in Cowork sessions recorded while members had
     * Chat and Cowork unified turned on.
     */
    #[Required]
    public Sessions $sessions;

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
     * @param Chat|ChatShape $chat
     * @param Sessions|SessionsShape $sessions
     */
    public static function with(
        Chat|array $chat,
        Sessions|array $sessions
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
     * @param Chat|ChatShape $chat
     */
    public function withChat(Chat|array $chat): self
    {
        $self = clone $this;
        $self['chat'] = $chat;

        return $self;
    }

    /**
     * A connector's use in Cowork sessions recorded while members had
     * Chat and Cowork unified turned on.
     *
     * @param Sessions|SessionsShape $sessions
     */
    public function withSessions(Sessions|array $sessions): self
    {
        $self = clone $this;
        $self['sessions'] = $sessions;

        return $self;
    }
}
