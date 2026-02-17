<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaWebFetchTool20260209;

enum AllowedCaller: string
{
    case DIRECT = 'direct';

    case CODE_EXECUTION_20250825 = 'code_execution_20250825';
}
