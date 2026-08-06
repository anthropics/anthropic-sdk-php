<?php

declare(strict_types=1);

namespace Anthropic\ServiceContracts\Beta\Sessions\Threads;

use Anthropic\Beta\AnthropicBeta;
use Anthropic\Beta\Sessions\BetaManagedAgentsDeltaEvent;
use Anthropic\Beta\Sessions\BetaManagedAgentsDeltaType;
use Anthropic\Beta\Sessions\BetaManagedAgentsSessionUpdatedEvent;
use Anthropic\Beta\Sessions\BetaManagedAgentsSessionUsageEvent;
use Anthropic\Beta\Sessions\BetaManagedAgentsStartEvent;
use Anthropic\Beta\Sessions\BetaManagedAgentsSystemMessageEvent;
use Anthropic\Beta\Sessions\BetaManagedAgentsUserToolResultEvent;
use Anthropic\Beta\Sessions\Events\ManagedAgentsAgentCustomToolUseEvent;
use Anthropic\Beta\Sessions\Events\ManagedAgentsAgentMCPToolResultEvent;
use Anthropic\Beta\Sessions\Events\ManagedAgentsAgentMCPToolUseEvent;
use Anthropic\Beta\Sessions\Events\ManagedAgentsAgentMessageEvent;
use Anthropic\Beta\Sessions\Events\ManagedAgentsAgentThinkingEvent;
use Anthropic\Beta\Sessions\Events\ManagedAgentsAgentThreadContextCompactedEvent;
use Anthropic\Beta\Sessions\Events\ManagedAgentsAgentThreadMessageReceivedEvent;
use Anthropic\Beta\Sessions\Events\ManagedAgentsAgentThreadMessageSentEvent;
use Anthropic\Beta\Sessions\Events\ManagedAgentsAgentToolResultEvent;
use Anthropic\Beta\Sessions\Events\ManagedAgentsAgentToolUseEvent;
use Anthropic\Beta\Sessions\Events\ManagedAgentsSessionDeletedEvent;
use Anthropic\Beta\Sessions\Events\ManagedAgentsSessionErrorEvent;
use Anthropic\Beta\Sessions\Events\ManagedAgentsSessionStatusIdleEvent;
use Anthropic\Beta\Sessions\Events\ManagedAgentsSessionStatusRescheduledEvent;
use Anthropic\Beta\Sessions\Events\ManagedAgentsSessionStatusRunningEvent;
use Anthropic\Beta\Sessions\Events\ManagedAgentsSessionStatusTerminatedEvent;
use Anthropic\Beta\Sessions\Events\ManagedAgentsSessionThreadCreatedEvent;
use Anthropic\Beta\Sessions\Events\ManagedAgentsSessionThreadStatusIdleEvent;
use Anthropic\Beta\Sessions\Events\ManagedAgentsSessionThreadStatusRescheduledEvent;
use Anthropic\Beta\Sessions\Events\ManagedAgentsSessionThreadStatusRunningEvent;
use Anthropic\Beta\Sessions\Events\ManagedAgentsSessionThreadStatusTerminatedEvent;
use Anthropic\Beta\Sessions\Events\ManagedAgentsSpanModelRequestEndEvent;
use Anthropic\Beta\Sessions\Events\ManagedAgentsSpanModelRequestStartEvent;
use Anthropic\Beta\Sessions\Events\ManagedAgentsSpanOutcomeEvaluationEndEvent;
use Anthropic\Beta\Sessions\Events\ManagedAgentsSpanOutcomeEvaluationOngoingEvent;
use Anthropic\Beta\Sessions\Events\ManagedAgentsSpanOutcomeEvaluationStartEvent;
use Anthropic\Beta\Sessions\Events\ManagedAgentsUserCustomToolResultEvent;
use Anthropic\Beta\Sessions\Events\ManagedAgentsUserDefineOutcomeEvent;
use Anthropic\Beta\Sessions\Events\ManagedAgentsUserInterruptEvent;
use Anthropic\Beta\Sessions\Events\ManagedAgentsUserMessageEvent;
use Anthropic\Beta\Sessions\Events\ManagedAgentsUserToolConfirmationEvent;
use Anthropic\Core\Contracts\BaseStream;
use Anthropic\Core\Exceptions\APIException;
use Anthropic\PageCursor;
use Anthropic\RequestOptions;

/**
 * @phpstan-import-type RequestOpts from \Anthropic\RequestOptions
 */
