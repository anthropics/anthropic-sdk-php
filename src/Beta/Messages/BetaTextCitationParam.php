<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaTextCitationParam\Type;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-import-type BetaCitationCharLocationParamShape from \Anthropic\Beta\Messages\BetaCitationCharLocationParam
 * @phpstan-import-type BetaCitationPageLocationParamShape from \Anthropic\Beta\Messages\BetaCitationPageLocationParam
 * @phpstan-import-type BetaCitationContentBlockLocationParamShape from \Anthropic\Beta\Messages\BetaCitationContentBlockLocationParam
 * @phpstan-import-type BetaCitationWebSearchResultLocationParamShape from \Anthropic\Beta\Messages\BetaCitationWebSearchResultLocationParam
 * @phpstan-import-type BetaCitationSearchResultLocationParamShape from \Anthropic\Beta\Messages\BetaCitationSearchResultLocationParam
 *
 * @phpstan-type BetaTextCitationParamVariants = BetaCitationCharLocationParam|BetaCitationPageLocationParam|BetaCitationContentBlockLocationParam|BetaCitationWebSearchResultLocationParam|BetaCitationSearchResultLocationParam
 * @phpstan-type BetaTextCitationParamShape = BetaTextCitationParamVariants|BetaCitationCharLocationParamShape|BetaCitationPageLocationParamShape|BetaCitationContentBlockLocationParamShape|BetaCitationWebSearchResultLocationParamShape|BetaCitationSearchResultLocationParamShape
 */
final class BetaTextCitationParam implements ConverterSource
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
            'char_location' => BetaCitationCharLocationParam::class,
            'page_location' => BetaCitationPageLocationParam::class,
            'content_block_location' => BetaCitationContentBlockLocationParam::class,
            'web_search_result_location' => BetaCitationWebSearchResultLocationParam::class,
            'search_result_location' => BetaCitationSearchResultLocationParam::class,
        ];
    }

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @return ($type is Type::CHAR_LOCATION|'char_location' ? BetaCitationCharLocationParam : ($type is Type::PAGE_LOCATION|'page_location' ? BetaCitationPageLocationParam : ($type is Type::CONTENT_BLOCK_LOCATION|'content_block_location' ? BetaCitationContentBlockLocationParam : ($type is Type::WEB_SEARCH_RESULT_LOCATION|'web_search_result_location' ? BetaCitationWebSearchResultLocationParam : ($type is Type::SEARCH_RESULT_LOCATION|'search_result_location' ? BetaCitationSearchResultLocationParam : BetaCitationCharLocationParam|BetaCitationPageLocationParam|BetaCitationContentBlockLocationParam|BetaCitationWebSearchResultLocationParam|BetaCitationSearchResultLocationParam)))))
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
    ): BetaCitationCharLocationParam|BetaCitationPageLocationParam|BetaCitationContentBlockLocationParam|BetaCitationWebSearchResultLocationParam|BetaCitationSearchResultLocationParam {
        return match ($type) {
            Type::CHAR_LOCATION, 'char_location' => BetaCitationCharLocationParam::with(
                citedText: $citedText,
                documentIndex: $documentIndex ?? throw new \ArgumentCountError('$documentIndex is required'),
                documentTitle: $documentTitle,
                endCharIndex: $endCharIndex ?? throw new \ArgumentCountError('$endCharIndex is required'),
                startCharIndex: $startCharIndex ?? throw new \ArgumentCountError('$startCharIndex is required'),
            ),
            Type::PAGE_LOCATION, 'page_location' => BetaCitationPageLocationParam::with(
                citedText: $citedText,
                documentIndex: $documentIndex ?? throw new \ArgumentCountError('$documentIndex is required'),
                documentTitle: $documentTitle,
                endPageNumber: $endPageNumber ?? throw new \ArgumentCountError('$endPageNumber is required'),
                startPageNumber: $startPageNumber ?? throw new \ArgumentCountError('$startPageNumber is required'),
            ),
            Type::CONTENT_BLOCK_LOCATION, 'content_block_location' => BetaCitationContentBlockLocationParam::with(
                citedText: $citedText,
                documentIndex: $documentIndex ?? throw new \ArgumentCountError('$documentIndex is required'),
                documentTitle: $documentTitle,
                endBlockIndex: $endBlockIndex ?? throw new \ArgumentCountError('$endBlockIndex is required'),
                startBlockIndex: $startBlockIndex ?? throw new \ArgumentCountError('$startBlockIndex is required'),
            ),
            Type::WEB_SEARCH_RESULT_LOCATION, 'web_search_result_location' => BetaCitationWebSearchResultLocationParam::with(
                citedText: $citedText,
                encryptedIndex: $encryptedIndex ?? throw new \ArgumentCountError('$encryptedIndex is required'),
                title: $title,
                url: $url ?? throw new \ArgumentCountError('$url is required'),
            ),
            Type::SEARCH_RESULT_LOCATION, 'search_result_location' => BetaCitationSearchResultLocationParam::with(
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
