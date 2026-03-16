<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaWebFetchTool20260309;

/**
 * Specifies who can invoke a tool.
 *
 * Values:
 *     direct: The model can call this tool directly.
 *     code_execution_20250825: The tool can be called from the code execution environment (v1).
 *     code_execution_20260120: The tool can be called from the code execution environment (v2 with persistence).
 */
enum AllowedCaller: string
{
    case DIRECT = 'direct';

    case CODE_EXECUTION_20250825 = 'code_execution_20250825';

    case CODE_EXECUTION_20260120 = 'code_execution_20260120';
}
