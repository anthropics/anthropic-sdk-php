<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaCitationsDelta\Citation;
use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaCitationsDeltaShape = array{
 *   citation: BetaCitationCharLocation|BetaCitationPageLocation|BetaCitationContentBlockLocation|BetaCitationsWebSearchResultLocation|BetaCitationSearchResultLocation,
 *   type: 'citations_delta',
 * }
 */
final class BetaCitationsDelta implements BaseModel
{
    /** @use SdkModel<BetaCitationsDeltaShape> */
    use SdkModel;

    /** @var 'citations_delta' $type */
    #[Api]
    public string $type = 'citations_delta';

    #[Api(union: Citation::class)]
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
     *   cited_text: string,
     *   document_index: int,
     *   document_title: string|null,
     *   end_char_index: int,
     *   file_id: string|null,
     *   start_char_index: int,
     *   type: 'char_location',
     * }|BetaCitationPageLocation|array{
     *   cited_text: string,
     *   document_index: int,
     *   document_title: string|null,
     *   end_page_number: int,
     *   file_id: string|null,
     *   start_page_number: int,
     *   type: 'page_location',
     * }|BetaCitationContentBlockLocation|array{
     *   cited_text: string,
     *   document_index: int,
     *   document_title: string|null,
     *   end_block_index: int,
     *   file_id: string|null,
     *   start_block_index: int,
     *   type: 'content_block_location',
     * }|BetaCitationsWebSearchResultLocation|array{
     *   cited_text: string,
     *   encrypted_index: string,
     *   title: string|null,
     *   type: 'web_search_result_location',
     *   url: string,
     * }|BetaCitationSearchResultLocation|array{
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
        BetaCitationCharLocation|array|BetaCitationPageLocation|BetaCitationContentBlockLocation|BetaCitationsWebSearchResultLocation|BetaCitationSearchResultLocation $citation,
    ): self {
        $obj = new self;

        $obj['citation'] = $citation;

        return $obj;
    }

    /**
     * @param BetaCitationCharLocation|array{
     *   cited_text: string,
     *   document_index: int,
     *   document_title: string|null,
     *   end_char_index: int,
     *   file_id: string|null,
     *   start_char_index: int,
     *   type: 'char_location',
     * }|BetaCitationPageLocation|array{
     *   cited_text: string,
     *   document_index: int,
     *   document_title: string|null,
     *   end_page_number: int,
     *   file_id: string|null,
     *   start_page_number: int,
     *   type: 'page_location',
     * }|BetaCitationContentBlockLocation|array{
     *   cited_text: string,
     *   document_index: int,
     *   document_title: string|null,
     *   end_block_index: int,
     *   file_id: string|null,
     *   start_block_index: int,
     *   type: 'content_block_location',
     * }|BetaCitationsWebSearchResultLocation|array{
     *   cited_text: string,
     *   encrypted_index: string,
     *   title: string|null,
     *   type: 'web_search_result_location',
     *   url: string,
     * }|BetaCitationSearchResultLocation|array{
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
        BetaCitationCharLocation|array|BetaCitationPageLocation|BetaCitationContentBlockLocation|BetaCitationsWebSearchResultLocation|BetaCitationSearchResultLocation $citation,
    ): self {
        $obj = clone $this;
        $obj['citation'] = $citation;

        return $obj;
    }
}
