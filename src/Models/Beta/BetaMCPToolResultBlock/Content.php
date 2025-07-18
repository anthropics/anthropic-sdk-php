<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta\BetaMCPToolResultBlock;

use Anthropic\Core\Concerns\Union;
use Anthropic\Core\Contracts\Converter;
use Anthropic\Core\Contracts\StaticConverter;
use Anthropic\Core\Conversion\ListOf;
use Anthropic\Models\Beta\BetaTextBlock;

final class Content implements StaticConverter
{
    use Union;

    /**
     * @return list<string|Converter|StaticConverter>|array<
     *   string, string|Converter|StaticConverter
     * >
     */
    public static function variants(): array
    {
        return ['string', new ListOf(BetaTextBlock::class)];
    }
}
