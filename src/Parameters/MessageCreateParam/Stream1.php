<?php

declare(strict_types=1);

namespace Anthropic\Parameters\MessageCreateParam;

use Anthropic\Core\Concerns\Enum;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

final class Stream implements ConverterSource
{
    use Enum;

    final public const TRUE = true;
}
