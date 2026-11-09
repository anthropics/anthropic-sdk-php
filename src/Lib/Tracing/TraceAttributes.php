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

    /** The model the request names, or the model of the agent that a created Session runs. */
    public const GEN_AI_REQUEST_MODEL = 'gen_ai.request.model';

    /** The request's `stop_sequences`, in content mode. */
    public const GEN_AI_REQUEST_STOP_SEQUENCES = 'gen_ai.request.stop_sequences';

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

    /** All the input tokens, the cached and cache-writing ones included. */
    public const GEN_AI_USAGE_INPUT_TOKENS = 'gen_ai.usage.input_tokens';

    /** Set, to true, when the size limit removed some of the span's content. */
    public const ANTHROPIC_CONTENT_TRUNCATED = 'anthropic.content.truncated';

    /** The Session thread whose ID a request has in its path. */
    public const ANTHROPIC_SESSION_THREAD_ID = 'anthropic.session.thread.id';

    /** The content blocks that a tool run sends back, in content mode. */
    public const ANTHROPIC_TOOL_RESULT_CONTENT = 'anthropic.tool_result.content';

    /** The `toolset_name` of the `tool_use` block that a tool span's run executes, when the block has one. */
    public const ANTHROPIC_TOOLSET_NAME = 'anthropic.toolset.name';

    /** The input tokens of the response's compactions, counted as `gen_ai.usage.input_tokens` counts them. They are not part of that attribute. */
    public const ANTHROPIC_USAGE_COMPACTION_INPUT_TOKENS = 'anthropic.usage.compaction.input_tokens';

    /** The output tokens of the response's compactions. They are not part of `gen_ai.usage.output_tokens`. */
    public const ANTHROPIC_USAGE_COMPACTION_OUTPUT_TOKENS = 'anthropic.usage.compaction.output_tokens';
}
