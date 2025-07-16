<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta\BetaServerToolUseBlockParam;

use Anthropic\Core\Concerns\Enum;
use Anthropic\Core\Contracts\StaticConverter;

final class Name implements StaticConverter
{
    use Enum;

    final public const WEB_SEARCH = 'web_search';

    final public const CODE_EXECUTION = 'code_execution';
}

Name::__introspect();
