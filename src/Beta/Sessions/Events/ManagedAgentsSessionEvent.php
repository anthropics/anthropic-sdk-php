<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Union type for all event types in a session.
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
 * @phpstan-import-type ManagedAgentsAgentThreadContextCompactedEventShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsAgentThreadContextCompactedEvent
 * @phpstan-import-type ManagedAgentsSessionErrorEventShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsSessionErrorEvent
 * @phpstan-import-type ManagedAgentsSessionStatusRescheduledEventShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsSessionStatusRescheduledEvent
 * @phpstan-import-type ManagedAgentsSessionStatusRunningEventShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsSessionStatusRunningEvent
 * @phpstan-import-type ManagedAgentsSessionStatusIdleEventShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsSessionStatusIdleEvent
 * @phpstan-import-type ManagedAgentsSessionStatusTerminatedEventShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsSessionStatusTerminatedEvent
 * @phpstan-import-type ManagedAgentsSpanModelRequestStartEventShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsSpanModelRequestStartEvent
 * @phpstan-import-type ManagedAgentsSpanModelRequestEndEventShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsSpanModelRequestEndEvent
 * @phpstan-import-type ManagedAgentsSessionDeletedEventShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsSessionDeletedEvent
 *
 * @phpstan-type ManagedAgentsSessionEventVariants = ManagedAgentsUserMessageEvent|ManagedAgentsUserInterruptEvent|ManagedAgentsUserToolConfirmationEvent|ManagedAgentsUserCustomToolResultEvent|ManagedAgentsAgentCustomToolUseEvent|ManagedAgentsAgentMessageEvent|ManagedAgentsAgentThinkingEvent|ManagedAgentsAgentMCPToolUseEvent|ManagedAgentsAgentMCPToolResultEvent|ManagedAgentsAgentToolUseEvent|ManagedAgentsAgentToolResultEvent|ManagedAgentsAgentThreadContextCompactedEvent|ManagedAgentsSessionErrorEvent|ManagedAgentsSessionStatusRescheduledEvent|ManagedAgentsSessionStatusRunningEvent|ManagedAgentsSessionStatusIdleEvent|ManagedAgentsSessionStatusTerminatedEvent|ManagedAgentsSpanModelRequestStartEvent|ManagedAgentsSpanModelRequestEndEvent|ManagedAgentsSessionDeletedEvent
 * @phpstan-type ManagedAgentsSessionEventShape = ManagedAgentsSessionEventVariants|ManagedAgentsUserMessageEventShape|ManagedAgentsUserInterruptEventShape|ManagedAgentsUserToolConfirmationEventShape|ManagedAgentsUserCustomToolResultEventShape|ManagedAgentsAgentCustomToolUseEventShape|ManagedAgentsAgentMessageEventShape|ManagedAgentsAgentThinkingEventShape|ManagedAgentsAgentMCPToolUseEventShape|ManagedAgentsAgentMCPToolResultEventShape|ManagedAgentsAgentToolUseEventShape|ManagedAgentsAgentToolResultEventShape|ManagedAgentsAgentThreadContextCompactedEventShape|ManagedAgentsSessionErrorEventShape|ManagedAgentsSessionStatusRescheduledEventShape|ManagedAgentsSessionStatusRunningEventShape|ManagedAgentsSessionStatusIdleEventShape|ManagedAgentsSessionStatusTerminatedEventShape|ManagedAgentsSpanModelRequestStartEventShape|ManagedAgentsSpanModelRequestEndEventShape|ManagedAgentsSessionDeletedEventShape
 */
final class ManagedAgentsSessionEvent implements ConverterSource
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
            'agent.thread_context_compacted' => ManagedAgentsAgentThreadContextCompactedEvent::class,
            'session.error' => ManagedAgentsSessionErrorEvent::class,
            'session.status_rescheduled' => ManagedAgentsSessionStatusRescheduledEvent::class,
            'session.status_running' => ManagedAgentsSessionStatusRunningEvent::class,
            'session.status_idle' => ManagedAgentsSessionStatusIdleEvent::class,
            'session.status_terminated' => ManagedAgentsSessionStatusTerminatedEvent::class,
            'span.model_request_start' => ManagedAgentsSpanModelRequestStartEvent::class,
            'span.model_request_end' => ManagedAgentsSpanModelRequestEndEvent::class,
            'session.deleted' => ManagedAgentsSessionDeletedEvent::class,
        ];
    }
}
