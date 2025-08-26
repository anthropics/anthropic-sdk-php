<?php

declare(strict_types=1);

namespace Anthropic\Core\Attributes;

use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Core\Conversion\ListOf;
use Anthropic\Core\Conversion\MapOf;

/**
 * @internal
 */
#[\Attribute(\Attribute::TARGET_PROPERTY)]
final class Api
{
    /**
     * @var class-string<ConverterSource>|Converter|string|null
     */
    public readonly Converter|string|null $type;

    /**
     * @param class-string<ConverterSource>|Converter|string|null $type
     * @param class-string<ConverterSource>|Converter|null        $enum
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
        $this->type = $type ?? $enum ?? $union ?? ($list ? new ListOf($list) : ($map ? new MapOf($map) : null));
    }
}
