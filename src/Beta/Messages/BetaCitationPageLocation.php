<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type beta_citation_page_location = array{
 *   citedText: string,
 *   documentIndex: int,
 *   documentTitle: string|null,
 *   endPageNumber: int,
 *   fileID: string|null,
 *   startPageNumber: int,
 *   type: string,
 * }
 */
final class BetaCitationPageLocation implements BaseModel
{
    /** @use SdkModel<beta_citation_page_location> */
    use SdkModel;

    #[Api]
    public string $type = 'page_location';

    #[Api('cited_text')]
    public string $citedText;

    #[Api('document_index')]
    public int $documentIndex;

    #[Api('document_title')]
    public ?string $documentTitle;

    #[Api('end_page_number')]
    public int $endPageNumber;

    #[Api('file_id')]
    public ?string $fileID;

    #[Api('start_page_number')]
    public int $startPageNumber;

    /**
     * `new BetaCitationPageLocation()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaCitationPageLocation::with(
     *   citedText: ...,
     *   documentIndex: ...,
     *   documentTitle: ...,
     *   endPageNumber: ...,
     *   fileID: ...,
     *   startPageNumber: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaCitationPageLocation)
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
        string $citedText,
        int $documentIndex,
        ?string $documentTitle,
        int $endPageNumber,
        ?string $fileID,
        int $startPageNumber,
    ): self {
        $obj = new self;

        $obj->citedText = $citedText;
        $obj->documentIndex = $documentIndex;
        $obj->documentTitle = $documentTitle;
        $obj->endPageNumber = $endPageNumber;
        $obj->fileID = $fileID;
        $obj->startPageNumber = $startPageNumber;

        return $obj;
    }

    public function withCitedText(string $citedText): self
    {
        $obj = clone $this;
        $obj->citedText = $citedText;

        return $obj;
    }

    public function withDocumentIndex(int $documentIndex): self
    {
        $obj = clone $this;
        $obj->documentIndex = $documentIndex;

        return $obj;
    }

    public function withDocumentTitle(?string $documentTitle): self
    {
        $obj = clone $this;
        $obj->documentTitle = $documentTitle;

        return $obj;
    }

    public function withEndPageNumber(int $endPageNumber): self
    {
        $obj = clone $this;
        $obj->endPageNumber = $endPageNumber;

        return $obj;
    }

    public function withFileID(?string $fileID): self
    {
        $obj = clone $this;
        $obj->fileID = $fileID;

        return $obj;
    }

    public function withStartPageNumber(int $startPageNumber): self
    {
        $obj = clone $this;
        $obj->startPageNumber = $startPageNumber;

        return $obj;
    }
}
