<?php

declare(strict_types=1);

namespace Anthropic\Core\Attributes;

use Anthropic\Core\Contracts\Converter;
use Anthropic\Core\Contracts\StaticConverter;

/**
 * @internal
 */
#[\Attribute(\Attribute::TARGET_PROPERTY)]
final class Api
{
    public readonly null|Converter|StaticConverter|string $type;

    public function __construct(
        public readonly ?string $apiName = null,
        null|Converter|StaticConverter|string $type = null,
        null|Converter|StaticConverter $enum = null,
        null|Converter|StaticConverter|string $union = null,
        public readonly bool $nullable = false,
        public readonly bool $optional = false,
    ) {
        $this->type = $type ?? $enum ?? $union;
    }
}
