<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Concerns\Union;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Models\AnthropicBeta\UnionMember1;

/**
 * @phpstan-type anthropic_beta_alias = string|UnionMember1::*
 */
final class AnthropicBeta implements ConverterSource
{
    use Union;

    /**
     * @return list<string|Converter|ConverterSource>|array<string,
     * string|Converter|ConverterSource,>
     */
    public static function variants(): array
    {
        return ['string', UnionMember1::class];
    }
}
