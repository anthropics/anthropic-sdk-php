<?php

declare(strict_types=1);

namespace Anthropic\Core\Attributes;

use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @internal
 */
#[\Attribute(\Attribute::TARGET_PROPERTY)]
final class Optional extends Required
{
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
        parent::__construct(apiName: $apiName, type: $type, enum: $enum, union: $union, list: $list, map: $map, nullable: $nullable);
        $this->optional = true;
    }
}
