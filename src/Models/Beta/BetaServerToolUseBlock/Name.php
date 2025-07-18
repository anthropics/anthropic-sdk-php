<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta\BetaServerToolUseBlock;

use Anthropic\Core\Concerns\Enum;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

final class Name implements ConverterSource
{
    use Enum;

    final public const WEB_SEARCH = 'web_search';

    final public const CODE_EXECUTION = 'code_execution';
}
