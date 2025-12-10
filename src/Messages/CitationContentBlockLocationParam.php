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
 *   type?: 'content_block_location',
 * }
 */
final class CitationContentBlockLocationParam implements BaseModel
{
    /** @use SdkModel<CitationContentBlockLocationParamShape> */
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
        $obj = new self;

        $obj['citedText'] = $citedText;
        $obj['documentIndex'] = $documentIndex;
        $obj['documentTitle'] = $documentTitle;
        $obj['endBlockIndex'] = $endBlockIndex;
        $obj['startBlockIndex'] = $startBlockIndex;

        return $obj;
    }

    public function withCitedText(string $citedText): self
    {
        $obj = clone $this;
        $obj['citedText'] = $citedText;

        return $obj;
    }

    public function withDocumentIndex(int $documentIndex): self
    {
        $obj = clone $this;
        $obj['documentIndex'] = $documentIndex;

        return $obj;
    }

    public function withDocumentTitle(?string $documentTitle): self
    {
        $obj = clone $this;
        $obj['documentTitle'] = $documentTitle;

        return $obj;
    }

    public function withEndBlockIndex(int $endBlockIndex): self
    {
        $obj = clone $this;
        $obj['endBlockIndex'] = $endBlockIndex;

        return $obj;
    }

    public function withStartBlockIndex(int $startBlockIndex): self
    {
        $obj = clone $this;
        $obj['startBlockIndex'] = $startBlockIndex;

        return $obj;
    }
}
