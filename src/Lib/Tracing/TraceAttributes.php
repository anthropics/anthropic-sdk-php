<?php

declare(strict_types=1);

namespace Anthropic\Lib\Tracing;

use Anthropic\Core\Tracing;

/**
 * The attributes that the SDK's spans set beyond the generated ones of {@see Tracing}: the
 * `gen_ai.*` attributes of the OpenTelemetry semantic conventions for generative AI, named as the conventions' PHP
 * constants (`OpenTelemetry\SemConv\TraceAttributes`) name them, and the SDK's own `anthropic.*` attributes after
 * the same pattern.
 *
 * @internal
 */
final class TraceAttributes
{
    /** The name of the agent that a created Session runs. */
    public const GEN_AI_AGENT_NAME = 'gen_ai.agent.name';

    /** The conversation that the application says a call is in, or else the Session thread whose ID the request has in its path. */
    public const GEN_AI_CONVERSATION_ID = 'gen_ai.conversation.id';

    /** The request's messages, in content mode. */
    public const GEN_AI_INPUT_MESSAGES = 'gen_ai.input.messages';

    /** One of the `GEN_AI_OPERATION_NAME_VALUE_*` of {@see TraceAttributeValues}. */
    public const GEN_AI_OPERATION_NAME = 'gen_ai.operation.name';

    /** The response's content, in content mode. */
    public const GEN_AI_OUTPUT_MESSAGES = 'gen_ai.output.messages';

    /** Set, to `json`, when the request sets an output format. */
    public const GEN_AI_OUTPUT_TYPE = 'gen_ai.output.type';

    /** `anthropic`, or the platform the client goes through. */
    public const GEN_AI_PROVIDER_NAME = 'gen_ai.provider.name';

    /** The request's `max_tokens`. */
    public const GEN_AI_REQUEST_MAX_TOKENS = 'gen_ai.request.max_tokens';

    /** The model the request names, or the model of the agent that a created Session runs. */
    public const GEN_AI_REQUEST_MODEL = 'gen_ai.request.model';

    /** The request's `output_config.effort`. */
    public const GEN_AI_REQUEST_REASONING_LEVEL = 'gen_ai.request.reasoning.level';

    /** The request's `stop_sequences`, in content mode. */
    public const GEN_AI_REQUEST_STOP_SEQUENCES = 'gen_ai.request.stop_sequences';

    /** Set, to true, when the response is streamed. */
    public const GEN_AI_REQUEST_STREAM = 'gen_ai.request.stream';

    /** The request's `temperature`. */
    public const GEN_AI_REQUEST_TEMPERATURE = 'gen_ai.request.temperature';

    /** The request's `top_k`. */
    public const GEN_AI_REQUEST_TOP_K = 'gen_ai.request.top_k';

    /** The request's `top_p`. */
    public const GEN_AI_REQUEST_TOP_P = 'gen_ai.request.top_p';

    /** The Message's `id`. */
    public const GEN_AI_RESPONSE_ID = 'gen_ai.response.id';

    /** The model that the response names. */
    public const GEN_AI_RESPONSE_MODEL = 'gen_ai.response.model';

    /** The seconds from the start of the API call to the first event of its stream. */
    public const GEN_AI_RESPONSE_TIME_TO_FIRST_CHUNK = 'gen_ai.response.time_to_first_chunk';

    /** The request's system prompt, in content mode. */
    public const GEN_AI_SYSTEM_INSTRUCTIONS = 'gen_ai.system_instructions';

    /** The input of a tool call, in content mode. */
    public const GEN_AI_TOOL_CALL_ARGUMENTS = 'gen_ai.tool.call.arguments';

    /** The `id` of the `tool_use` block. */
    public const GEN_AI_TOOL_CALL_ID = 'gen_ai.tool.call.id';

    /** The description in the tool's definition. */
    public const GEN_AI_TOOL_DESCRIPTION = 'gen_ai.tool.description';

    /** The tool's name. */
    public const GEN_AI_TOOL_NAME = 'gen_ai.tool.name';

    /** One of the `GEN_AI_TOOL_TYPE_VALUE_*` of {@see TraceAttributeValues}. */
    public const GEN_AI_TOOL_TYPE = 'gen_ai.tool.type';

