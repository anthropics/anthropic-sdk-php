<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaToolSearchToolRegex20251119;

enum AllowedCaller: string
{
    case DIRECT = 'direct';

    case CODE_EXECUTION_20250825 = 'code_execution_20250825';

    case CODE_EXECUTION_20260120 = 'code_execution_20260120';
}
