<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaTextBlockShape = array{
 *   citations: list<BetaCitationCharLocation|BetaCitationPageLocation|BetaCitationContentBlockLocation|BetaCitationsWebSearchResultLocation|BetaCitationSearchResultLocation>|null,
 *   text: string,
 *   type?: 'text',
 * }
 */
final class BetaTextBlock implements BaseModel
{
    /** @use SdkModel<BetaTextBlockShape> */
    use SdkModel;

    /** @var 'text' $type */
    #[Required]
    public string $type = 'text';

    /**
     * Citations supporting the text block.
     *
     * The type of citation returned will depend on the type of document being cited. Citing a PDF results in `page_location`, plain text results in `char_location`, and content document results in `content_block_location`.
     *
     * @var list<BetaCitationCharLocation|BetaCitationPageLocation|BetaCitationContentBlockLocation|BetaCitationsWebSearchResultLocation|BetaCitationSearchResultLocation>|null $citations
     */
    #[Required(list: BetaTextCitation::class)]
    public ?array $citations;

    #[Required]
    public string $text;

    /**
     * `new BetaTextBlock()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaTextBlock::with(citations: ..., text: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaTextBlock)->withCitations(...)->withText(...)
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
     * @param list<BetaCitationCharLocation|array{
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
     * }>|null $citations
     */
    public static function with(?array $citations, string $text): self
    {
        $self = new self;

        $self['citations'] = $citations;
        $self['text'] = $text;

        return $self;
    }

    /**
     * Citations supporting the text block.
     *
     * The type of citation returned will depend on the type of document being cited. Citing a PDF results in `page_location`, plain text results in `char_location`, and content document results in `content_block_location`.
     *
     * @param list<BetaCitationCharLocation|array{
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
     * }>|null $citations
     */
    public function withCitations(?array $citations): self
    {
        $self = clone $this;
        $self['citations'] = $citations;

        return $self;
    }

    public function withText(string $text): self
    {
        $self = clone $this;
        $self['text'] = $text;

        return $self;
    }
}
