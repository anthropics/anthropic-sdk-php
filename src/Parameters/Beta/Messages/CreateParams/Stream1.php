<?php

declare(strict_types=1);

namespace Anthropic\Parameters\Beta\Messages\CreateParams;

use Anthropic\Core\Concerns\Enum;
use Anthropic\Core\Contracts\StaticConverter;

final class Stream implements StaticConverter
{
    use Enum;

    final public const TRUE = true;
}

Stream::__introspect();
