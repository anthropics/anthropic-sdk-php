<?php

declare(strict_types=1);

namespace Anthropic\Messages\WebSearchTool20260318;

/**
 * How this tool's result blocks appear in the API response when the result was consumed by a completed code_execution call in the same turn. 'full' returns the complete content (default). 'excluded' drops the nested server_tool_use and result block pair entirely. Results from direct calls, or from code_execution calls that paused before completing, are always returned in full so they can be sent back on the next turn.
 */
enum ResponseInclusion: string
{
    case FULL = 'full';

    case EXCLUDED = 'excluded';
}
