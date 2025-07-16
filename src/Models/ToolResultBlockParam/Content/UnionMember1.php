<?php

declare(strict_types=1);

namespace Anthropic\Models\ToolResultBlockParam\Content;

use Anthropic\Core\Concerns\Union;
use Anthropic\Core\Contracts\StaticConverter;

final class UnionMember1 implements StaticConverter
{
    use Union;
}

UnionMember1::__introspect();
