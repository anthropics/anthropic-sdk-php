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
class Required
{
    /** @var class-string<ConverterSource>|Converter|string|null */
    public readonly Converter|string|null $type;

    public readonly ?string $apiName;

    public bool $optional;

    public readonly bool $nullable;

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
        ?string $apiName = null,
        Converter|string|null $type = null,
        Converter|string|null $enum = null,
        Converter|string|null $union = null,
        Converter|string|null $list = null,
        Converter|string|null $map = null,
        bool $nullable = false,
    ) {
        $type ??= $union;
        if (null !== $list) {
            $type ??= new ListOf($list);
        }
        if (null !== $map) {
            $type ??= new MapOf($map);
        }
        if (null !== $enum) {
            $type ??= $enum instanceof Converter ? $enum : self::enumConverter($enum);
        }

        $this->apiName = $apiName;
        $this->type = $type;
        $this->optional = false;
        $this->nullable = $nullable;
    }

    /** @property class-string<\BackedEnum> $enum */
    private static function enumConverter(string $enum): Converter
    {
        if (!isset(self::$enumConverters[$enum])) {
            // @phpstan-ignore-next-line argument.type
            $converter = new EnumOf(array_column($enum::cases(), column_key: 'value'));
            self::$enumConverters[$enum] = $converter;
        }

        return self::$enumConverters[$enum];
    }
}
