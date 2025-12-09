<?php

declare(strict_types=1);

namespace Anthropic\Core;

use Anthropic\Core\Conversion\CoerceState;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Core\Conversion\DumpState;

/**
 * @internal
 */
final class Conversion
{
    public static function dump_unknown(mixed $value, DumpState $state): mixed
    {
        if (is_array($value)) {
            return array_map(static fn ($v) => self::dump_unknown($v, state: $state), array: $value);
        }

        if (is_object($value)) {
            if (is_a($value, class: ConverterSource::class)) {
                return $value::converter()->dump($value, state: $state);
            }

            if (is_a($value, class: \BackedEnum::class)) {
                return $value->value;
            }

            if (is_a($value, class: \DateTimeInterface::class)) {
                return $value->format(format: \DateTimeInterface::RFC3339);
            }

            if (is_a($value, class: \JsonSerializable::class)) {
                return $value->jsonSerialize();
            }

            $acc = get_object_vars($value);

            return empty($acc) ? (object) $acc : self::dump_unknown($acc, state: $state);
        }

        return $value;
    }

    public static function coerce(Converter|ConverterSource|string $target, mixed $value, CoerceState $state = new CoerceState): mixed
    {
        if ($value instanceof $target) {
            ++$state->yes;

            return $value;
        }

        if (is_a($target, class: ConverterSource::class, allow_string: true)) {
            $target = $target::converter();
        }

        if ($target instanceof Converter) {
            return $target->coerce($value, state: $state);
        }

        return self::tryConvert($target, value: $value, state: $state);
    }

    public static function dump(Converter|ConverterSource|string $target, mixed $value, DumpState $state = new DumpState): mixed
    {
        if ($target instanceof Converter) {
            return $target->dump($value, state: $state);
        }

        if (is_a($target, class: ConverterSource::class, allow_string: true)) {
            return $target::converter()->dump($value, state: $state);
        }

        self::tryConvert($target, value: $value, state: $state);

        return self::dump_unknown($value, state: $state);
    }

    private static function tryConvert(Converter|ConverterSource|string $target, mixed $value, CoerceState|DumpState $state): mixed
    {
        switch ($target) {
            case 'mixed':
                ++$state->yes;

                return $value;

            case 'null':
                if (is_null($value)) {
                    ++$state->yes;

                    return null;
                }

                ++$state->maybe;

                return null;

            case 'bool':
                if (is_bool($value)) {
                    ++$state->yes;

                    return $value;
                }

                ++$state->no;

                return $value;

            case 'int':
                if (is_int($value)) {
                    ++$state->yes;

                    return $value;
                }

                if (is_float($value)) {
                    ++$state->maybe;

                    return (int) $value;
                }

                if (is_string($value) && ctype_digit($value)) {
                    ++$state->maybe;

                    return (int) $value;
                }

                ++$state->no;

                return $value;

            case 'float':
                if (is_numeric($value)) {
                    ++$state->yes;

                    return (float) $value;
                }

                if (is_string($value) && is_numeric($value)) {
                    ++$state->maybe;

                    return (float) $value;
                }

                ++$state->no;

                return $value;

            case 'string':
                if (is_string($value)) {
                    ++$state->yes;

                    return $value;
                }

                if (is_numeric($value)) {
                    ++$state->maybe;

                    return (string) $value;
                }

                if ($value instanceof \Generator) {
                    return implode('', iterator_to_array($value));
                }

                ++$state->no;

                return $value;

            default:
                ++$state->no;

                return $value;
        }
    }
}
