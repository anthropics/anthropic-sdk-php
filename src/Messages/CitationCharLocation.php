<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type CitationCharLocationShape = array{
 *   citedText: string,
 *   documentIndex: int,
 *   documentTitle: string|null,
 *   endCharIndex: int,
 *   fileID: string|null,
 *   startCharIndex: int,
 *   type: 'char_location',
 * }
 */
final class CitationCharLocation implements BaseModel
{
    /** @use SdkModel<CitationCharLocationShape> */
    use SdkModel;

    /** @var 'char_location' $type */
    #[Required]
    public string $type = 'char_location';

    #[Required('cited_text')]
    public string $citedText;

    #[Required('document_index')]
    public int $documentIndex;

    #[Required('document_title')]
    public ?string $documentTitle;

    #[Required('end_char_index')]
    public int $endCharIndex;

    #[Required('file_id')]
    public ?string $fileID;

    #[Required('start_char_index')]
    public int $startCharIndex;

    /**
     * `new CitationCharLocation()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * CitationCharLocation::with(
     *   citedText: ...,
     *   documentIndex: ...,
     *   documentTitle: ...,
     *   endCharIndex: ...,
     *   fileID: ...,
     *   startCharIndex: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new CitationCharLocation)
     *   ->withCitedText(...)
     *   ->withDocumentIndex(...)
     *   ->withDocumentTitle(...)
     *   ->withEndCharIndex(...)
     *   ->withFileID(...)
     *   ->withStartCharIndex(...)
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
        int $endCharIndex,
        ?string $fileID,
        int $startCharIndex,
    ): self {
        $self = new self;

        $self['citedText'] = $citedText;
        $self['documentIndex'] = $documentIndex;
        $self['documentTitle'] = $documentTitle;
        $self['endCharIndex'] = $endCharIndex;
        $self['fileID'] = $fileID;
        $self['startCharIndex'] = $startCharIndex;

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

    public function withEndCharIndex(int $endCharIndex): self
    {
        $self = clone $this;
        $self['endCharIndex'] = $endCharIndex;

        return $self;
    }

    public function withFileID(?string $fileID): self
    {
        $self = clone $this;
        $self['fileID'] = $fileID;

        return $self;
    }

    public function withStartCharIndex(int $startCharIndex): self
    {
        $self = clone $this;
        $self['startCharIndex'] = $startCharIndex;

        return $self;
    }
}
