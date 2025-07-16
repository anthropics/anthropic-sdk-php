<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta\BetaMessageParam;

use Anthropic\Core\Concerns\Enum;
use Anthropic\Core\Contracts\StaticConverter;

final class Role implements StaticConverter
{
    use Enum;

    final public const USER = 'user';

    final public const ASSISTANT = 'assistant';
}

Role::__introspect();
