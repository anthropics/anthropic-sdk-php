<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type CitationPageLocationParamShape = array{
 *   citedText: string,
 *   documentIndex: int,
 *   documentTitle: string|null,
 *   endPageNumber: int,
 *   startPageNumber: int,
 *   type?: 'page_location',
 * }
 */
final class CitationPageLocationParam implements BaseModel
{
    /** @use SdkModel<CitationPageLocationParamShape> */
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

    #[Required('start_page_number')]
    public int $startPageNumber;

    /**
     * `new CitationPageLocationParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * CitationPageLocationParam::with(
     *   citedText: ...,
     *   documentIndex: ...,
     *   documentTitle: ...,
     *   endPageNumber: ...,
     *   startPageNumber: ...,
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
        string $citedText,
        int $documentIndex,
        ?string $documentTitle,
        int $endPageNumber,
        int $startPageNumber,
    ): self {
        $self = new self;

        $self['citedText'] = $citedText;
        $self['documentIndex'] = $documentIndex;
        $self['documentTitle'] = $documentTitle;
        $self['endPageNumber'] = $endPageNumber;
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

    public function withStartPageNumber(int $startPageNumber): self
    {
        $self = clone $this;
        $self['startPageNumber'] = $startPageNumber;

        return $self;
    }
}
