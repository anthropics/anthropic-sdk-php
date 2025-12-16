<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-import-type CitationCharLocationParamShape from \Anthropic\Messages\CitationCharLocationParam
 * @phpstan-import-type CitationPageLocationParamShape from \Anthropic\Messages\CitationPageLocationParam
 * @phpstan-import-type CitationContentBlockLocationParamShape from \Anthropic\Messages\CitationContentBlockLocationParam
 * @phpstan-import-type CitationWebSearchResultLocationParamShape from \Anthropic\Messages\CitationWebSearchResultLocationParam
 * @phpstan-import-type CitationSearchResultLocationParamShape from \Anthropic\Messages\CitationSearchResultLocationParam
 *
 * @phpstan-type TextCitationParamShape = CitationCharLocationParamShape|CitationPageLocationParamShape|CitationContentBlockLocationParamShape|CitationWebSearchResultLocationParamShape|CitationSearchResultLocationParamShape
 */
final class TextCitationParam implements ConverterSource
{
    use SdkUnion;

    public static function discriminator(): string
    {
        return 'type';
    }

    /**
     * @return list<string|Converter|ConverterSource>|array<string,string|Converter|ConverterSource>
     */
    public static function variants(): array
    {
        return [
            'char_location' => CitationCharLocationParam::class,
            'page_location' => CitationPageLocationParam::class,
            'content_block_location' => CitationContentBlockLocationParam::class,
            'web_search_result_location' => CitationWebSearchResultLocationParam::class,
            'search_result_location' => CitationSearchResultLocationParam::class,
        ];
    }
}
