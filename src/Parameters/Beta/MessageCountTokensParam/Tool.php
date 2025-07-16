<?php

declare(strict_types=1);

namespace Anthropic\Parameters\Beta\MessageCountTokensParam;

use Anthropic\Core\Concerns\Union;
use Anthropic\Core\Contracts\StaticConverter;

final class Tool implements StaticConverter
{
    use Union;
}

Tool::__introspect();
