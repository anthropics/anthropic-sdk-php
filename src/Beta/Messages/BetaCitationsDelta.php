<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaCitationsDelta\Citation;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaCitationsDeltaShape = array{
 *   citation: BetaCitationCharLocation|BetaCitationPageLocation|BetaCitationContentBlockLocation|BetaCitationsWebSearchResultLocation|BetaCitationSearchResultLocation,
 *   type?: 'citations_delta',
 * }
 */
final class BetaCitationsDelta implements BaseModel
{
    /** @use SdkModel<BetaCitationsDeltaShape> */
    use SdkModel;

    /** @var 'citations_delta' $type */
    #[Required]
    public string $type = 'citations_delta';

    #[Required(union: Citation::class)]
    public BetaCitationCharLocation|BetaCitationPageLocation|BetaCitationContentBlockLocation|BetaCitationsWebSearchResultLocation|BetaCitationSearchResultLocation $citation;

    /**
     * `new BetaCitationsDelta()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaCitationsDelta::with(citation: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaCitationsDelta)->withCitation(...)
     * ```
     */
    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param BetaCitationCharLocation|array{
     *   citedText: string,
     *   documentIndex: int,
     *   documentTitle: string|null,
     *   endCharIndex: int,
     *   fileID: string|null,
     *   startCharIndex: int,
     *   type?: 'char_location',
     * }|BetaCitationPageLocation|array{
     *   citedText: string,
     *   documentIndex: int,
     *   documentTitle: string|null,
     *   endPageNumber: int,
     *   fileID: string|null,
     *   startPageNumber: int,
     *   type?: 'page_location',
     * }|BetaCitationContentBlockLocation|array{
     *   citedText: string,
     *   documentIndex: int,
     *   documentTitle: string|null,
     *   endBlockIndex: int,
     *   fileID: string|null,
     *   startBlockIndex: int,
     *   type?: 'content_block_location',
     * }|BetaCitationsWebSearchResultLocation|array{
     *   citedText: string,
     *   encryptedIndex: string,
     *   title: string|null,
     *   type?: 'web_search_result_location',
     *   url: string,
     * }|BetaCitationSearchResultLocation|array{
     *   citedText: string,
     *   endBlockIndex: int,
     *   searchResultIndex: int,
     *   source: string,
     *   startBlockIndex: int,
     *   title: string|null,
     *   type?: 'search_result_location',
     * } $citation
     */
    public static function with(
        BetaCitationCharLocation|array|BetaCitationPageLocation|BetaCitationContentBlockLocation|BetaCitationsWebSearchResultLocation|BetaCitationSearchResultLocation $citation,
    ): self {
        $self = new self;

        $self['citation'] = $citation;

        return $self;
    }

    /**
     * @param BetaCitationCharLocation|array{
     *   citedText: string,
     *   documentIndex: int,
     *   documentTitle: string|null,
     *   endCharIndex: int,
     *   fileID: string|null,
     *   startCharIndex: int,
     *   type?: 'char_location',
     * }|BetaCitationPageLocation|array{
     *   citedText: string,
     *   documentIndex: int,
     *   documentTitle: string|null,
     *   endPageNumber: int,
     *   fileID: string|null,
     *   startPageNumber: int,
     *   type?: 'page_location',
     * }|BetaCitationContentBlockLocation|array{
     *   citedText: string,
     *   documentIndex: int,
     *   documentTitle: string|null,
     *   endBlockIndex: int,
     *   fileID: string|null,
     *   startBlockIndex: int,
     *   type?: 'content_block_location',
     * }|BetaCitationsWebSearchResultLocation|array{
     *   citedText: string,
     *   encryptedIndex: string,
     *   title: string|null,
     *   type?: 'web_search_result_location',
     *   url: string,
     * }|BetaCitationSearchResultLocation|array{
     *   citedText: string,
     *   endBlockIndex: int,
     *   searchResultIndex: int,
     *   source: string,
     *   startBlockIndex: int,
     *   title: string|null,
     *   type?: 'search_result_location',
     * } $citation
     */
    public function withCitation(
        BetaCitationCharLocation|array|BetaCitationPageLocation|BetaCitationContentBlockLocation|BetaCitationsWebSearchResultLocation|BetaCitationSearchResultLocation $citation,
    ): self {
        $self = clone $this;
        $self['citation'] = $citation;

        return $self;
    }
}
