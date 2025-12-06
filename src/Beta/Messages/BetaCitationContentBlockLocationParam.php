<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaCitationContentBlockLocationParamShape = array{
 *   cited_text: string,
 *   document_index: int,
 *   document_title: string|null,
 *   end_block_index: int,
 *   start_block_index: int,
 *   type: 'content_block_location',
 * }
 */
final class BetaCitationContentBlockLocationParam implements BaseModel
{
    /** @use SdkModel<BetaCitationContentBlockLocationParamShape> */
    use SdkModel;

    /** @var 'content_block_location' $type */
    #[Api]
    public string $type = 'content_block_location';

    #[Api]
    public string $cited_text;

    #[Api]
    public int $document_index;

    #[Api]
    public ?string $document_title;

    #[Api]
    public int $end_block_index;

    #[Api]
    public int $start_block_index;

    /**
     * `new BetaCitationContentBlockLocationParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaCitationContentBlockLocationParam::with(
     *   cited_text: ...,
     *   document_index: ...,
     *   document_title: ...,
     *   end_block_index: ...,
     *   start_block_index: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaCitationContentBlockLocationParam)
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
        string $cited_text,
        int $document_index,
        ?string $document_title,
        int $end_block_index,
        int $start_block_index,
    ): self {
        $obj = new self;

        $obj['cited_text'] = $cited_text;
        $obj['document_index'] = $document_index;
        $obj['document_title'] = $document_title;
        $obj['end_block_index'] = $end_block_index;
        $obj['start_block_index'] = $start_block_index;

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

    public function withEndBlockIndex(int $endBlockIndex): self
    {
        $obj = clone $this;
        $obj['end_block_index'] = $endBlockIndex;

        return $obj;
    }

    public function withStartBlockIndex(int $startBlockIndex): self
    {
        $obj = clone $this;
        $obj['start_block_index'] = $startBlockIndex;

        return $obj;
    }
}
