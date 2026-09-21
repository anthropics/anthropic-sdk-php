<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

use Anthropic\Beta\Sessions\BetaManagedAgentsAgentMessagePreview;
use Anthropic\Beta\Sessions\BetaManagedAgentsAgentThinkingPreview;
use Anthropic\Beta\Sessions\BetaManagedAgentsBudgetLimit;
use Anthropic\Beta\Sessions\BetaManagedAgentsDeltaContent;
use Anthropic\Beta\Sessions\BetaManagedAgentsDeltaEvent;
use Anthropic\Beta\Sessions\BetaManagedAgentsSessionAgent;
use Anthropic\Beta\Sessions\BetaManagedAgentsSessionUpdatedEvent;
use Anthropic\Beta\Sessions\BetaManagedAgentsSessionUsageEvent;
use Anthropic\Beta\Sessions\BetaManagedAgentsStartEvent;
use Anthropic\Beta\Sessions\BetaManagedAgentsSystemContentBlock;
use Anthropic\Beta\Sessions\BetaManagedAgentsSystemMessageEvent;
use Anthropic\Beta\Sessions\BetaManagedAgentsUserToolResultEvent;
use Anthropic\Beta\Sessions\Events\ManagedAgentsStreamSessionEvents\Type;
use Anthropic\Beta\Sessions\Events\ManagedAgentsUserToolConfirmationEvent\Result;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Server-sent event in the session stream.
 *
 * @phpstan-import-type ManagedAgentsUserMessageEventShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsUserMessageEvent
 * @phpstan-import-type ManagedAgentsUserInterruptEventShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsUserInterruptEvent
 * @phpstan-import-type ManagedAgentsUserToolConfirmationEventShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsUserToolConfirmationEvent
 * @phpstan-import-type ManagedAgentsUserCustomToolResultEventShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsUserCustomToolResultEvent
 * @phpstan-import-type ManagedAgentsAgentCustomToolUseEventShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsAgentCustomToolUseEvent
 * @phpstan-import-type ManagedAgentsAgentMessageEventShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsAgentMessageEvent
 * @phpstan-import-type ManagedAgentsAgentThinkingEventShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsAgentThinkingEvent
 * @phpstan-import-type ManagedAgentsAgentMCPToolUseEventShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsAgentMCPToolUseEvent
 * @phpstan-import-type ManagedAgentsAgentMCPToolResultEventShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsAgentMCPToolResultEvent
 * @phpstan-import-type ManagedAgentsAgentToolUseEventShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsAgentToolUseEvent
 * @phpstan-import-type ManagedAgentsAgentToolResultEventShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsAgentToolResultEvent
 * @phpstan-import-type ManagedAgentsAgentThreadMessageReceivedEventShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsAgentThreadMessageReceivedEvent
 * @phpstan-import-type ManagedAgentsAgentThreadMessageSentEventShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsAgentThreadMessageSentEvent
 * @phpstan-import-type ManagedAgentsAgentThreadContextCompactedEventShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsAgentThreadContextCompactedEvent
 * @phpstan-import-type ManagedAgentsSessionErrorEventShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsSessionErrorEvent
 * @phpstan-import-type ManagedAgentsSessionStatusRescheduledEventShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsSessionStatusRescheduledEvent
 * @phpstan-import-type ManagedAgentsSessionStatusRunningEventShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsSessionStatusRunningEvent
 * @phpstan-import-type ManagedAgentsSessionStatusIdleEventShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsSessionStatusIdleEvent
 * @phpstan-import-type ManagedAgentsSessionStatusTerminatedEventShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsSessionStatusTerminatedEvent
 * @phpstan-import-type ManagedAgentsSessionThreadCreatedEventShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsSessionThreadCreatedEvent
 * @phpstan-import-type ManagedAgentsSpanOutcomeEvaluationStartEventShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsSpanOutcomeEvaluationStartEvent
 * @phpstan-import-type ManagedAgentsSpanOutcomeEvaluationEndEventShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsSpanOutcomeEvaluationEndEvent
 * @phpstan-import-type ManagedAgentsSpanModelRequestStartEventShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsSpanModelRequestStartEvent
 * @phpstan-import-type ManagedAgentsSpanModelRequestEndEventShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsSpanModelRequestEndEvent
 * @phpstan-import-type ManagedAgentsSpanOutcomeEvaluationOngoingEventShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsSpanOutcomeEvaluationOngoingEvent
 * @phpstan-import-type ManagedAgentsUserDefineOutcomeEventShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsUserDefineOutcomeEvent
 * @phpstan-import-type ManagedAgentsSessionDeletedEventShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsSessionDeletedEvent
 * @phpstan-import-type ManagedAgentsSessionThreadStatusRunningEventShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsSessionThreadStatusRunningEvent
 * @phpstan-import-type ManagedAgentsSessionThreadStatusIdleEventShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsSessionThreadStatusIdleEvent
 * @phpstan-import-type ManagedAgentsSessionThreadStatusTerminatedEventShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsSessionThreadStatusTerminatedEvent
 * @phpstan-import-type BetaManagedAgentsUserToolResultEventShape from \Anthropic\Beta\Sessions\BetaManagedAgentsUserToolResultEvent
 * @phpstan-import-type ManagedAgentsSessionThreadStatusRescheduledEventShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsSessionThreadStatusRescheduledEvent
 * @phpstan-import-type BetaManagedAgentsSessionUpdatedEventShape from \Anthropic\Beta\Sessions\BetaManagedAgentsSessionUpdatedEvent
 * @phpstan-import-type BetaManagedAgentsStartEventShape from \Anthropic\Beta\Sessions\BetaManagedAgentsStartEvent
 * @phpstan-import-type BetaManagedAgentsDeltaEventShape from \Anthropic\Beta\Sessions\BetaManagedAgentsDeltaEvent
 * @phpstan-import-type BetaManagedAgentsSystemMessageEventShape from \Anthropic\Beta\Sessions\BetaManagedAgentsSystemMessageEvent
 * @phpstan-import-type BetaManagedAgentsSessionUsageEventShape from \Anthropic\Beta\Sessions\BetaManagedAgentsSessionUsageEvent
 * @phpstan-import-type ContentShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsUserMessageEvent\Content
 * @phpstan-import-type ContentShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsUserCustomToolResultEvent\Content as ContentShape1
 * @phpstan-import-type ContentShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsAgentMessageEvent\Content as ContentShape2
 * @phpstan-import-type ContentShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsAgentMCPToolResultEvent\Content as ContentShape3
 * @phpstan-import-type ContentShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsAgentToolResultEvent\Content as ContentShape4
 * @phpstan-import-type ContentShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsAgentThreadMessageReceivedEvent\Content as ContentShape5
 * @phpstan-import-type ContentShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsAgentThreadMessageSentEvent\Content as ContentShape6
 * @phpstan-import-type ContentShape from \Anthropic\Beta\Sessions\BetaManagedAgentsUserToolResultEvent\Content as ContentShape7
 * @phpstan-import-type BetaManagedAgentsSystemContentBlockShape from \Anthropic\Beta\Sessions\BetaManagedAgentsSystemContentBlock
 * @phpstan-import-type ManagedAgentsAgentToolEvaluationShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsAgentToolEvaluation
 * @phpstan-import-type ErrorShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsSessionErrorEvent\Error
 * @phpstan-import-type StopReasonShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsSessionStatusIdleEvent\StopReason
 * @phpstan-import-type StopReasonShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsSessionThreadStatusIdleEvent\StopReason as StopReasonShape1
 * @phpstan-import-type ManagedAgentsSessionUsageSnapshotShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsSessionUsageSnapshot
 * @phpstan-import-type RubricShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsUserDefineOutcomeEvent\Rubric
 * @phpstan-import-type BetaManagedAgentsSessionAgentShape from \Anthropic\Beta\Sessions\BetaManagedAgentsSessionAgent
 * @phpstan-import-type BetaManagedAgentsBudgetLimitShape from \Anthropic\Beta\Sessions\BetaManagedAgentsBudgetLimit
 * @phpstan-import-type BetaManagedAgentsStartEventPreviewShape from \Anthropic\Beta\Sessions\BetaManagedAgentsStartEventPreview
 * @phpstan-import-type BetaManagedAgentsDeltaContentShape from \Anthropic\Beta\Sessions\BetaManagedAgentsDeltaContent
 * @phpstan-import-type ManagedAgentsSpanModelUsageShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsSpanModelUsage
 *
 * @phpstan-type ManagedAgentsStreamSessionEventsVariants = ManagedAgentsUserMessageEvent|ManagedAgentsUserInterruptEvent|ManagedAgentsUserToolConfirmationEvent|ManagedAgentsUserCustomToolResultEvent|ManagedAgentsAgentCustomToolUseEvent|ManagedAgentsAgentMessageEvent|ManagedAgentsAgentThinkingEvent|ManagedAgentsAgentMCPToolUseEvent|ManagedAgentsAgentMCPToolResultEvent|ManagedAgentsAgentToolUseEvent|ManagedAgentsAgentToolResultEvent|ManagedAgentsAgentThreadMessageReceivedEvent|ManagedAgentsAgentThreadMessageSentEvent|ManagedAgentsAgentThreadContextCompactedEvent|ManagedAgentsSessionErrorEvent|ManagedAgentsSessionStatusRescheduledEvent|ManagedAgentsSessionStatusRunningEvent|ManagedAgentsSessionStatusIdleEvent|ManagedAgentsSessionStatusTerminatedEvent|ManagedAgentsSessionThreadCreatedEvent|ManagedAgentsSpanOutcomeEvaluationStartEvent|ManagedAgentsSpanOutcomeEvaluationEndEvent|ManagedAgentsSpanModelRequestStartEvent|ManagedAgentsSpanModelRequestEndEvent|ManagedAgentsSpanOutcomeEvaluationOngoingEvent|ManagedAgentsUserDefineOutcomeEvent|ManagedAgentsSessionDeletedEvent|ManagedAgentsSessionThreadStatusRunningEvent|ManagedAgentsSessionThreadStatusIdleEvent|ManagedAgentsSessionThreadStatusTerminatedEvent|BetaManagedAgentsUserToolResultEvent|ManagedAgentsSessionThreadStatusRescheduledEvent|BetaManagedAgentsSessionUpdatedEvent|BetaManagedAgentsStartEvent|BetaManagedAgentsDeltaEvent|BetaManagedAgentsSystemMessageEvent|BetaManagedAgentsSessionUsageEvent
 * @phpstan-type ManagedAgentsStreamSessionEventsShape = ManagedAgentsStreamSessionEventsVariants|ManagedAgentsUserMessageEventShape|ManagedAgentsUserInterruptEventShape|ManagedAgentsUserToolConfirmationEventShape|ManagedAgentsUserCustomToolResultEventShape|ManagedAgentsAgentCustomToolUseEventShape|ManagedAgentsAgentMessageEventShape|ManagedAgentsAgentThinkingEventShape|ManagedAgentsAgentMCPToolUseEventShape|ManagedAgentsAgentMCPToolResultEventShape|ManagedAgentsAgentToolUseEventShape|ManagedAgentsAgentToolResultEventShape|ManagedAgentsAgentThreadMessageReceivedEventShape|ManagedAgentsAgentThreadMessageSentEventShape|ManagedAgentsAgentThreadContextCompactedEventShape|ManagedAgentsSessionErrorEventShape|ManagedAgentsSessionStatusRescheduledEventShape|ManagedAgentsSessionStatusRunningEventShape|ManagedAgentsSessionStatusIdleEventShape|ManagedAgentsSessionStatusTerminatedEventShape|ManagedAgentsSessionThreadCreatedEventShape|ManagedAgentsSpanOutcomeEvaluationStartEventShape|ManagedAgentsSpanOutcomeEvaluationEndEventShape|ManagedAgentsSpanModelRequestStartEventShape|ManagedAgentsSpanModelRequestEndEventShape|ManagedAgentsSpanOutcomeEvaluationOngoingEventShape|ManagedAgentsUserDefineOutcomeEventShape|ManagedAgentsSessionDeletedEventShape|ManagedAgentsSessionThreadStatusRunningEventShape|ManagedAgentsSessionThreadStatusIdleEventShape|ManagedAgentsSessionThreadStatusTerminatedEventShape|BetaManagedAgentsUserToolResultEventShape|ManagedAgentsSessionThreadStatusRescheduledEventShape|BetaManagedAgentsSessionUpdatedEventShape|BetaManagedAgentsStartEventShape|BetaManagedAgentsDeltaEventShape|BetaManagedAgentsSystemMessageEventShape|BetaManagedAgentsSessionUsageEventShape
 */
