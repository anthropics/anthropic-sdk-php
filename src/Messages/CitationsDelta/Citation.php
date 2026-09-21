<?php

declare(strict_types=1);

namespace Anthropic\Messages\CitationsDelta;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Messages\CitationCharLocation;
use Anthropic\Messages\CitationContentBlockLocation;
use Anthropic\Messages\CitationPageLocation;
use Anthropic\Messages\CitationsDelta\Citation\Type;
use Anthropic\Messages\CitationsSearchResultLocation;
use Anthropic\Messages\CitationsWebSearchResultLocation;

/**
 * @phpstan-import-type CitationCharLocationShape from \Anthropic\Messages\CitationCharLocation
 * @phpstan-import-type CitationPageLocationShape from \Anthropic\Messages\CitationPageLocation
 * @phpstan-import-type CitationContentBlockLocationShape from \Anthropic\Messages\CitationContentBlockLocation
 * @phpstan-import-type CitationsWebSearchResultLocationShape from \Anthropic\Messages\CitationsWebSearchResultLocation
 * @phpstan-import-type CitationsSearchResultLocationShape from \Anthropic\Messages\CitationsSearchResultLocation
 *
 * @phpstan-type CitationVariants = CitationCharLocation|CitationPageLocation|CitationContentBlockLocation|CitationsWebSearchResultLocation|CitationsSearchResultLocation
 * @phpstan-type CitationShape = CitationVariants|CitationCharLocationShape|CitationPageLocationShape|CitationContentBlockLocationShape|CitationsWebSearchResultLocationShape|CitationsSearchResultLocationShape
 */
final class Citation implements ConverterSource
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
            'char_location' => CitationCharLocation::class,
            'page_location' => CitationPageLocation::class,
            'content_block_location' => CitationContentBlockLocation::class,
            'web_search_result_location' => CitationsWebSearchResultLocation::class,
            'search_result_location' => CitationsSearchResultLocation::class,
        ];
    }

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @return ($type is Type::CHAR_LOCATION|'char_location' ? CitationCharLocation : ($type is Type::PAGE_LOCATION|'page_location' ? CitationPageLocation : ($type is Type::CONTENT_BLOCK_LOCATION|'content_block_location' ? CitationContentBlockLocation : ($type is Type::WEB_SEARCH_RESULT_LOCATION|'web_search_result_location' ? CitationsWebSearchResultLocation : ($type is Type::SEARCH_RESULT_LOCATION|'search_result_location' ? CitationsSearchResultLocation : CitationCharLocation|CitationPageLocation|CitationContentBlockLocation|CitationsWebSearchResultLocation|CitationsSearchResultLocation)))))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        string $citedText,
        ?int $documentIndex = null,
        ?string $documentTitle = null,
        ?int $endCharIndex = null,
        ?string $fileID = null,
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
    ): CitationCharLocation|CitationPageLocation|CitationContentBlockLocation|CitationsWebSearchResultLocation|CitationsSearchResultLocation {
        return match ($type) {
            Type::CHAR_LOCATION, 'char_location' => CitationCharLocation::with(
                citedText: $citedText,
                documentIndex: $documentIndex ?? throw new \ArgumentCountError('$documentIndex is required'),
                documentTitle: $documentTitle,
                endCharIndex: $endCharIndex ?? throw new \ArgumentCountError('$endCharIndex is required'),
                fileID: $fileID,
                startCharIndex: $startCharIndex ?? throw new \ArgumentCountError('$startCharIndex is required'),
            ),
            Type::PAGE_LOCATION, 'page_location' => CitationPageLocation::with(
                citedText: $citedText,
                documentIndex: $documentIndex ?? throw new \ArgumentCountError('$documentIndex is required'),
                documentTitle: $documentTitle,
                endPageNumber: $endPageNumber ?? throw new \ArgumentCountError('$endPageNumber is required'),
                fileID: $fileID,
                startPageNumber: $startPageNumber ?? throw new \ArgumentCountError('$startPageNumber is required'),
            ),
            Type::CONTENT_BLOCK_LOCATION, 'content_block_location' => CitationContentBlockLocation::with(
                citedText: $citedText,
                documentIndex: $documentIndex ?? throw new \ArgumentCountError('$documentIndex is required'),
                documentTitle: $documentTitle,
                endBlockIndex: $endBlockIndex ?? throw new \ArgumentCountError('$endBlockIndex is required'),
                fileID: $fileID,
                startBlockIndex: $startBlockIndex ?? throw new \ArgumentCountError('$startBlockIndex is required'),
            ),
            Type::WEB_SEARCH_RESULT_LOCATION, 'web_search_result_location' => CitationsWebSearchResultLocation::with(
                citedText: $citedText,
                encryptedIndex: $encryptedIndex ?? throw new \ArgumentCountError('$encryptedIndex is required'),
                title: $title,
                url: $url ?? throw new \ArgumentCountError('$url is required'),
            ),
            Type::SEARCH_RESULT_LOCATION, 'search_result_location' => CitationsSearchResultLocation::with(
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
