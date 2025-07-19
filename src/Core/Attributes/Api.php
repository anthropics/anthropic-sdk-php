<?php

declare(strict_types=1);

namespace Anthropic\Core\Attributes;

use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @internal
 */
#[\Attribute(\Attribute::TARGET_PROPERTY)]
final class Api
{
    /**
     * @var null|class-string<ConverterSource>|Converter|string
     */
    public readonly null|Converter|string $type;

    /**
     * @param null|class-string<ConverterSource>|Converter|string $type
     * @param null|class-string<ConverterSource>|Converter        $enum
     * @param null|class-string<ConverterSource>|Converter        $union
     */
    public function __construct(
        public readonly ?string $apiName = null,
        null|Converter|string $type = null,
        null|Converter|string $enum = null,
        null|Converter|string $union = null,
        public readonly bool $nullable = false,
        public readonly bool $optional = false,
    ) {
        $this->type = $type ?? $enum ?? $union;
    }
}
