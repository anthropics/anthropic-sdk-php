<?php

declare(strict_types=1);

namespace Anthropic\Core\Conversion;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @internal
 */
final class PropertyInfo
{
    public readonly string $apiName;

    public readonly Converter|ConverterSource|string $type;

    public readonly bool $nullable;

    public readonly bool $optional;

    public function __construct(public readonly \ReflectionProperty $property)
    {
        $nullable = $property->getType()?->allowsNull() ?? false;

        $apiName = $property->getName();
        $type = $property->getType();
        $optional = false;
        $attributes = [...$property->getAttributes(Required::class), ...$property->getAttributes(Optional::class)];

        foreach ($attributes as $attr) {
            /** @var Required $attribute */
            $attribute = $attr->newInstance();

            $apiName = $attribute->apiName ?? $apiName;
            $optional = $attribute->optional;
            $nullable |= $attribute->nullable;
            $type = $attribute->type ?? $type;
        }

        $this->apiName = $apiName;
        $this->type = self::parse($type);
        $this->nullable = (bool) $nullable;
        $this->optional = $optional;
    }

    /**
     * @param array<int|string,string>|Converter|ConverterSource|\ReflectionType|string|null $type
     */
    private static function parse(array|Converter|ConverterSource|\ReflectionType|string|null $type): Converter|ConverterSource|string
    {
        if (is_string($type) || $type instanceof Converter) {
            return $type;
        }

        if (is_array($type)) {
            return new UnionOf($type); // @phpstan-ignore-line
        }

        if ($type instanceof \ReflectionUnionType) {
            // @phpstan-ignore-next-line argument.type
            return new UnionOf(array_map(static fn ($t) => self::parse($t), array: $type->getTypes()));
        }

        if ($type instanceof \ReflectionNamedType) {
            return $type->getName();
        }

        if ($type instanceof \ReflectionIntersectionType) {
            throw new \ValueError;
        }

        return 'mixed';
    }
}
