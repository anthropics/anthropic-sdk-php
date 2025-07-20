<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Concerns\Union;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-type text_citation_param_alias = CitationCharLocationParam|CitationPageLocationParam|CitationContentBlockLocationParam|CitationWebSearchResultLocationParam
 */
final class TextCitationParam implements ConverterSource
{
    use Union;

    public static function discriminator(): string
    {
        return 'type';
    }

    /**
     * @return list<string|Converter|ConverterSource>|array<
     *   string, string|Converter|ConverterSource
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
