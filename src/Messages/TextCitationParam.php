<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Messages\TextCitationParam\Type;

/**
 * @phpstan-import-type CitationCharLocationParamShape from \Anthropic\Messages\CitationCharLocationParam
 * @phpstan-import-type CitationPageLocationParamShape from \Anthropic\Messages\CitationPageLocationParam
 * @phpstan-import-type CitationContentBlockLocationParamShape from \Anthropic\Messages\CitationContentBlockLocationParam
 * @phpstan-import-type CitationWebSearchResultLocationParamShape from \Anthropic\Messages\CitationWebSearchResultLocationParam
 * @phpstan-import-type CitationSearchResultLocationParamShape from \Anthropic\Messages\CitationSearchResultLocationParam
 *
 * @phpstan-type TextCitationParamVariants = CitationCharLocationParam|CitationPageLocationParam|CitationContentBlockLocationParam|CitationWebSearchResultLocationParam|CitationSearchResultLocationParam
 * @phpstan-type TextCitationParamShape = TextCitationParamVariants|CitationCharLocationParamShape|CitationPageLocationParamShape|CitationContentBlockLocationParamShape|CitationWebSearchResultLocationParamShape|CitationSearchResultLocationParamShape
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

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @return ($type is Type::CHAR_LOCATION|'char_location' ? CitationCharLocationParam : ($type is Type::PAGE_LOCATION|'page_location' ? CitationPageLocationParam : ($type is Type::CONTENT_BLOCK_LOCATION|'content_block_location' ? CitationContentBlockLocationParam : ($type is Type::WEB_SEARCH_RESULT_LOCATION|'web_search_result_location' ? CitationWebSearchResultLocationParam : ($type is Type::SEARCH_RESULT_LOCATION|'search_result_location' ? CitationSearchResultLocationParam : CitationCharLocationParam|CitationPageLocationParam|CitationContentBlockLocationParam|CitationWebSearchResultLocationParam|CitationSearchResultLocationParam)))))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        string $citedText,
        ?int $documentIndex = null,
        ?string $documentTitle = null,
        ?int $endCharIndex = null,
        ?int $startCharIndex = null,
        ?int $endPageNumber = null,
        ?int $startPageNumber = null,
        ?int $endBlockIndex = null,
        ?int $startBlockIndex = null,
        ?string $encryptedIndex = null,
        ?string $title = null,
        ?string $url = null,
        ?int $searchResultIndex = null,
        ?string $source = null,
    ): CitationCharLocationParam|CitationPageLocationParam|CitationContentBlockLocationParam|CitationWebSearchResultLocationParam|CitationSearchResultLocationParam {
        return match ($type) {
            Type::CHAR_LOCATION, 'char_location' => CitationCharLocationParam::with(
                citedText: $citedText,
                documentIndex: $documentIndex ?? throw new \ArgumentCountError('$documentIndex is required'),
                documentTitle: $documentTitle,
                endCharIndex: $endCharIndex ?? throw new \ArgumentCountError('$endCharIndex is required'),
                startCharIndex: $startCharIndex ?? throw new \ArgumentCountError('$startCharIndex is required'),
            ),
            Type::PAGE_LOCATION, 'page_location' => CitationPageLocationParam::with(
                citedText: $citedText,
                documentIndex: $documentIndex ?? throw new \ArgumentCountError('$documentIndex is required'),
                documentTitle: $documentTitle,
                endPageNumber: $endPageNumber ?? throw new \ArgumentCountError('$endPageNumber is required'),
                startPageNumber: $startPageNumber ?? throw new \ArgumentCountError('$startPageNumber is required'),
            ),
            Type::CONTENT_BLOCK_LOCATION, 'content_block_location' => CitationContentBlockLocationParam::with(
                citedText: $citedText,
                documentIndex: $documentIndex ?? throw new \ArgumentCountError('$documentIndex is required'),
                documentTitle: $documentTitle,
                endBlockIndex: $endBlockIndex ?? throw new \ArgumentCountError('$endBlockIndex is required'),
                startBlockIndex: $startBlockIndex ?? throw new \ArgumentCountError('$startBlockIndex is required'),
            ),
            Type::WEB_SEARCH_RESULT_LOCATION, 'web_search_result_location' => CitationWebSearchResultLocationParam::with(
                citedText: $citedText,
                encryptedIndex: $encryptedIndex ?? throw new \ArgumentCountError('$encryptedIndex is required'),
                title: $title,
                url: $url ?? throw new \ArgumentCountError('$url is required'),
            ),
            Type::SEARCH_RESULT_LOCATION, 'search_result_location' => CitationSearchResultLocationParam::with(
                citedText: $citedText,
                endBlockIndex: $endBlockIndex ?? throw new \ArgumentCountError('$endBlockIndex is required'),
                searchResultIndex: $searchResultIndex ?? throw new \ArgumentCountError('$searchResultIndex is required'),
                source: $source ?? throw new \ArgumentCountError('$source is required'),
                startBlockIndex: $startBlockIndex ?? throw new \ArgumentCountError('$startBlockIndex is required'),
                title: $title,
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
