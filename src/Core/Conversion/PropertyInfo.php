<?php

declare(strict_types=1);

namespace Anthropic\Core\Conversion;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Contracts\Converter;
use Anthropic\Core\Contracts\StaticConverter;

/**
 * @internal
 */
final class PropertyInfo
{
    public readonly string $apiName;

    public readonly Converter|StaticConverter|string $type;

    public readonly bool $nullable;

    public readonly bool $optional;

    public function __construct(public readonly \ReflectionProperty $property)
    {
        $nullable = $property->getType()?->allowsNull() ?? false;

        $apiName = $property->getName();
        $type = $property->getType();
        $optional = false;

        foreach ($property->getAttributes(Api::class) as $attr) {
            /** @var Api $attribute */
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
     * @param null|array<int|string,string>|Converter|\ReflectionType|StaticConverter|string $type
     */
    private static function parse(null|array|Converter|\ReflectionType|StaticConverter|string $type): Converter|StaticConverter|string
    {
        if (is_string($type) || $type instanceof Converter) {
            return $type;
        }

        if (is_array($type)) {
            return new UnionOf($type);
        }

        if ($type instanceof \ReflectionUnionType) {
            return new UnionOf(array_map(static fn ($t) => self::parse($t), array: $type->getTypes()));
        }

        if ($type instanceof \ReflectionNamedType) {
            return $type->getName();
        }

        if ($type instanceof \ReflectionIntersectionType) {
            throw new \ValueError();
        }

        return 'mixed';
    }
}
