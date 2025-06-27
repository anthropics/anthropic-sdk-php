<?php

declare(strict_types=1);

namespace Anthropic\Core\Serde;

use Anthropic\Core\Concerns\ArrayOf;
use Anthropic\Core\Contracts\Converter;

final class MapOf implements Converter
{
    use ArrayOf;
}
