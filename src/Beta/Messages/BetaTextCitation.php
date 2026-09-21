<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaTextCitation\Type;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-import-type BetaCitationCharLocationShape from \Anthropic\Beta\Messages\BetaCitationCharLocation
 * @phpstan-import-type BetaCitationPageLocationShape from \Anthropic\Beta\Messages\BetaCitationPageLocation
 * @phpstan-import-type BetaCitationContentBlockLocationShape from \Anthropic\Beta\Messages\BetaCitationContentBlockLocation
 * @phpstan-import-type BetaCitationsWebSearchResultLocationShape from \Anthropic\Beta\Messages\BetaCitationsWebSearchResultLocation
 * @phpstan-import-type BetaCitationSearchResultLocationShape from \Anthropic\Beta\Messages\BetaCitationSearchResultLocation
 *
 * @phpstan-type BetaTextCitationVariants = BetaCitationCharLocation|BetaCitationPageLocation|BetaCitationContentBlockLocation|BetaCitationsWebSearchResultLocation|BetaCitationSearchResultLocation
 * @phpstan-type BetaTextCitationShape = BetaTextCitationVariants|BetaCitationCharLocationShape|BetaCitationPageLocationShape|BetaCitationContentBlockLocationShape|BetaCitationsWebSearchResultLocationShape|BetaCitationSearchResultLocationShape
 */
final class BetaTextCitation implements ConverterSource
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
            'char_location' => BetaCitationCharLocation::class,
            'page_location' => BetaCitationPageLocation::class,
            'content_block_location' => BetaCitationContentBlockLocation::class,
            'web_search_result_location' => BetaCitationsWebSearchResultLocation::class,
            'search_result_location' => BetaCitationSearchResultLocation::class,
        ];
    }

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @return ($type is Type::CHAR_LOCATION|'char_location' ? BetaCitationCharLocation : ($type is Type::PAGE_LOCATION|'page_location' ? BetaCitationPageLocation : ($type is Type::CONTENT_BLOCK_LOCATION|'content_block_location' ? BetaCitationContentBlockLocation : ($type is Type::WEB_SEARCH_RESULT_LOCATION|'web_search_result_location' ? BetaCitationsWebSearchResultLocation : ($type is Type::SEARCH_RESULT_LOCATION|'search_result_location' ? BetaCitationSearchResultLocation : BetaCitationCharLocation|BetaCitationPageLocation|BetaCitationContentBlockLocation|BetaCitationsWebSearchResultLocation|BetaCitationSearchResultLocation)))))
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
    ): BetaCitationCharLocation|BetaCitationPageLocation|BetaCitationContentBlockLocation|BetaCitationsWebSearchResultLocation|BetaCitationSearchResultLocation {
        return match ($type) {
            Type::CHAR_LOCATION, 'char_location' => BetaCitationCharLocation::with(
                citedText: $citedText,
                documentIndex: $documentIndex ?? throw new \ArgumentCountError('$documentIndex is required'),
                documentTitle: $documentTitle,
                endCharIndex: $endCharIndex ?? throw new \ArgumentCountError('$endCharIndex is required'),
                fileID: $fileID,
                startCharIndex: $startCharIndex ?? throw new \ArgumentCountError('$startCharIndex is required'),
            ),
            Type::PAGE_LOCATION, 'page_location' => BetaCitationPageLocation::with(
                citedText: $citedText,
                documentIndex: $documentIndex ?? throw new \ArgumentCountError('$documentIndex is required'),
                documentTitle: $documentTitle,
                endPageNumber: $endPageNumber ?? throw new \ArgumentCountError('$endPageNumber is required'),
                fileID: $fileID,
                startPageNumber: $startPageNumber ?? throw new \ArgumentCountError('$startPageNumber is required'),
            ),
            Type::CONTENT_BLOCK_LOCATION, 'content_block_location' => BetaCitationContentBlockLocation::with(
                citedText: $citedText,
                documentIndex: $documentIndex ?? throw new \ArgumentCountError('$documentIndex is required'),
                documentTitle: $documentTitle,
                endBlockIndex: $endBlockIndex ?? throw new \ArgumentCountError('$endBlockIndex is required'),
                fileID: $fileID,
                startBlockIndex: $startBlockIndex ?? throw new \ArgumentCountError('$startBlockIndex is required'),
            ),
            Type::WEB_SEARCH_RESULT_LOCATION, 'web_search_result_location' => BetaCitationsWebSearchResultLocation::with(
                citedText: $citedText,
                encryptedIndex: $encryptedIndex ?? throw new \ArgumentCountError('$encryptedIndex is required'),
                title: $title,
                url: $url ?? throw new \ArgumentCountError('$url is required'),
            ),
            Type::SEARCH_RESULT_LOCATION, 'search_result_location' => BetaCitationSearchResultLocation::with(
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