    /** The input tokens read from the cache. */
    public const GEN_AI_USAGE_CACHE_READ_INPUT_TOKENS = 'gen_ai.usage.cache_read.input_tokens';

    /** The input tokens written to the cache. */
    public const GEN_AI_USAGE_CACHE_WRITE_INPUT_TOKENS = 'gen_ai.usage.cache_write.input_tokens';

    /** All the input tokens, the cached and cache-writing ones included. */
    public const GEN_AI_USAGE_INPUT_TOKENS = 'gen_ai.usage.input_tokens';

    /** The output tokens. */
    public const GEN_AI_USAGE_OUTPUT_TOKENS = 'gen_ai.usage.output_tokens';

    /** The output tokens spent on thinking. */
    public const GEN_AI_USAGE_REASONING_OUTPUT_TOKENS = 'gen_ai.usage.reasoning.output_tokens';

    /** The beta versions that the request asks for. */
    public const ANTHROPIC_BETA = 'anthropic.beta';

    /** Set, to true, when the size limit removed some of the span's content. */
    public const ANTHROPIC_CONTENT_TRUNCATED = 'anthropic.content.truncated';

    /** The count that a `count_tokens` call returned. */
    public const ANTHROPIC_MESSAGE_COUNT_TOKENS_INPUT_TOKENS = 'anthropic.message.count_tokens.input_tokens';

    /** The Message's `stop_reason`, as the API gives it. */
    public const ANTHROPIC_MESSAGE_STOP_REASON = 'anthropic.message.stop_reason';

    /** From the `anthropic-organization-id` response header. */
    public const ANTHROPIC_ORGANIZATION_ID = 'anthropic.organization.id';

    /** From the `request-id` response header. */
    public const ANTHROPIC_REQUEST_ID = 'anthropic.request.id';

    /** The `service_tier` the request asks for. */
    public const ANTHROPIC_REQUEST_SERVICE_TIER = 'anthropic.request.service_tier';

    /** The `service_tier` of the response's usage. */
    public const ANTHROPIC_RESPONSE_SERVICE_TIER = 'anthropic.response.service_tier';

    /** The Session thread whose ID a request has in its path. */
    public const ANTHROPIC_SESSION_THREAD_ID = 'anthropic.session.thread.id';

    /** The request's `thinking.budget_tokens`. */
    public const ANTHROPIC_THINKING_BUDGET_TOKENS = 'anthropic.thinking.budget_tokens';

    /** The request's `thinking.type`. */
    public const ANTHROPIC_THINKING_TYPE = 'anthropic.thinking.type';

    /** The content blocks that a tool run sends back, in content mode. */
    public const ANTHROPIC_TOOL_RESULT_CONTENT = 'anthropic.tool_result.content';

    /** The `toolset_name` of the `tool_use` block that a tool span's run executes, when the block has one. */
    public const ANTHROPIC_TOOLSET_NAME = 'anthropic.toolset.name';

    /** The input tokens written to the cache with a one-hour lifetime. */
    public const ANTHROPIC_USAGE_CACHE_CREATION_EPHEMERAL_1H_INPUT_TOKENS = 'anthropic.usage.cache_creation.ephemeral_1h_input_tokens';

    /** The input tokens written to the cache with a five-minute lifetime. */
    public const ANTHROPIC_USAGE_CACHE_CREATION_EPHEMERAL_5M_INPUT_TOKENS = 'anthropic.usage.cache_creation.ephemeral_5m_input_tokens';

    /** The input tokens of the response's compactions, counted as `gen_ai.usage.input_tokens` counts them. They are not part of that attribute. */
    public const ANTHROPIC_USAGE_COMPACTION_INPUT_TOKENS = 'anthropic.usage.compaction.input_tokens';

    /** The output tokens of the response's compactions. They are not part of `gen_ai.usage.output_tokens`. */
    public const ANTHROPIC_USAGE_COMPACTION_OUTPUT_TOKENS = 'anthropic.usage.compaction.output_tokens';

    /** From the `anthropic-workspace-id` response header. */
    public const ANTHROPIC_WORKSPACE_ID = 'anthropic.workspace.id';
}
