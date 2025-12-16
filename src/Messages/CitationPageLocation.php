<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type CitationPageLocationShape = array{
 *   citedText: string,
 *   documentIndex: int,
 *   documentTitle: string|null,
 *   endPageNumber: int,
 *   fileID: string|null,
 *   startPageNumber: int,
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

    #[Required('cited_text')]
    public string $citedText;

    #[Required('document_index')]
    public int $documentIndex;

    #[Required('document_title')]
    public ?string $documentTitle;

    #[Required('end_page_number')]
    public int $endPageNumber;

    #[Required('file_id')]
    public ?string $fileID;

    #[Required('start_page_number')]
    public int $startPageNumber;

    /**
     * `new CitationPageLocation()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * CitationPageLocation::with(
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
        string $citedText,
        int $documentIndex,
        ?string $documentTitle,
        int $endPageNumber,
        ?string $fileID,
        int $startPageNumber,
    ): self {
        $self = new self;

        $self['citedText'] = $citedText;
        $self['documentIndex'] = $documentIndex;
        $self['documentTitle'] = $documentTitle;
        $self['endPageNumber'] = $endPageNumber;
        $self['fileID'] = $fileID;
        $self['startPageNumber'] = $startPageNumber;

        return $self;
    }

    public function withCitedText(string $citedText): self
    {
        $self = clone $this;
        $self['citedText'] = $citedText;

        return $self;
    }

    public function withDocumentIndex(int $documentIndex): self
    {
        $self = clone $this;
        $self['documentIndex'] = $documentIndex;

        return $self;
    }

    public function withDocumentTitle(?string $documentTitle): self
    {
        $self = clone $this;
        $self['documentTitle'] = $documentTitle;

        return $self;
    }

    public function withEndPageNumber(int $endPageNumber): self
    {
        $self = clone $this;
        $self['endPageNumber'] = $endPageNumber;

        return $self;
    }

    public function withFileID(?string $fileID): self
    {
        $self = clone $this;
        $self['fileID'] = $fileID;

        return $self;
    }

    public function withStartPageNumber(int $startPageNumber): self
    {
        $self = clone $this;
        $self['startPageNumber'] = $startPageNumber;

        return $self;
    }
}
