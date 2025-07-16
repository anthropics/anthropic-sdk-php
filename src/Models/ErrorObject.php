<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Concerns\Union;
use Anthropic\Core\Contracts\StaticConverter;

final class ErrorObject implements StaticConverter
{
    use Union;
}

ErrorObject::__introspect();
