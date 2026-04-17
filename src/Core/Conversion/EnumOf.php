<?php

declare(strict_types=1);

namespace Anthropic\Core\Conversion;

use Anthropic\Core\Conversion;
use Anthropic\Core\Conversion\Contracts\Converter;

/**
 * @internal
 */
final class EnumOf implements Converter
{
    private readonly string $type;

    /** @var array<class-string<\BackedEnum>, self> */
    private static array $cache = [];

    /**
     * @param list<bool|float|int|string|null> $members
     * @param class-string<\BackedEnum>|null   $class
     */
    public function __construct(
        private readonly array $members,
        private readonly ?string $class = null,
    ) {
        $type = 'NULL';
        foreach ($this->members as $member) {
            $type = gettype($member);
        }
        $this->type = $type;
    }

    /** @param class-string<\BackedEnum> $enum */
    public static function fromBackedEnum(string $enum): self
    {
        // @phpstan-ignore-next-line argument.type
        return self::$cache[$enum] ??= new self(
            array_column($enum::cases(), column_key: 'value'),
            class: $enum,
        );
    }

    public function coerce(mixed $value, CoerceState $state): mixed
    {
        $this->tally($value, state: $state);

        if ($value instanceof \BackedEnum) {
            return $value;
        }

        if (null !== $this->class && (is_int($value) || is_string($value))) {
            return ($this->class)::tryFrom($value) ?? $value;
        }

        return $value;
    }

    public function dump(mixed $value, DumpState $state): mixed
    {
        $this->tally($value, state: $state);

        return Conversion::dump_unknown($value, state: $state);
    }

    private function tally(mixed $value, CoerceState|DumpState $state): void
    {
        $needle = $value instanceof \BackedEnum ? $value->value : $value;
        if (in_array($needle, haystack: $this->members, strict: true)) {
            ++$state->yes;
        } elseif ($this->type === gettype($needle)) {
            ++$state->maybe;
        } else {
            ++$state->no;
        }
    }
}
