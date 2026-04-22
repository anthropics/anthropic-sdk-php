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

    /**
     * Raw enum values for JSON schema generation.
     *
     * Populated when enum is a literal array, or extracted from a backed enum class.
     *
     * @var list<bool|float|int|string|null>|null
     */
    public readonly ?array $enumValues;

    /**
     * @param class-string<ConverterSource>|Converter|string|null                       $type
     * @param class-string<\BackedEnum>|Converter|list<bool|float|int|string|null>|null $enum
     * @param class-string<ConverterSource>|Converter|null                              $union
     * @param class-string<ConverterSource>|Converter|string|null                       $list
     * @param class-string<ConverterSource>|Converter|string|null                       $map
     */
    public function __construct(
        ?string $apiName = null,
        Converter|string|null $type = null,
        Converter|string|array|null $enum = null,
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
            if (is_array($enum)) {
                // Literal values array — used directly for schema enum constraint
                $this->enumValues = $enum;
                $type ??= new EnumOf($enum);
            } elseif ($enum instanceof Converter) {
                $type ??= $enum;
                $this->enumValues = null;
            } else {
                $type ??= EnumOf::fromBackedEnum($enum);
                // @phpstan-ignore-next-line argument.type
                $this->enumValues = array_column($enum::cases(), 'value');
            }
        } else {
            $this->enumValues = null;
        }

        $this->apiName = $apiName;
        $this->type = $type;
        $this->optional = false;
        $this->nullable = $nullable;
    }
}
