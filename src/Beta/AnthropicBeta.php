<?php

declare(strict_types=1);

namespace Anthropic\Beta;

use Anthropic\Beta\AnthropicBeta\UnionMember1;
use Anthropic\Core\Concerns\Union;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-type anthropic_beta_alias = string|UnionMember1::*
 */
final class AnthropicBeta implements ConverterSource
{
    use Union;

    /**
     * @return array<string,
     * Converter|ConverterSource|string,>|list<Converter|ConverterSource|string>
     */
    public static function variants(): array
    {
        return ['string', UnionMember1::class];
    }
}
