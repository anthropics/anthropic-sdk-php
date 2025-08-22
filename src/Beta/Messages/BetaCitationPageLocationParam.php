<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

final class BetaCitationPageLocationParam implements BaseModel
{
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

    #[Api('start_page_number')]
    public int $startPageNumber;

    /**
     * `new BetaCitationPageLocationParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaCitationPageLocationParam::with(
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
     * (new BetaCitationPageLocationParam)
     *   ->withCitedText(...)
     *   ->withDocumentIndex(...)
     *   ->withDocumentTitle(...)
     *   ->withEndPageNumber(...)
     *   ->withStartPageNumber(...)
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
        int $endPageNumber,
        int $startPageNumber,
    ): self {
        $obj = new self;

        $obj->citedText = $citedText;
        $obj->documentIndex = $documentIndex;
        $obj->documentTitle = $documentTitle;
        $obj->endPageNumber = $endPageNumber;
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

    public function withStartPageNumber(int $startPageNumber): self
    {
        $obj = clone $this;
        $obj->startPageNumber = $startPageNumber;

        return $obj;
    }
}