interface EventsContract
{
    /**
     * @api
     *
     * @param string $threadID Path param: Path parameter thread_id
     * @param string $sessionID Path param: Path parameter session_id
     * @param int $limit Query param: Query parameter for limit
     * @param string $page Query param: Query parameter for page
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @return PageCursor<ManagedAgentsUserMessageEvent|ManagedAgentsUserInterruptEvent|ManagedAgentsUserToolConfirmationEvent|ManagedAgentsUserCustomToolResultEvent|ManagedAgentsAgentCustomToolUseEvent|ManagedAgentsAgentMessageEvent|ManagedAgentsAgentThinkingEvent|ManagedAgentsAgentMCPToolUseEvent|ManagedAgentsAgentMCPToolResultEvent|ManagedAgentsAgentToolUseEvent|ManagedAgentsAgentToolResultEvent|ManagedAgentsAgentThreadMessageReceivedEvent|ManagedAgentsAgentThreadMessageSentEvent|ManagedAgentsAgentThreadContextCompactedEvent|ManagedAgentsSessionErrorEvent|ManagedAgentsSessionStatusRescheduledEvent|ManagedAgentsSessionStatusRunningEvent|ManagedAgentsSessionStatusIdleEvent|ManagedAgentsSessionStatusTerminatedEvent|ManagedAgentsSessionThreadCreatedEvent|ManagedAgentsSpanOutcomeEvaluationStartEvent|ManagedAgentsSpanOutcomeEvaluationEndEvent|ManagedAgentsSpanModelRequestStartEvent|ManagedAgentsSpanModelRequestEndEvent|ManagedAgentsSpanOutcomeEvaluationOngoingEvent|ManagedAgentsUserDefineOutcomeEvent|ManagedAgentsSessionDeletedEvent|ManagedAgentsSessionThreadStatusRunningEvent|ManagedAgentsSessionThreadStatusIdleEvent|ManagedAgentsSessionThreadStatusTerminatedEvent|BetaManagedAgentsUserToolResultEvent|ManagedAgentsSessionThreadStatusRescheduledEvent|BetaManagedAgentsSessionUpdatedEvent|BetaManagedAgentsSystemMessageEvent|BetaManagedAgentsSessionUsageEvent,>
     *
     * @throws APIException
     */
    public function list(
        string $threadID,
        string $sessionID,
        ?int $limit = null,
        ?string $page = null,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): PageCursor;

    /**
     * @api
     *
     * @param string $threadID Path param: Path parameter thread_id
     * @param string $sessionID Path param: Path parameter session_id
     * @param list<BetaManagedAgentsDeltaType|value-of<BetaManagedAgentsDeltaType>> $eventDeltas Query param: When set, this connection also receives streaming deltas (`event_start`, `event_delta`) while an event is being produced, before the event itself arrives. Deltas are best-effort; when the final event is produced it carries the complete content. A model request that ends early (an error or interrupt) produces no final event — its terminal `span.model_request_end` closes the preview. Accepts one or more event types to preview and may be repeated: `agent.message` streams `content_delta` fragments; `agent.thinking` is start-only — a signal that the agent has begun extended thinking, concluded by the `agent.thinking` event itself. Only previews of the requested event types are sent.
     * @param list<string|AnthropicBeta|value-of<AnthropicBeta>> $betas header param: Optional header to specify the beta version(s) you want to use
     * @param RequestOpts|null $requestOptions
     *
     * @return BaseStream<ManagedAgentsUserMessageEvent|ManagedAgentsUserInterruptEvent|ManagedAgentsUserToolConfirmationEvent|ManagedAgentsUserCustomToolResultEvent|ManagedAgentsAgentCustomToolUseEvent|ManagedAgentsAgentMessageEvent|ManagedAgentsAgentThinkingEvent|ManagedAgentsAgentMCPToolUseEvent|ManagedAgentsAgentMCPToolResultEvent|ManagedAgentsAgentToolUseEvent|ManagedAgentsAgentToolResultEvent|ManagedAgentsAgentThreadMessageReceivedEvent|ManagedAgentsAgentThreadMessageSentEvent|ManagedAgentsAgentThreadContextCompactedEvent|ManagedAgentsSessionErrorEvent|ManagedAgentsSessionStatusRescheduledEvent|ManagedAgentsSessionStatusRunningEvent|ManagedAgentsSessionStatusIdleEvent|ManagedAgentsSessionStatusTerminatedEvent|ManagedAgentsSessionThreadCreatedEvent|ManagedAgentsSpanOutcomeEvaluationStartEvent|ManagedAgentsSpanOutcomeEvaluationEndEvent|ManagedAgentsSpanModelRequestStartEvent|ManagedAgentsSpanModelRequestEndEvent|ManagedAgentsSpanOutcomeEvaluationOngoingEvent|ManagedAgentsUserDefineOutcomeEvent|ManagedAgentsSessionDeletedEvent|ManagedAgentsSessionThreadStatusRunningEvent|ManagedAgentsSessionThreadStatusIdleEvent|ManagedAgentsSessionThreadStatusTerminatedEvent|BetaManagedAgentsUserToolResultEvent|ManagedAgentsSessionThreadStatusRescheduledEvent|BetaManagedAgentsSessionUpdatedEvent|BetaManagedAgentsStartEvent|BetaManagedAgentsDeltaEvent|BetaManagedAgentsSystemMessageEvent|BetaManagedAgentsSessionUsageEvent,>
     *
     * @throws APIException
     */
    public function streamStream(
        string $threadID,
        string $sessionID,
        ?array $eventDeltas = null,
        ?array $betas = null,
        RequestOptions|array|null $requestOptions = null,
    ): BaseStream;
}
