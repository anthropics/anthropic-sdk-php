<?php

declare(strict_types=1);

namespace Anthropic\Core\Conversion;

use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

final class UnionOf implements Converter
{
    /**
     * @param array<string, Converter|ConverterSource|string>|list<Converter|ConverterSource|string> $variants
     */
    public function __construct(
        private readonly array $variants,
        private readonly ?string $discriminator = null,
    ) {}

    public function coerce(mixed $value, CoerceState $state): mixed
    {
        if (!is_null($target = $this->resolveVariant(value: $value))) {
            return Conversion::coerce($target, value: $value, state: $state);
        }

        $alternatives = [];
        foreach ($this->variants as $_ => $variant) {
            ++$state->branched;
            $newState = new CoerceState;

            $coerced = Conversion::coerce($variant, value: $value, state: $newState);
            if (($newState->no + $newState->maybe) === 0) {
                $state->yes += $newState->yes;

                return $coerced;
            }
            if ($newState->maybe > 0) {
                $alternatives[] = [[-$newState->yes, -$newState->maybe, $newState->no], $newState, $coerced];
            }
        }

        usort(
            $alternatives,
            static fn (array $a, array $b): int => $a[0][0] <=> $b[0][0] ?: $a[0][1] <=> $b[0][1] ?: $a[0][2] <=> $b[0][2]
        );

        if (empty($alternatives)) {
            ++$state->no;

            return $value;
        }

        [[,$newState, $best]] = $alternatives;
        $state->yes += $newState->yes;
        $state->maybe += $newState->maybe;
        $state->no += $newState->no;

        return $best;
    }

    public function dump(mixed $value, DumpState $state): mixed
    {
        if (!is_null($target = $this->resolveVariant(value: $value))) {
            return Conversion::dump($target, value: $value, state: $state);
        }

        foreach ($this->variants as $variant) {
            if ($value instanceof $variant) {
                return Conversion::dump($variant, value: $value, state: $state);
            }
        }

        return Conversion::dump_unknown($value, state: $state);
    }

    private function resolveVariant(
        mixed $value,
    ): Converter|ConverterSource|string|null {
        if ($value instanceof BaseModel) {
            return $value::class;
        }

        if (!is_null($this->discriminator) && is_array($value) && array_key_exists($this->discriminator, array: $value)) {
            $discriminator = $value[$this->discriminator];

            return $this->variants[$discriminator] ?? null;
        }

        return null;
    }
}
