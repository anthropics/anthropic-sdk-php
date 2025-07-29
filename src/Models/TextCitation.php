<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Concerns\Union;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-type text_citation_alias = CitationCharLocation|CitationPageLocation|CitationContentBlockLocation|CitationsWebSearchResultLocation
 */
final class TextCitation implements ConverterSource
{
    use Union;

    public static function discriminator(): string
    {
        return 'type';
    }

    /**
     * @return array<string,
     * Converter|ConverterSource|string,>|list<Converter|ConverterSource|string>
     */
    public static function variants(): array
    {
        return [
            'char_location' => CitationCharLocation::class,
            'page_location' => CitationPageLocation::class,
            'content_block_location' => CitationContentBlockLocation::class,
            'web_search_result_location' => CitationsWebSearchResultLocation::class,
        ];
    }
}
