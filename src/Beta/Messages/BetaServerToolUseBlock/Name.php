<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaServerToolUseBlock;

use Anthropic\Core\Concerns\SdkEnum;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

final class Name implements ConverterSource
{
    use SdkEnum;

    public const WEB_SEARCH = 'web_search';

    public const CODE_EXECUTION = 'code_execution';
}
