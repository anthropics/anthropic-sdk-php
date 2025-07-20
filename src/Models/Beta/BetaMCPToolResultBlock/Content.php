<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta\BetaMCPToolResultBlock;

use Anthropic\Core\Concerns\Union;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Core\Conversion\ListOf;
use Anthropic\Models\Beta\BetaTextBlock;

/**
 * @phpstan-type content_alias = string|list<BetaTextBlock>
 */
final class Content implements ConverterSource
{
    use Union;

    /**
     * @return list<string|Converter|ConverterSource>|array<
     *   string, string|Converter|ConverterSource
     * >
     */
    public static function variants(): array
    {
        return ['string', new ListOf(BetaTextBlock::class)];
    }
}
