<?php

declare(strict_types=1);

namespace Anthropic\Core\Conversion;

use Anthropic\Core\Concerns\ArrayOf;
use Anthropic\Core\Contracts\Converter;

/**
 * @internal
 */
final class ListOf implements Converter
{
    use ArrayOf;

    private function empty(): array|object // @phpstan-ignore-line
    {
        return [];
    }
}
