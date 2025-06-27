<?php

declare(strict_types=1);

namespace Anthropic\Core\Attributes;

use Anthropic\Core\Contracts\Converter;
use Anthropic\Core\Contracts\StaticConverter;

#[\Attribute(\Attribute::TARGET_PROPERTY)]
class Api
{
    /**
     * @param ?array<string|int,string|Converter|StaticConverter> $union
     */
    public function __construct(
        public ?string $apiName = null,
        public string|Converter|StaticConverter|null $type = null,
        public bool $optional = false,
        public ?string $discriminator = null,
        public ?array $union = null,
    ) {
    }
}
