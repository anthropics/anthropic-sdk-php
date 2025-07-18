<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta\BetaToolResultBlockParam;

use Anthropic\Core\Concerns\Union;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Core\Conversion\ListOf;
use Anthropic\Core\Conversion\UnionOf;
use Anthropic\Models\Beta\BetaImageBlockParam;
use Anthropic\Models\Beta\BetaSearchResultBlockParam;
use Anthropic\Models\Beta\BetaTextBlockParam;

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
        return [
            'string',
            new ListOf(
                new UnionOf(
                    [
                        BetaTextBlockParam::class,
                        BetaImageBlockParam::class,
                        BetaSearchResultBlockParam::class,
                    ],
                ),
            ),
        ];
    }
}
