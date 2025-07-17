<?php

declare(strict_types=1);

namespace Anthropic\Core\Attributes;

use Anthropic\Core\Contracts\Converter;
use Anthropic\Core\Contracts\StaticConverter;

#[\Attribute(\Attribute::TARGET_PROPERTY)]
class Api
{
    /**
     * @param ?array<int|string,Converter|StaticConverter|string> $union
     */
    public function __construct(
        public ?string $apiName = null,
        public null|Converter|StaticConverter|string $type = null,
        public null|Converter|StaticConverter|string $enum = null,
        public null|Converter|StaticConverter|string $union = null,
        private readonly bool $nullable = false,
        public bool $optional = false,
    ) {}
}
