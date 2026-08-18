<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events\ManagedAgentsStreamSessionEvents;

enum Type: string
{
    case USER_MESSAGE = 'user.message';

    case USER_INTERRUPT = 'user.interrupt';

    case USER_TOOL_CONFIRMATION = 'user.tool_confirmation';

    case USER_CUSTOM_TOOL_RESULT = 'user.custom_tool_result';

    case AGENT_CUSTOM_TOOL_USE = 'agent.custom_tool_use';

    case AGENT_MESSAGE = 'agent.message';

    case AGENT_THINKING = 'agent.thinking';

    case AGENT_MCP_TOOL_USE = 'agent.mcp_tool_use';

    case AGENT_MCP_TOOL_RESULT = 'agent.mcp_tool_result';

    case AGENT_TOOL_USE = 'agent.tool_use';

    case AGENT_TOOL_RESULT = 'agent.tool_result';

    case AGENT_THREAD_MESSAGE_RECEIVED = 'agent.thread_message_received';

    case AGENT_THREAD_MESSAGE_SENT = 'agent.thread_message_sent';

    case AGENT_THREAD_CONTEXT_COMPACTED = 'agent.thread_context_compacted';

    case SESSION_ERROR = 'session.error';

    case SESSION_STATUS_RESCHEDULED = 'session.status_rescheduled';

    case SESSION_STATUS_RUNNING = 'session.status_running';

    case SESSION_STATUS_IDLE = 'session.status_idle';

    case SESSION_STATUS_TERMINATED = 'session.status_terminated';

    case SESSION_THREAD_CREATED = 'session.thread_created';

    case SPAN_OUTCOME_EVALUATION_START = 'span.outcome_evaluation_start';

    case SPAN_OUTCOME_EVALUATION_END = 'span.outcome_evaluation_end';

    case SPAN_MODEL_REQUEST_START = 'span.model_request_start';

    case SPAN_MODEL_REQUEST_END = 'span.model_request_end';

    case SPAN_OUTCOME_EVALUATION_ONGOING = 'span.outcome_evaluation_ongoing';

    case USER_DEFINE_OUTCOME = 'user.define_outcome';

    case SESSION_DELETED = 'session.deleted';

    case SESSION_THREAD_STATUS_RUNNING = 'session.thread_status_running';

    case SESSION_THREAD_STATUS_IDLE = 'session.thread_status_idle';

    case SESSION_THREAD_STATUS_TERMINATED = 'session.thread_status_terminated';

    case USER_TOOL_RESULT = 'user.tool_result';

    case SESSION_THREAD_STATUS_RESCHEDULED = 'session.thread_status_rescheduled';

    case SESSION_UPDATED = 'session.updated';

    case EVENT_START = 'event_start';

    case EVENT_DELTA = 'event_delta';

    case SYSTEM_MESSAGE = 'system.message';

    case SESSION_USAGE = 'session.usage';
}
