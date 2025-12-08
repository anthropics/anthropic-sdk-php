<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type CitationPageLocationParamShape = array{
 *   cited_text: string,
 *   document_index: int,
 *   document_title: string|null,
 *   end_page_number: int,
 *   start_page_number: int,
 *   type: 'page_location',
 * }
 */
final class CitationPageLocationParam implements BaseModel
{
    /** @use SdkModel<CitationPageLocationParamShape> */
    use SdkModel;

    /** @var 'page_location' $type */
    #[Required]
    public string $type = 'page_location';

    #[Required]
    public string $cited_text;

    #[Required]
    public int $document_index;

    #[Required]
    public ?string $document_title;

    #[Required]
    public int $end_page_number;

    #[Required]
    public int $start_page_number;

    /**
     * `new CitationPageLocationParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * CitationPageLocationParam::with(
     *   cited_text: ...,
     *   document_index: ...,
     *   document_title: ...,
     *   end_page_number: ...,
     *   start_page_number: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new CitationPageLocationParam)
     *   ->withCitedText(...)
     *   ->withDocumentIndex(...)
     *   ->withDocumentTitle(...)
     *   ->withEndPageNumber(...)
     *   ->withStartPageNumber(...)
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
     */
    public static function with(
        string $cited_text,
        int $document_index,
        ?string $document_title,
        int $end_page_number,
        int $start_page_number,
    ): self {
        $obj = new self;

        $obj['cited_text'] = $cited_text;
        $obj['document_index'] = $document_index;
        $obj['document_title'] = $document_title;
        $obj['end_page_number'] = $end_page_number;
        $obj['start_page_number'] = $start_page_number;

        return $obj;
    }

    public function withCitedText(string $citedText): self
    {
        $obj = clone $this;
        $obj['cited_text'] = $citedText;

        return $obj;
    }

    public function withDocumentIndex(int $documentIndex): self
    {
        $obj = clone $this;
        $obj['document_index'] = $documentIndex;

        return $obj;
    }

    public function withDocumentTitle(?string $documentTitle): self
    {
        $obj = clone $this;
        $obj['document_title'] = $documentTitle;

        return $obj;
    }

    public function withEndPageNumber(int $endPageNumber): self
    {
        $obj = clone $this;
        $obj['end_page_number'] = $endPageNumber;

        return $obj;
    }

    public function withStartPageNumber(int $startPageNumber): self
    {
        $obj = clone $this;
        $obj['start_page_number'] = $startPageNumber;

        return $obj;
    }
}
