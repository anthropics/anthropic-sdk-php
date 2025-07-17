<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Concerns\Union;
use Anthropic\Core\Contracts\Converter;
use Anthropic\Core\Contracts\StaticConverter;

final class TextCitationParam implements StaticConverter
{
    use Union;

    public static function discriminator(): string
    {
        return 'type';
    }

    /**
     * @return list<string|Converter|StaticConverter>|array<
     *   string, string|Converter|StaticConverter
     * >
     */
    public static function variants(): array
    {
        return [
            'char_location' => CitationCharLocationParam::class,
            'page_location' => CitationPageLocationParam::class,
            'content_block_location' => CitationContentBlockLocationParam::class,
            'web_search_result_location' => CitationWebSearchResultLocationParam::class,
        ];
    }
}
