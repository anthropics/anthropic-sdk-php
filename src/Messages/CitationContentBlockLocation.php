<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type CitationContentBlockLocationShape = array{
 *   citedText: string,
 *   documentIndex: int,
 *   documentTitle: string|null,
 *   endBlockIndex: int,
 *   fileID: string|null,
 *   startBlockIndex: int,
 *   type?: 'content_block_location',
 * }
 */
final class CitationContentBlockLocation implements BaseModel
{
    /** @use SdkModel<CitationContentBlockLocationShape> */
    use SdkModel;

    /** @var 'content_block_location' $type */
    #[Required]
    public string $type = 'content_block_location';

    #[Required('cited_text')]
    public string $citedText;

    #[Required('document_index')]
    public int $documentIndex;

    #[Required('document_title')]
    public ?string $documentTitle;

    #[Required('end_block_index')]
    public int $endBlockIndex;

    #[Required('file_id')]
    public ?string $fileID;

    #[Required('start_block_index')]
    public int $startBlockIndex;

    /**
     * `new CitationContentBlockLocation()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * CitationContentBlockLocation::with(
     *   citedText: ...,
     *   documentIndex: ...,
     *   documentTitle: ...,
     *   endBlockIndex: ...,
     *   fileID: ...,
     *   startBlockIndex: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new CitationContentBlockLocation)
     *   ->withCitedText(...)
     *   ->withDocumentIndex(...)
     *   ->withDocumentTitle(...)
     *   ->withEndBlockIndex(...)
     *   ->withFileID(...)
     *   ->withStartBlockIndex(...)
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
        int $endBlockIndex,
        ?string $fileID,
        int $startBlockIndex,
    ): self {
        $self = new self;

        $self['citedText'] = $citedText;
        $self['documentIndex'] = $documentIndex;
        $self['documentTitle'] = $documentTitle;
        $self['endBlockIndex'] = $endBlockIndex;
        $self['fileID'] = $fileID;
        $self['startBlockIndex'] = $startBlockIndex;

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

    public function withEndBlockIndex(int $endBlockIndex): self
    {
        $self = clone $this;
        $self['endBlockIndex'] = $endBlockIndex;

        return $self;
    }

    public function withFileID(?string $fileID): self
    {
        $self = clone $this;
        $self['fileID'] = $fileID;

        return $self;
    }

    public function withStartBlockIndex(int $startBlockIndex): self
    {
        $self = clone $this;
        $self['startBlockIndex'] = $startBlockIndex;

        return $self;
    }
}
