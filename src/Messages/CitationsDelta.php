<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Messages\CitationsDelta\Citation;

/**
 * @phpstan-type CitationsDeltaShape = array{
 *   citation: CitationCharLocation|CitationPageLocation|CitationContentBlockLocation|CitationsWebSearchResultLocation|CitationsSearchResultLocation,
 *   type: 'citations_delta',
 * }
 */
final class CitationsDelta implements BaseModel
{
    /** @use SdkModel<CitationsDeltaShape> */
    use SdkModel;

    /** @var 'citations_delta' $type */
    #[Api]
    public string $type = 'citations_delta';

    #[Api(union: Citation::class)]
    public CitationCharLocation|CitationPageLocation|CitationContentBlockLocation|CitationsWebSearchResultLocation|CitationsSearchResultLocation $citation;

    /**
     * `new CitationsDelta()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * CitationsDelta::with(citation: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new CitationsDelta)->withCitation(...)
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
     * @param CitationCharLocation|array{
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
     * } $citation
     */
    public static function with(
        CitationCharLocation|array|CitationPageLocation|CitationContentBlockLocation|CitationsWebSearchResultLocation|CitationsSearchResultLocation $citation,
    ): self {
        $obj = new self;

        $obj['citation'] = $citation;

        return $obj;
    }

    /**
     * @param CitationCharLocation|array{
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
     * } $citation
     */
    public function withCitation(
        CitationCharLocation|array|CitationPageLocation|CitationContentBlockLocation|CitationsWebSearchResultLocation|CitationsSearchResultLocation $citation,
    ): self {
        $obj = clone $this;
        $obj['citation'] = $citation;

        return $obj;
    }
}
