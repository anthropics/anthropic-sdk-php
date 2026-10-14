<?php

declare(strict_types=1);

namespace Anthropic\Lib\Tracing;

/**
 * The values of the enumerated attributes of {@see TraceAttributes}, named as the conventions' PHP constants
 * (`OpenTelemetry\SemConv\TraceAttributeValues`) name them.
 *
 * @internal
 */
final class TraceAttributeValues
{
    /** `gen_ai.operation.name` of a Messages create call. */
    public const GEN_AI_OPERATION_NAME_VALUE_CHAT = 'chat';

    /** `gen_ai.operation.name` of one run of a tool. */
    public const GEN_AI_OPERATION_NAME_VALUE_EXECUTE_TOOL = 'execute_tool';

    /** `gen_ai.operation.name` of one loop of a tool runner. */
    public const GEN_AI_OPERATION_NAME_VALUE_INVOKE_AGENT = 'invoke_agent';

    /** `gen_ai.tool.type` of a tool that runs in the application. */
    public const GEN_AI_TOOL_TYPE_VALUE_FUNCTION = 'function';

    /** `gen_ai.output.type` of a request that sets an output format. */
    public const GEN_AI_OUTPUT_TYPE_VALUE_JSON = 'json';
}
