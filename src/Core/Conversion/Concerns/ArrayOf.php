<?php

declare(strict_types=1);

namespace Anthropic\Core\Conversion\Concerns;

use Anthropic\Core\Conversion;
use Anthropic\Core\Conversion\CoerceState;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Core\Conversion\DumpState;

/**
 * @internal
 */
trait ArrayOf
{
    private readonly Converter|ConverterSource|string|null $type;

    public function __construct(
        Converter|ConverterSource|string|null $type = null,
        Converter|ConverterSource|string|null $enum = null,
        Converter|ConverterSource|string|null $union = null,
        private readonly bool $nullable = false,
    ) {
        $this->type = $type ?? $enum ?? $union;
        assert(!is_null($this->type));
    }

    public function coerce(mixed $value, CoerceState $state): mixed
    {
        if (!is_array($value)) {
            return $value;
        }
        ++$state->yes;

        $acc = [];
        foreach ($value as $k => $v) {
            if ($this->nullable && is_null($v)) {
                ++$state->yes;
                $acc[$k] = null;
            } else {
                $acc[$k] = Conversion::coerce($this->type, value: $v, state: $state);
            }
        }

        return $acc;
    }

    public function dump(mixed $value, DumpState $state): mixed
    {
        if (!is_array($value)) {
            return Conversion::dump_unknown($value, state: $state);
        }
        ++$state->yes;

        if (empty($value)) {
            return $this->empty();
        }

        $acc = [];
        foreach ($value as $k => $v) {
            if ($this->nullable && is_null($v)) {
                ++$state->yes;
                $acc[$k] = null;
            } else {
                $acc[$k] = Conversion::dump($this->type, value: $v, state: $state);
            }
        }

        return $acc;
    }

    // @phpstan-ignore-next-line missingType.iterableValue
    private function empty(): array|object
    {
        return (object) [];
    }
}
