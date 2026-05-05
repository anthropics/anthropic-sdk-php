<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type CitationContentBlockLocationParamShape = array{
 *   citedText: string,
 *   documentIndex: int,
 *   documentTitle: string|null,
 *   endBlockIndex: int,
 *   startBlockIndex: int,
 *   type: 'content_block_location',
 * }
 */
final class CitationContentBlockLocationParam implements BaseModel
{
    /** @use SdkModel<CitationContentBlockLocationParamShape> */
    use SdkModel;

    /** @var 'content_block_location' $type */
    #[Required]
    public string $type = 'content_block_location';

    /**
     * The full text of the cited block range, concatenated.
     *
     * Always equals the contents of `content[start_block_index:end_block_index]` joined together. The text block is the minimal citable unit; this field is never a substring of a single block. Not counted toward output tokens, and not counted toward input tokens when sent back in subsequent turns.
     */
    #[Required('cited_text')]
    public string $citedText;

    #[Required('document_index')]
    public int $documentIndex;

    #[Required('document_title')]
    public ?string $documentTitle;

    /**
     * Exclusive 0-based end index of the cited block range in the source's `content` array.
     *
     * Always greater than `start_block_index`; a single-block citation has `end_block_index = start_block_index + 1`.
     */
    #[Required('end_block_index')]
    public int $endBlockIndex;

    /**
     * 0-based index of the first cited block in the source's `content` array.
     */
    #[Required('start_block_index')]
    public int $startBlockIndex;

    /**
     * `new CitationContentBlockLocationParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * CitationContentBlockLocationParam::with(
     *   citedText: ...,
     *   documentIndex: ...,
     *   documentTitle: ...,
     *   endBlockIndex: ...,
     *   startBlockIndex: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new CitationContentBlockLocationParam)
     *   ->withCitedText(...)
     *   ->withDocumentIndex(...)
     *   ->withDocumentTitle(...)
     *   ->withEndBlockIndex(...)
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
        int $startBlockIndex,
    ): self {
        $self = new self;

        $self['citedText'] = $citedText;
        $self['documentIndex'] = $documentIndex;
        $self['documentTitle'] = $documentTitle;
        $self['endBlockIndex'] = $endBlockIndex;
        $self['startBlockIndex'] = $startBlockIndex;

        return $self;
    }

    /**
     * The full text of the cited block range, concatenated.
     *
     * Always equals the contents of `content[start_block_index:end_block_index]` joined together. The text block is the minimal citable unit; this field is never a substring of a single block. Not counted toward output tokens, and not counted toward input tokens when sent back in subsequent turns.
     */
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

    /**
     * Exclusive 0-based end index of the cited block range in the source's `content` array.
     *
     * Always greater than `start_block_index`; a single-block citation has `end_block_index = start_block_index + 1`.
     */
    public function withEndBlockIndex(int $endBlockIndex): self
    {
        $self = clone $this;
        $self['endBlockIndex'] = $endBlockIndex;

        return $self;
    }

    /**
     * 0-based index of the first cited block in the source's `content` array.
     */
    public function withStartBlockIndex(int $startBlockIndex): self
    {
        $self = clone $this;
        $self['startBlockIndex'] = $startBlockIndex;

        return $self;
    }

    /**
     * @param 'content_block_location' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
