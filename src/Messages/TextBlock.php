<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type TextBlockShape = array{
 *   citations: list<CitationCharLocation|CitationPageLocation|CitationContentBlockLocation|CitationsWebSearchResultLocation|CitationsSearchResultLocation>|null,
 *   text: string,
 *   type: 'text',
 * }
 */
final class TextBlock implements BaseModel
{
    /** @use SdkModel<TextBlockShape> */
    use SdkModel;

    /** @var 'text' $type */
    #[Required]
    public string $type = 'text';

    /**
     * Citations supporting the text block.
     *
     * The type of citation returned will depend on the type of document being cited. Citing a PDF results in `page_location`, plain text results in `char_location`, and content document results in `content_block_location`.
     *
     * @var list<CitationCharLocation|CitationPageLocation|CitationContentBlockLocation|CitationsWebSearchResultLocation|CitationsSearchResultLocation>|null $citations
     */
    #[Required(list: TextCitation::class)]
    public ?array $citations;

    #[Required]
    public string $text;

    /**
     * `new TextBlock()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * TextBlock::with(citations: ..., text: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new TextBlock)->withCitations(...)->withText(...)
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
     * @param list<CitationCharLocation|array{
     *   cited_text: string,
     *   document_index: int,
     *   document_title: string|null,
     *   end_char_index: int,
     *   file_id: string|null,
     *   start_char_index: int,
     *   type: 'char_location',
     * }|CitationPageLocation|array{
     *   cited_text: string,
     *   document_index: int,
     *   document_title: string|null,
     *   end_page_number: int,
     *   file_id: string|null,
     *   start_page_number: int,
     *   type: 'page_location',
     * }|CitationContentBlockLocation|array{
     *   cited_text: string,
     *   document_index: int,
     *   document_title: string|null,
     *   end_block_index: int,
     *   file_id: string|null,
     *   start_block_index: int,
     *   type: 'content_block_location',
     * }|CitationsWebSearchResultLocation|array{
     *   cited_text: string,
     *   encrypted_index: string,
     *   title: string|null,
     *   type: 'web_search_result_location',
     *   url: string,
     * }|CitationsSearchResultLocation|array{
     *   cited_text: string,
     *   end_block_index: int,
     *   search_result_index: int,
     *   source: string,
     *   start_block_index: int,
     *   title: string|null,
     *   type: 'search_result_location',
     * }>|null $citations
     */
    public static function with(?array $citations, string $text): self
    {
        $obj = new self;

        $obj['citations'] = $citations;
        $obj['text'] = $text;

        return $obj;
    }

    /**
     * Citations supporting the text block.
     *
     * The type of citation returned will depend on the type of document being cited. Citing a PDF results in `page_location`, plain text results in `char_location`, and content document results in `content_block_location`.
     *
     * @param list<CitationCharLocation|array{
     *   cited_text: string,
     *   document_index: int,
     *   document_title: string|null,
     *   end_char_index: int,
     *   file_id: string|null,
     *   start_char_index: int,
     *   type: 'char_location',
     * }|CitationPageLocation|array{
     *   cited_text: string,
     *   document_index: int,
     *   document_title: string|null,
     *   end_page_number: int,
     *   file_id: string|null,
     *   start_page_number: int,
     *   type: 'page_location',
     * }|CitationContentBlockLocation|array{
     *   cited_text: string,
     *   document_index: int,
     *   document_title: string|null,
     *   end_block_index: int,
     *   file_id: string|null,
     *   start_block_index: int,
     *   type: 'content_block_location',
     * }|CitationsWebSearchResultLocation|array{
     *   cited_text: string,
     *   encrypted_index: string,
     *   title: string|null,
     *   type: 'web_search_result_location',
     *   url: string,
     * }|CitationsSearchResultLocation|array{
     *   cited_text: string,
     *   end_block_index: int,
     *   search_result_index: int,
     *   source: string,
     *   start_block_index: int,
     *   title: string|null,
     *   type: 'search_result_location',
     * }>|null $citations
     */
    public function withCitations(?array $citations): self
    {
        $obj = clone $this;
        $obj['citations'] = $citations;

        return $obj;
    }

    public function withText(string $text): self
    {
        $obj = clone $this;
        $obj['text'] = $text;

        return $obj;
    }
}
