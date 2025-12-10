<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type CitationCharLocationParamShape = array{
 *   citedText: string,
 *   documentIndex: int,
 *   documentTitle: string|null,
 *   endCharIndex: int,
 *   startCharIndex: int,
 *   type?: 'char_location',
 * }
 */
final class CitationCharLocationParam implements BaseModel
{
    /** @use SdkModel<CitationCharLocationParamShape> */
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

    #[Required('start_char_index')]
    public int $startCharIndex;

    /**
     * `new CitationCharLocationParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * CitationCharLocationParam::with(
     *   citedText: ...,
     *   documentIndex: ...,
     *   documentTitle: ...,
     *   endCharIndex: ...,
     *   startCharIndex: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new CitationCharLocationParam)
     *   ->withCitedText(...)
     *   ->withDocumentIndex(...)
     *   ->withDocumentTitle(...)
     *   ->withEndCharIndex(...)
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
        int $startCharIndex,
    ): self {
        $obj = new self;

        $obj['citedText'] = $citedText;
        $obj['documentIndex'] = $documentIndex;
        $obj['documentTitle'] = $documentTitle;
        $obj['endCharIndex'] = $endCharIndex;
        $obj['startCharIndex'] = $startCharIndex;

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

    public function withEndCharIndex(int $endCharIndex): self
    {
        $obj = clone $this;
        $obj['endCharIndex'] = $endCharIndex;

        return $obj;
    }

    public function withStartCharIndex(int $startCharIndex): self
    {
        $obj = clone $this;
        $obj['startCharIndex'] = $startCharIndex;

        return $obj;
    }
}
