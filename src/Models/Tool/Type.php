<?php

declare(strict_types=1);

namespace Anthropic\Models\Tool;

use Anthropic\Core\Concerns\Enum;
use Anthropic\Core\Contracts\StaticConverter;

final class Type implements StaticConverter
{
    use Enum;

    final public const CUSTOM = 'custom';
}
