<?php

declare(strict_types=1);

namespace Anthropic\Models\MessageParam;

use Anthropic\Core\Concerns\Enum;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-type role_alias = Role::*
 */
final class Role implements ConverterSource
{
    use Enum;

    public const USER = 'user';

    public const ASSISTANT = 'assistant';
}
