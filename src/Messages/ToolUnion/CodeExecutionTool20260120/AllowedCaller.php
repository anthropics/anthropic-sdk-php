<?php

declare(strict_types=1);

namespace Anthropic\Messages\ToolUnion\CodeExecutionTool20260120;

enum AllowedCaller: string
{
    case DIRECT = 'direct';

    case CODE_EXECUTION_20250825 = 'code_execution_20250825';
}