final class ManagedAgentsStreamSessionEvents implements ConverterSource
{
    use SdkUnion;

    public static function discriminator(): string
    {
        return 'type';
    }

    /**
     * @return list<string|Converter|ConverterSource>|array<string,string|Converter|ConverterSource>
     */
    public static function variants(): array
    {
        return [
            'user.message' => ManagedAgentsUserMessageEvent::class,
            'user.interrupt' => ManagedAgentsUserInterruptEvent::class,
            'user.tool_confirmation' => ManagedAgentsUserToolConfirmationEvent::class,
            'user.custom_tool_result' => ManagedAgentsUserCustomToolResultEvent::class,
            'agent.custom_tool_use' => ManagedAgentsAgentCustomToolUseEvent::class,
            'agent.message' => ManagedAgentsAgentMessageEvent::class,
            'agent.thinking' => ManagedAgentsAgentThinkingEvent::class,
            'agent.mcp_tool_use' => ManagedAgentsAgentMCPToolUseEvent::class,
            'agent.mcp_tool_result' => ManagedAgentsAgentMCPToolResultEvent::class,
            'agent.tool_use' => ManagedAgentsAgentToolUseEvent::class,
            'agent.tool_result' => ManagedAgentsAgentToolResultEvent::class,
            'agent.thread_message_received' => ManagedAgentsAgentThreadMessageReceivedEvent::class,
            'agent.thread_message_sent' => ManagedAgentsAgentThreadMessageSentEvent::class,
            'agent.thread_context_compacted' => ManagedAgentsAgentThreadContextCompactedEvent::class,
            'session.error' => ManagedAgentsSessionErrorEvent::class,
            'session.status_rescheduled' => ManagedAgentsSessionStatusRescheduledEvent::class,
            'session.status_running' => ManagedAgentsSessionStatusRunningEvent::class,
            'session.status_idle' => ManagedAgentsSessionStatusIdleEvent::class,
            'session.status_terminated' => ManagedAgentsSessionStatusTerminatedEvent::class,
            'session.thread_created' => ManagedAgentsSessionThreadCreatedEvent::class,
            'span.outcome_evaluation_start' => ManagedAgentsSpanOutcomeEvaluationStartEvent::class,
            'span.outcome_evaluation_end' => ManagedAgentsSpanOutcomeEvaluationEndEvent::class,
            'span.model_request_start' => ManagedAgentsSpanModelRequestStartEvent::class,
            'span.model_request_end' => ManagedAgentsSpanModelRequestEndEvent::class,
            'span.outcome_evaluation_ongoing' => ManagedAgentsSpanOutcomeEvaluationOngoingEvent::class,
            'user.define_outcome' => ManagedAgentsUserDefineOutcomeEvent::class,
            'session.deleted' => ManagedAgentsSessionDeletedEvent::class,
            'session.thread_status_running' => ManagedAgentsSessionThreadStatusRunningEvent::class,
            'session.thread_status_idle' => ManagedAgentsSessionThreadStatusIdleEvent::class,
            'session.thread_status_terminated' => ManagedAgentsSessionThreadStatusTerminatedEvent::class,
            'user.tool_result' => BetaManagedAgentsUserToolResultEvent::class,
            'session.thread_status_rescheduled' => ManagedAgentsSessionThreadStatusRescheduledEvent::class,
            'session.updated' => BetaManagedAgentsSessionUpdatedEvent::class,
            'event_start' => BetaManagedAgentsStartEvent::class,
            'event_delta' => BetaManagedAgentsDeltaEvent::class,
            'system.message' => BetaManagedAgentsSystemMessageEvent::class,
            'session.usage' => BetaManagedAgentsSessionUsageEvent::class,
        ];
    }

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @param ($type is Type::USER_MESSAGE|'user.message' ? list<ContentShape>|null : ($type is Type::USER_CUSTOM_TOOL_RESULT|'user.custom_tool_result' ? list<ContentShape1>|null : ($type is Type::AGENT_MESSAGE|'agent.message' ? list<ContentShape2>|null : ($type is Type::AGENT_MCP_TOOL_RESULT|'agent.mcp_tool_result' ? list<ContentShape3>|null : ($type is Type::AGENT_TOOL_RESULT|'agent.tool_result' ? list<ContentShape4>|null : ($type is Type::AGENT_THREAD_MESSAGE_RECEIVED|'agent.thread_message_received' ? list<ContentShape5>|null : ($type is Type::AGENT_THREAD_MESSAGE_SENT|'agent.thread_message_sent' ? list<ContentShape6>|null : ($type is Type::USER_TOOL_RESULT|'user.tool_result' ? list<ContentShape7>|null : list<BetaManagedAgentsSystemContentBlock|BetaManagedAgentsSystemContentBlockShape>|null)))))))) $content
     * @param ($type is Type::USER_TOOL_CONFIRMATION|'user.tool_confirmation' ? Result|value-of<Result>|null : string|null) $result
     * @param array<string,mixed>|null $input
     * @param ManagedAgentsAgentEvaluatedPermission|value-of<ManagedAgentsAgentEvaluatedPermission>|null $evaluatedPermission
     * @param ManagedAgentsAgentToolEvaluationShape|null $evaluation
     * @param ErrorShape|null $error
     * @param ($type is Type::SESSION_STATUS_IDLE|'session.status_idle' ? StopReasonShape|null : StopReasonShape1|null) $stopReason
     * @param ($type is Type::SPAN_OUTCOME_EVALUATION_END|'span.outcome_evaluation_end' ? ManagedAgentsSpanModelUsage|ManagedAgentsSpanModelUsageShape|null : ManagedAgentsSessionUsageSnapshot|ManagedAgentsSessionUsageSnapshotShape|null) $usage
     * @param ManagedAgentsSpanModelUsage|ManagedAgentsSpanModelUsageShape|null $modelUsage
     * @param RubricShape|null $rubric
     * @param BetaManagedAgentsSessionAgent|BetaManagedAgentsSessionAgentShape|null $agent
     * @param BetaManagedAgentsBudgetLimit|BetaManagedAgentsBudgetLimitShape|null $budget
     * @param array<string,string>|null $metadata
     * @param BetaManagedAgentsStartEventPreviewShape|null $event
     * @param BetaManagedAgentsDeltaContent|BetaManagedAgentsDeltaContentShape|null $delta
     *
     * @return ($type is Type::USER_MESSAGE|'user.message' ? ManagedAgentsUserMessageEvent : ($type is Type::USER_INTERRUPT|'user.interrupt' ? ManagedAgentsUserInterruptEvent : ($type is Type::USER_TOOL_CONFIRMATION|'user.tool_confirmation' ? ManagedAgentsUserToolConfirmationEvent : ($type is Type::USER_CUSTOM_TOOL_RESULT|'user.custom_tool_result' ? ManagedAgentsUserCustomToolResultEvent : ($type is Type::AGENT_CUSTOM_TOOL_USE|'agent.custom_tool_use' ? ManagedAgentsAgentCustomToolUseEvent : ($type is Type::AGENT_MESSAGE|'agent.message' ? ManagedAgentsAgentMessageEvent : ($type is Type::AGENT_THINKING|'agent.thinking' ? ManagedAgentsAgentThinkingEvent : ($type is Type::AGENT_MCP_TOOL_USE|'agent.mcp_tool_use' ? ManagedAgentsAgentMCPToolUseEvent : ($type is Type::AGENT_MCP_TOOL_RESULT|'agent.mcp_tool_result' ? ManagedAgentsAgentMCPToolResultEvent : ($type is Type::AGENT_TOOL_USE|'agent.tool_use' ? ManagedAgentsAgentToolUseEvent : ($type is Type::AGENT_TOOL_RESULT|'agent.tool_result' ? ManagedAgentsAgentToolResultEvent : ($type is Type::AGENT_THREAD_MESSAGE_RECEIVED|'agent.thread_message_received' ? ManagedAgentsAgentThreadMessageReceivedEvent : ($type is Type::AGENT_THREAD_MESSAGE_SENT|'agent.thread_message_sent' ? ManagedAgentsAgentThreadMessageSentEvent : ($type is Type::AGENT_THREAD_CONTEXT_COMPACTED|'agent.thread_context_compacted' ? ManagedAgentsAgentThreadContextCompactedEvent : ($type is Type::SESSION_ERROR|'session.error' ? ManagedAgentsSessionErrorEvent : ($type is Type::SESSION_STATUS_RESCHEDULED|'session.status_rescheduled' ? ManagedAgentsSessionStatusRescheduledEvent : ($type is Type::SESSION_STATUS_RUNNING|'session.status_running' ? ManagedAgentsSessionStatusRunningEvent : ($type is Type::SESSION_STATUS_IDLE|'session.status_idle' ? ManagedAgentsSessionStatusIdleEvent : ($type is Type::SESSION_STATUS_TERMINATED|'session.status_terminated' ? ManagedAgentsSessionStatusTerminatedEvent : ($type is Type::SESSION_THREAD_CREATED|'session.thread_created' ? ManagedAgentsSessionThreadCreatedEvent : ($type is Type::SPAN_OUTCOME_EVALUATION_START|'span.outcome_evaluation_start' ? ManagedAgentsSpanOutcomeEvaluationStartEvent : ($type is Type::SPAN_OUTCOME_EVALUATION_END|'span.outcome_evaluation_end' ? ManagedAgentsSpanOutcomeEvaluationEndEvent : ($type is Type::SPAN_MODEL_REQUEST_START|'span.model_request_start' ? ManagedAgentsSpanModelRequestStartEvent : ($type is Type::SPAN_MODEL_REQUEST_END|'span.model_request_end' ? ManagedAgentsSpanModelRequestEndEvent : ($type is Type::SPAN_OUTCOME_EVALUATION_ONGOING|'span.outcome_evaluation_ongoing' ? ManagedAgentsSpanOutcomeEvaluationOngoingEvent : ($type is Type::USER_DEFINE_OUTCOME|'user.define_outcome' ? ManagedAgentsUserDefineOutcomeEvent : ($type is Type::SESSION_DELETED|'session.deleted' ? ManagedAgentsSessionDeletedEvent : ($type is Type::SESSION_THREAD_STATUS_RUNNING|'session.thread_status_running' ? ManagedAgentsSessionThreadStatusRunningEvent : ($type is Type::SESSION_THREAD_STATUS_IDLE|'session.thread_status_idle' ? ManagedAgentsSessionThreadStatusIdleEvent : ($type is Type::SESSION_THREAD_STATUS_TERMINATED|'session.thread_status_terminated' ? ManagedAgentsSessionThreadStatusTerminatedEvent : ($type is Type::USER_TOOL_RESULT|'user.tool_result' ? BetaManagedAgentsUserToolResultEvent : ($type is Type::SESSION_THREAD_STATUS_RESCHEDULED|'session.thread_status_rescheduled' ? ManagedAgentsSessionThreadStatusRescheduledEvent : ($type is Type::SESSION_UPDATED|'session.updated' ? BetaManagedAgentsSessionUpdatedEvent : ($type is Type::EVENT_START|'event_start' ? BetaManagedAgentsStartEvent : ($type is Type::EVENT_DELTA|'event_delta' ? BetaManagedAgentsDeltaEvent : ($type is Type::SYSTEM_MESSAGE|'system.message' ? BetaManagedAgentsSystemMessageEvent : ($type is Type::SESSION_USAGE|'session.usage' ? BetaManagedAgentsSessionUsageEvent : ManagedAgentsUserMessageEvent|ManagedAgentsUserInterruptEvent|ManagedAgentsUserToolConfirmationEvent|ManagedAgentsUserCustomToolResultEvent|ManagedAgentsAgentCustomToolUseEvent|ManagedAgentsAgentMessageEvent|ManagedAgentsAgentThinkingEvent|ManagedAgentsAgentMCPToolUseEvent|ManagedAgentsAgentMCPToolResultEvent|ManagedAgentsAgentToolUseEvent|ManagedAgentsAgentToolResultEvent|ManagedAgentsAgentThreadMessageReceivedEvent|ManagedAgentsAgentThreadMessageSentEvent|ManagedAgentsAgentThreadContextCompactedEvent|ManagedAgentsSessionErrorEvent|ManagedAgentsSessionStatusRescheduledEvent|ManagedAgentsSessionStatusRunningEvent|ManagedAgentsSessionStatusIdleEvent|ManagedAgentsSessionStatusTerminatedEvent|ManagedAgentsSessionThreadCreatedEvent|ManagedAgentsSpanOutcomeEvaluationStartEvent|ManagedAgentsSpanOutcomeEvaluationEndEvent|ManagedAgentsSpanModelRequestStartEvent|ManagedAgentsSpanModelRequestEndEvent|ManagedAgentsSpanOutcomeEvaluationOngoingEvent|ManagedAgentsUserDefineOutcomeEvent|ManagedAgentsSessionDeletedEvent|ManagedAgentsSessionThreadStatusRunningEvent|ManagedAgentsSessionThreadStatusIdleEvent|ManagedAgentsSessionThreadStatusTerminatedEvent|BetaManagedAgentsUserToolResultEvent|ManagedAgentsSessionThreadStatusRescheduledEvent|BetaManagedAgentsSessionUpdatedEvent|BetaManagedAgentsStartEvent|BetaManagedAgentsDeltaEvent|BetaManagedAgentsSystemMessageEvent|BetaManagedAgentsSessionUsageEvent)))))))))))))))))))))))))))))))))))))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        ?string $id = null,
        ?array $content = null,
        ?\DateTimeInterface $processedAt = null,
        ?string $sessionThreadID = null,
        string|Result|null $result = null,
        ?string $toolUseID = null,
        ?string $denyMessage = null,
        ?string $customToolUseID = null,
        ?bool $isError = null,
        ?array $input = null,
        ?string $name = null,
        ?string $mcpServerName = null,
        ManagedAgentsAgentEvaluatedPermission|string|null $evaluatedPermission = null,
        ManagedAgentsAgentToolEvaluationAlwaysAllow|array|ManagedAgentsAgentToolEvaluationAlwaysAsk|ManagedAgentsAgentToolEvaluationAuto|null $evaluation = null,
        ?string $mcpToolUseID = null,
        ?string $fromSessionThreadID = null,
        ?string $fromAgentName = null,
        ?string $toSessionThreadID = null,
        ?string $toAgentName = null,
        ManagedAgentsUnknownError|array|ManagedAgentsModelOverloadedError|ManagedAgentsModelRateLimitedError|ManagedAgentsModelRequestFailedError|ManagedAgentsMCPConnectionFailedError|ManagedAgentsMCPAuthenticationFailedError|ManagedAgentsBillingError|ManagedAgentsCredentialHostUnreachableError|null $error = null,
        ManagedAgentsSessionEndTurn|array|ManagedAgentsSessionRequiresAction|ManagedAgentsSessionRetriesExhausted|ManagedAgentsSessionBudgetReached|null $stopReason = null,
        ?string $agentName = null,
        ?int $iteration = null,
        ?string $outcomeID = null,
        ?string $explanation = null,
        ?string $outcomeEvaluationStartID = null,
        ManagedAgentsSpanModelUsage|array|ManagedAgentsSessionUsageSnapshot|null $usage = null,
        ?string $modelRequestStartID = null,
        ManagedAgentsSpanModelUsage|array|null $modelUsage = null,
        ?string $description = null,
        ?int $maxIterations = null,
        ManagedAgentsFileRubric|array|ManagedAgentsTextRubric|null $rubric = null,
        BetaManagedAgentsSessionAgent|array|null $agent = null,
        BetaManagedAgentsBudgetLimit|array|null $budget = null,
        ?array $metadata = null,
        ?string $title = null,
        BetaManagedAgentsAgentMessagePreview|array|BetaManagedAgentsAgentThinkingPreview|null $event = null,
        BetaManagedAgentsDeltaContent|array|null $delta = null,
        ?string $eventID = null,
    ): ManagedAgentsUserMessageEvent|ManagedAgentsUserInterruptEvent|ManagedAgentsUserToolConfirmationEvent|ManagedAgentsUserCustomToolResultEvent|ManagedAgentsAgentCustomToolUseEvent|ManagedAgentsAgentMessageEvent|ManagedAgentsAgentThinkingEvent|ManagedAgentsAgentMCPToolUseEvent|ManagedAgentsAgentMCPToolResultEvent|ManagedAgentsAgentToolUseEvent|ManagedAgentsAgentToolResultEvent|ManagedAgentsAgentThreadMessageReceivedEvent|ManagedAgentsAgentThreadMessageSentEvent|ManagedAgentsAgentThreadContextCompactedEvent|ManagedAgentsSessionErrorEvent|ManagedAgentsSessionStatusRescheduledEvent|ManagedAgentsSessionStatusRunningEvent|ManagedAgentsSessionStatusIdleEvent|ManagedAgentsSessionStatusTerminatedEvent|ManagedAgentsSessionThreadCreatedEvent|ManagedAgentsSpanOutcomeEvaluationStartEvent|ManagedAgentsSpanOutcomeEvaluationEndEvent|ManagedAgentsSpanModelRequestStartEvent|ManagedAgentsSpanModelRequestEndEvent|ManagedAgentsSpanOutcomeEvaluationOngoingEvent|ManagedAgentsUserDefineOutcomeEvent|ManagedAgentsSessionDeletedEvent|ManagedAgentsSessionThreadStatusRunningEvent|ManagedAgentsSessionThreadStatusIdleEvent|ManagedAgentsSessionThreadStatusTerminatedEvent|BetaManagedAgentsUserToolResultEvent|ManagedAgentsSessionThreadStatusRescheduledEvent|BetaManagedAgentsSessionUpdatedEvent|BetaManagedAgentsStartEvent|BetaManagedAgentsDeltaEvent|BetaManagedAgentsSystemMessageEvent|BetaManagedAgentsSessionUsageEvent {
        return match ($type) {
            Type::USER_MESSAGE, 'user.message' => ManagedAgentsUserMessageEvent::with(
                type: 'user.message',
                id: $id ?? throw new \ArgumentCountError('$id is required'),
                content: $content ?? throw new \ArgumentCountError('$content is required'),
                processedAt: $processedAt,
            ),
            Type::USER_INTERRUPT, 'user.interrupt' => ManagedAgentsUserInterruptEvent::with(
                type: 'user.interrupt',
                id: $id ?? throw new \ArgumentCountError('$id is required'),
                processedAt: $processedAt,
                sessionThreadID: $sessionThreadID,
            ),
            Type::USER_TOOL_CONFIRMATION, 'user.tool_confirmation' => ManagedAgentsUserToolConfirmationEvent::with(
                type: 'user.tool_confirmation',
                id: $id ?? throw new \ArgumentCountError('$id is required'),
                result: $result ?? throw new \ArgumentCountError('$result is required'),
                toolUseID: $toolUseID ?? throw new \ArgumentCountError('$toolUseID is required'),
                denyMessage: $denyMessage,
                processedAt: $processedAt,
                sessionThreadID: $sessionThreadID,
            ),
            Type::USER_CUSTOM_TOOL_RESULT, 'user.custom_tool_result' => ManagedAgentsUserCustomToolResultEvent::with(
                type: 'user.custom_tool_result',
                id: $id ?? throw new \ArgumentCountError('$id is required'),
                customToolUseID: $customToolUseID ?? throw new \ArgumentCountError('$customToolUseID is required'),
                // @phpstan-ignore argument.type
                content: $content,
                isError: $isError,
                processedAt: $processedAt,
                sessionThreadID: $sessionThreadID,
            ),
            Type::AGENT_CUSTOM_TOOL_USE, 'agent.custom_tool_use' => ManagedAgentsAgentCustomToolUseEvent::with(
                type: 'agent.custom_tool_use',
                id: $id ?? throw new \ArgumentCountError('$id is required'),
                input: $input ?? throw new \ArgumentCountError('$input is required'),
                name: $name ?? throw new \ArgumentCountError('$name is required'),
                processedAt: $processedAt ?? throw new \ArgumentCountError('$processedAt is required'),
                sessionThreadID: $sessionThreadID,
            ),
            Type::AGENT_MESSAGE, 'agent.message' => ManagedAgentsAgentMessageEvent::with(
                type: 'agent.message',
                id: $id ?? throw new \ArgumentCountError('$id is required'),
                // @phpstan-ignore argument.type
                content: $content ?? throw new \ArgumentCountError('$content is required'),
                processedAt: $processedAt ?? throw new \ArgumentCountError('$processedAt is required'),
            ),
            Type::AGENT_THINKING, 'agent.thinking' => ManagedAgentsAgentThinkingEvent::with(
                type: 'agent.thinking',
                id: $id ?? throw new \ArgumentCountError('$id is required'),
                processedAt: $processedAt ?? throw new \ArgumentCountError('$processedAt is required'),
            ),
            Type::AGENT_MCP_TOOL_USE, 'agent.mcp_tool_use' => ManagedAgentsAgentMCPToolUseEvent::with(
                type: 'agent.mcp_tool_use',
                id: $id ?? throw new \ArgumentCountError('$id is required'),
                input: $input ?? throw new \ArgumentCountError('$input is required'),
                mcpServerName: $mcpServerName ?? throw new \ArgumentCountError('$mcpServerName is required'),
                name: $name ?? throw new \ArgumentCountError('$name is required'),
                processedAt: $processedAt ?? throw new \ArgumentCountError('$processedAt is required'),
                evaluatedPermission: $evaluatedPermission,
                evaluation: $evaluation,
                sessionThreadID: $sessionThreadID,
            ),
            Type::AGENT_MCP_TOOL_RESULT, 'agent.mcp_tool_result' => ManagedAgentsAgentMCPToolResultEvent::with(
                type: 'agent.mcp_tool_result',
                id: $id ?? throw new \ArgumentCountError('$id is required'),
                mcpToolUseID: $mcpToolUseID ?? throw new \ArgumentCountError('$mcpToolUseID is required'),
                processedAt: $processedAt ?? throw new \ArgumentCountError('$processedAt is required'),
                // @phpstan-ignore argument.type
                content: $content,
                isError: $isError,
            ),
            Type::AGENT_TOOL_USE, 'agent.tool_use' => ManagedAgentsAgentToolUseEvent::with(
                type: 'agent.tool_use',
                id: $id ?? throw new \ArgumentCountError('$id is required'),
                input: $input ?? throw new \ArgumentCountError('$input is required'),
                name: $name ?? throw new \ArgumentCountError('$name is required'),
                processedAt: $processedAt ?? throw new \ArgumentCountError('$processedAt is required'),
                evaluatedPermission: $evaluatedPermission,
                evaluation: $evaluation,
                sessionThreadID: $sessionThreadID,
            ),
            Type::AGENT_TOOL_RESULT, 'agent.tool_result' => ManagedAgentsAgentToolResultEvent::with(
                type: 'agent.tool_result',
                id: $id ?? throw new \ArgumentCountError('$id is required'),
                processedAt: $processedAt ?? throw new \ArgumentCountError('$processedAt is required'),
                toolUseID: $toolUseID ?? throw new \ArgumentCountError('$toolUseID is required'),
                // @phpstan-ignore argument.type
                content: $content,
                isError: $isError,
            ),
            Type::AGENT_THREAD_MESSAGE_RECEIVED, 'agent.thread_message_received' => ManagedAgentsAgentThreadMessageReceivedEvent::with(
                type: 'agent.thread_message_received',
                id: $id ?? throw new \ArgumentCountError('$id is required'),
                // @phpstan-ignore argument.type
                content: $content ?? throw new \ArgumentCountError('$content is required'),
                fromSessionThreadID: $fromSessionThreadID ?? throw new \ArgumentCountError('$fromSessionThreadID is required'),
                processedAt: $processedAt ?? throw new \ArgumentCountError('$processedAt is required'),
                fromAgentName: $fromAgentName,
            ),
            Type::AGENT_THREAD_MESSAGE_SENT, 'agent.thread_message_sent' => ManagedAgentsAgentThreadMessageSentEvent::with(
                type: 'agent.thread_message_sent',
                id: $id ?? throw new \ArgumentCountError('$id is required'),
                // @phpstan-ignore argument.type
                content: $content ?? throw new \ArgumentCountError('$content is required'),
                processedAt: $processedAt ?? throw new \ArgumentCountError('$processedAt is required'),
                toSessionThreadID: $toSessionThreadID ?? throw new \ArgumentCountError('$toSessionThreadID is required'),
                toAgentName: $toAgentName,
            ),
            Type::AGENT_THREAD_CONTEXT_COMPACTED, 'agent.thread_context_compacted' => ManagedAgentsAgentThreadContextCompactedEvent::with(
                type: 'agent.thread_context_compacted',
                id: $id ?? throw new \ArgumentCountError('$id is required'),
                processedAt: $processedAt ?? throw new \ArgumentCountError('$processedAt is required'),
            ),
            Type::SESSION_ERROR, 'session.error' => ManagedAgentsSessionErrorEvent::with(
                type: 'session.error',
                id: $id ?? throw new \ArgumentCountError('$id is required'),
                error: $error ?? throw new \ArgumentCountError('$error is required'),
                processedAt: $processedAt ?? throw new \ArgumentCountError('$processedAt is required'),
            ),
            Type::SESSION_STATUS_RESCHEDULED, 'session.status_rescheduled' => ManagedAgentsSessionStatusRescheduledEvent::with(
                type: 'session.status_rescheduled',
                id: $id ?? throw new \ArgumentCountError('$id is required'),
                processedAt: $processedAt ?? throw new \ArgumentCountError('$processedAt is required'),
            ),
            Type::SESSION_STATUS_RUNNING, 'session.status_running' => ManagedAgentsSessionStatusRunningEvent::with(
                type: 'session.status_running',
                id: $id ?? throw new \ArgumentCountError('$id is required'),
                processedAt: $processedAt ?? throw new \ArgumentCountError('$processedAt is required'),
            ),
            Type::SESSION_STATUS_IDLE, 'session.status_idle' => ManagedAgentsSessionStatusIdleEvent::with(
                type: 'session.status_idle',
                id: $id ?? throw new \ArgumentCountError('$id is required'),
                processedAt: $processedAt ?? throw new \ArgumentCountError('$processedAt is required'),
                stopReason: $stopReason ?? throw new \ArgumentCountError('$stopReason is required'),
            ),
            Type::SESSION_STATUS_TERMINATED, 'session.status_terminated' => ManagedAgentsSessionStatusTerminatedEvent::with(
                type: 'session.status_terminated',
                id: $id ?? throw new \ArgumentCountError('$id is required'),
                processedAt: $processedAt ?? throw new \ArgumentCountError('$processedAt is required'),
            ),
            Type::SESSION_THREAD_CREATED, 'session.thread_created' => ManagedAgentsSessionThreadCreatedEvent::with(
                type: 'session.thread_created',
                id: $id ?? throw new \ArgumentCountError('$id is required'),
                agentName: $agentName ?? throw new \ArgumentCountError('$agentName is required'),
                processedAt: $processedAt ?? throw new \ArgumentCountError('$processedAt is required'),
                sessionThreadID: $sessionThreadID ?? throw new \ArgumentCountError('$sessionThreadID is required'),
            ),
            Type::SPAN_OUTCOME_EVALUATION_START, 'span.outcome_evaluation_start' => ManagedAgentsSpanOutcomeEvaluationStartEvent::with(
                type: 'span.outcome_evaluation_start',
                id: $id ?? throw new \ArgumentCountError('$id is required'),
                iteration: $iteration ?? throw new \ArgumentCountError('$iteration is required'),
                outcomeID: $outcomeID ?? throw new \ArgumentCountError('$outcomeID is required'),
                processedAt: $processedAt ?? throw new \ArgumentCountError('$processedAt is required'),
            ),
            Type::SPAN_OUTCOME_EVALUATION_END, 'span.outcome_evaluation_end' => ManagedAgentsSpanOutcomeEvaluationEndEvent::with(
                type: 'span.outcome_evaluation_end',
                id: $id ?? throw new \ArgumentCountError('$id is required'),
                explanation: $explanation ?? throw new \ArgumentCountError('$explanation is required'),
                iteration: $iteration ?? throw new \ArgumentCountError('$iteration is required'),
                outcomeEvaluationStartID: $outcomeEvaluationStartID ?? throw new \ArgumentCountError('$outcomeEvaluationStartID is required'),
                outcomeID: $outcomeID ?? throw new \ArgumentCountError('$outcomeID is required'),
                processedAt: $processedAt ?? throw new \ArgumentCountError('$processedAt is required'),
                // @phpstan-ignore argument.type
                result: $result ?? throw new \ArgumentCountError('$result is required'),
                usage: $usage ?? throw new \ArgumentCountError('$usage is required'),
            ),
            Type::SPAN_MODEL_REQUEST_START, 'span.model_request_start' => ManagedAgentsSpanModelRequestStartEvent::with(
                type: 'span.model_request_start',
                id: $id ?? throw new \ArgumentCountError('$id is required'),
                processedAt: $processedAt ?? throw new \ArgumentCountError('$processedAt is required'),
            ),
            Type::SPAN_MODEL_REQUEST_END, 'span.model_request_end' => ManagedAgentsSpanModelRequestEndEvent::with(
                type: 'span.model_request_end',
                id: $id ?? throw new \ArgumentCountError('$id is required'),
                isError: $isError,
                modelRequestStartID: $modelRequestStartID ?? throw new \ArgumentCountError('$modelRequestStartID is required'),
                modelUsage: $modelUsage ?? throw new \ArgumentCountError('$modelUsage is required'),
                processedAt: $processedAt ?? throw new \ArgumentCountError('$processedAt is required'),
            ),
            Type::SPAN_OUTCOME_EVALUATION_ONGOING, 'span.outcome_evaluation_ongoing' => ManagedAgentsSpanOutcomeEvaluationOngoingEvent::with(
                type: 'span.outcome_evaluation_ongoing',
                id: $id ?? throw new \ArgumentCountError('$id is required'),
                iteration: $iteration ?? throw new \ArgumentCountError('$iteration is required'),
                outcomeID: $outcomeID ?? throw new \ArgumentCountError('$outcomeID is required'),
                processedAt: $processedAt ?? throw new \ArgumentCountError('$processedAt is required'),
            ),
            Type::USER_DEFINE_OUTCOME, 'user.define_outcome' => ManagedAgentsUserDefineOutcomeEvent::with(
                type: 'user.define_outcome',
                id: $id ?? throw new \ArgumentCountError('$id is required'),
                description: $description ?? throw new \ArgumentCountError('$description is required'),
                maxIterations: $maxIterations,
                outcomeID: $outcomeID ?? throw new \ArgumentCountError('$outcomeID is required'),
                processedAt: $processedAt ?? throw new \ArgumentCountError('$processedAt is required'),
                rubric: $rubric ?? throw new \ArgumentCountError('$rubric is required'),
            ),
            Type::SESSION_DELETED, 'session.deleted' => ManagedAgentsSessionDeletedEvent::with(
                type: 'session.deleted',
                id: $id ?? throw new \ArgumentCountError('$id is required'),
                processedAt: $processedAt ?? throw new \ArgumentCountError('$processedAt is required'),
            ),
            Type::SESSION_THREAD_STATUS_RUNNING, 'session.thread_status_running' => ManagedAgentsSessionThreadStatusRunningEvent::with(
                type: 'session.thread_status_running',
                id: $id ?? throw new \ArgumentCountError('$id is required'),
                agentName: $agentName ?? throw new \ArgumentCountError('$agentName is required'),
                processedAt: $processedAt ?? throw new \ArgumentCountError('$processedAt is required'),
                sessionThreadID: $sessionThreadID ?? throw new \ArgumentCountError('$sessionThreadID is required'),
            ),
            Type::SESSION_THREAD_STATUS_IDLE, 'session.thread_status_idle' => ManagedAgentsSessionThreadStatusIdleEvent::with(
                type: 'session.thread_status_idle',
                id: $id ?? throw new \ArgumentCountError('$id is required'),
                agentName: $agentName ?? throw new \ArgumentCountError('$agentName is required'),
                processedAt: $processedAt ?? throw new \ArgumentCountError('$processedAt is required'),
                sessionThreadID: $sessionThreadID ?? throw new \ArgumentCountError('$sessionThreadID is required'),
                // @phpstan-ignore argument.type
                stopReason: $stopReason ?? throw new \ArgumentCountError('$stopReason is required'),
            ),
            Type::SESSION_THREAD_STATUS_TERMINATED, 'session.thread_status_terminated' => ManagedAgentsSessionThreadStatusTerminatedEvent::with(
                type: 'session.thread_status_terminated',
                id: $id ?? throw new \ArgumentCountError('$id is required'),
                agentName: $agentName ?? throw new \ArgumentCountError('$agentName is required'),
                processedAt: $processedAt ?? throw new \ArgumentCountError('$processedAt is required'),
                sessionThreadID: $sessionThreadID ?? throw new \ArgumentCountError('$sessionThreadID is required'),
            ),
            Type::USER_TOOL_RESULT, 'user.tool_result' => BetaManagedAgentsUserToolResultEvent::with(
                type: 'user.tool_result',
                id: $id ?? throw new \ArgumentCountError('$id is required'),
                toolUseID: $toolUseID ?? throw new \ArgumentCountError('$toolUseID is required'),
                // @phpstan-ignore argument.type
                content: $content,
                isError: $isError,
                processedAt: $processedAt,
                sessionThreadID: $sessionThreadID,
            ),
            Type::SESSION_THREAD_STATUS_RESCHEDULED, 'session.thread_status_rescheduled' => ManagedAgentsSessionThreadStatusRescheduledEvent::with(
                type: 'session.thread_status_rescheduled',
                id: $id ?? throw new \ArgumentCountError('$id is required'),
                agentName: $agentName ?? throw new \ArgumentCountError('$agentName is required'),
                processedAt: $processedAt ?? throw new \ArgumentCountError('$processedAt is required'),
                sessionThreadID: $sessionThreadID ?? throw new \ArgumentCountError('$sessionThreadID is required'),
            ),
            Type::SESSION_UPDATED, 'session.updated' => BetaManagedAgentsSessionUpdatedEvent::with(
                type: 'session.updated',
                id: $id ?? throw new \ArgumentCountError('$id is required'),
                processedAt: $processedAt ?? throw new \ArgumentCountError('$processedAt is required'),
                agent: $agent,
                budget: $budget,
                metadata: $metadata,
                title: $title,
            ),
            Type::EVENT_START, 'event_start' => BetaManagedAgentsStartEvent::with(
                type: 'event_start',
                event: $event ?? throw new \ArgumentCountError('$event is required'),
            ),
            Type::EVENT_DELTA, 'event_delta' => BetaManagedAgentsDeltaEvent::with(
                type: 'event_delta',
                delta: $delta ?? throw new \ArgumentCountError('$delta is required'),
                eventID: $eventID ?? throw new \ArgumentCountError('$eventID is required'),
            ),
            Type::SYSTEM_MESSAGE, 'system.message' => BetaManagedAgentsSystemMessageEvent::with(
                type: 'system.message',
                id: $id ?? throw new \ArgumentCountError('$id is required'),
                // @phpstan-ignore argument.type
                content: $content ?? throw new \ArgumentCountError('$content is required'),
                processedAt: $processedAt,
            ),
            Type::SESSION_USAGE, 'session.usage' => BetaManagedAgentsSessionUsageEvent::with(
                type: 'session.usage',
                id: $id ?? throw new \ArgumentCountError('$id is required'),
                processedAt: $processedAt ?? throw new \ArgumentCountError('$processedAt is required'),
                // @phpstan-ignore argument.type
                usage: $usage ?? throw new \ArgumentCountError('$usage is required'),
                budget: $budget,
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
