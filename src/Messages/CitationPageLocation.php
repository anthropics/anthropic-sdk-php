<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type CitationPageLocationShape = array{
 *   cited_text: string,
 *   document_index: int,
 *   document_title: string|null,
 *   end_page_number: int,
 *   file_id: string|null,
 *   start_page_number: int,
 *   type: 'page_location',
 * }
 */
final class CitationPageLocation implements BaseModel
{
    /** @use SdkModel<CitationPageLocationShape> */
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
    public ?string $file_id;

    #[Required]
    public int $start_page_number;

    /**
     * `new CitationPageLocation()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * CitationPageLocation::with(
     *   cited_text: ...,
     *   document_index: ...,
     *   document_title: ...,
     *   end_page_number: ...,
     *   file_id: ...,
     *   start_page_number: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new CitationPageLocation)
     *   ->withCitedText(...)
     *   ->withDocumentIndex(...)
     *   ->withDocumentTitle(...)
     *   ->withEndPageNumber(...)
     *   ->withFileID(...)
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
        ?string $file_id,
        int $start_page_number,
    ): self {
        $obj = new self;

        $obj['cited_text'] = $cited_text;
        $obj['document_index'] = $document_index;
        $obj['document_title'] = $document_title;
        $obj['end_page_number'] = $end_page_number;
        $obj['file_id'] = $file_id;
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

    public function withFileID(?string $fileID): self
    {
        $obj = clone $this;
        $obj['file_id'] = $fileID;

        return $obj;
    }

    public function withStartPageNumber(int $startPageNumber): self
    {
        $obj = clone $this;
        $obj['start_page_number'] = $startPageNumber;

        return $obj;
    }
}
