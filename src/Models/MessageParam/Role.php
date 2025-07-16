<?php

declare(strict_types=1);

namespace Anthropic\Models\MessageParam;

use Anthropic\Core\Concerns\Enum;
use Anthropic\Core\Contracts\StaticConverter;

final class Role implements StaticConverter
{
    use Enum;

    final public const USER = 'user';

    final public const ASSISTANT = 'assistant';
}
