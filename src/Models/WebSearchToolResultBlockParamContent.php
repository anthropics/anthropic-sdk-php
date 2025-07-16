<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Concerns\Union;
use Anthropic\Core\Contracts\StaticConverter;

final class WebSearchToolResultBlockParamContent implements StaticConverter
{
    use Union;
}

WebSearchToolResultBlockParamContent::__introspect();
