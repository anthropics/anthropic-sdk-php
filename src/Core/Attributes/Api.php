<?php

declare(strict_types=1);

namespace Anthropic\Core\Attributes;

use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Core\Conversion\EnumOf;
use Anthropic\Core\Conversion\ListOf;
use Anthropic\Core\Conversion\MapOf;

/**
 * @internal
 */
#[\Attribute(\Attribute::TARGET_PROPERTY)]
final class Api
{
    /** @var class-string<ConverterSource>|Converter|string|null */
    public readonly Converter|string|null $type;

    /** @var array<string,Converter> */
    private static array $enumConverters = [];

    /**
     * @param class-string<ConverterSource>|Converter|string|null $type
     * @param class-string<\BackedEnum>|Converter|null            $enum
     * @param class-string<ConverterSource>|Converter|null        $union
     * @param class-string<ConverterSource>|Converter|string|null $list
     * @param class-string<ConverterSource>|Converter|string|null $map
     */
    public function __construct(
        public readonly ?string $apiName = null,
        Converter|string|null $type = null,
        Converter|string|null $enum = null,
        Converter|string|null $union = null,
        Converter|string|null $list = null,
        Converter|string|null $map = null,
        public readonly bool $nullable = false,
        public readonly bool $optional = false,
    ) {
        $type ??= $union;
        if (null !== $list) {
            $type ??= new ListOf($list);
        }
        if (null !== $map) {
            $type ??= new MapOf($map);
        }
        if (null !== $enum) {
            $type ??= $enum instanceof Converter ? $enum : $this->getEnumConverter($enum);
        }

        $this->type = $type;
    }

    /** @property class-string<\BackedEnum> $enum */
    private function getEnumConverter(string $enum): Converter
    {
        if (!isset(self::$enumConverters[$enum])) {
            $converter = new EnumOf(array_column($enum::cases(), 'value')); // @phpstan-ignore-line
            self::$enumConverters[$enum] = $converter;
        }

        return self::$enumConverters[$enum];
    }
}
