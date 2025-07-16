<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Concerns\Union;
use Anthropic\Core\Contracts\StaticConverter;

final class BetaCodeExecutionToolResultBlockContent implements StaticConverter
{
    use Union;
}

BetaCodeExecutionToolResultBlockContent::__introspect();
