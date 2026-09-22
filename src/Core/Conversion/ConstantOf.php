<?php

declare(strict_types=1);

namespace Anthropic\Core\Conversion;

use Anthropic\Core\Conversion;
use Anthropic\Core\Conversion\Contracts\Converter;

/**
 * @internal
 */
final class ConstantOf implements Converter
{
    public function __construct(private readonly bool|float|int|string|null $value) {}

    public function coerce(mixed $value, CoerceState $state): mixed
    {
        $this->tally($value, state: $state);

        return $value;
    }

    public function dump(mixed $value, DumpState $state): mixed
    {
        $this->tally($value, state: $state);

        return Conversion::dump_unknown($value, state: $state);
    }

    private function tally(mixed $value, CoerceState|DumpState $state): void
    {
        if ($value === $this->value) {
            ++$state->yes;
        } elseif (gettype($value) === gettype($this->value)) {
            ++$state->maybe;
        } else {
            ++$state->no;
        }
    }
}
