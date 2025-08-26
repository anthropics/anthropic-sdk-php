<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type citation_content_block_location_param = array{
 *   citedText: string,
 *   documentIndex: int,
 *   documentTitle: string|null,
 *   endBlockIndex: int,
 *   startBlockIndex: int,
 *   type: string,
 * }
 */
final class CitationContentBlockLocationParam implements BaseModel
{
    /** @use SdkModel<citation_content_block_location_param> */
    use SdkModel;

    #[Api]
    public string $type = 'content_block_location';

    #[Api('cited_text')]
    public string $citedText;

    #[Api('document_index')]
    public int $documentIndex;

    #[Api('document_title')]
    public ?string $documentTitle;

    #[Api('end_block_index')]
    public int $endBlockIndex;

    #[Api('start_block_index')]
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
        self::introspect();
        $this->unsetOptionalProperties();
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

        $obj->citedText = $citedText;
        $obj->documentIndex = $documentIndex;
        $obj->documentTitle = $documentTitle;
        $obj->endBlockIndex = $endBlockIndex;
        $obj->startBlockIndex = $startBlockIndex;

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

    public function withEndBlockIndex(int $endBlockIndex): self
    {
        $obj = clone $this;
        $obj->endBlockIndex = $endBlockIndex;

        return $obj;
    }

    public function withStartBlockIndex(int $startBlockIndex): self
    {
        $obj = clone $this;
        $obj->startBlockIndex = $startBlockIndex;

        return $obj;
    }
}
