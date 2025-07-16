<?php

declare(strict_types=1);

namespace Anthropic\Core\Serde;

use Anthropic\Core\Concerns\ArrayOf;
use Anthropic\Core\Contracts\Converter;

final class ListOf implements Converter
{
    use ArrayOf;

    // @phpstan-ignore-next-line
    private function empty(): array|object
    {
        return [];
    }
}
