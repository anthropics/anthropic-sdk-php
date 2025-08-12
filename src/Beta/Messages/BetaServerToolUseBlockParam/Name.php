<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaServerToolUseBlockParam;

use Anthropic\Core\Concerns\Enum;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-type name_alias = Name::*
 */
final class Name implements ConverterSource
{
    use Enum;

    public const WEB_SEARCH = 'web_search';

    public const CODE_EXECUTION = 'code_execution';
}
