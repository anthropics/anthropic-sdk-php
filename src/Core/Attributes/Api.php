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
    public readonly null|Converter|ConverterSource|string $type;

    public function __construct(
        public readonly ?string $apiName = null,
        null|Converter|ConverterSource|string $type = null,
        null|Converter|ConverterSource $enum = null,
        null|Converter|ConverterSource|string $union = null,
        public readonly bool $nullable = false,
        public readonly bool $optional = false,
    ) {
        $this->type = $type ?? $enum ?? $union;
    }
}
