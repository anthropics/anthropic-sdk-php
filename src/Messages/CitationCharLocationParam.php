<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type CitationCharLocationParamShape = array{
 *   cited_text: string,
 *   document_index: int,
 *   document_title: string|null,
 *   end_char_index: int,
 *   start_char_index: int,
 *   type: 'char_location',
 * }
 */
final class CitationCharLocationParam implements BaseModel
{
    /** @use SdkModel<CitationCharLocationParamShape> */
    use SdkModel;

    /** @var 'char_location' $type */
    #[Required]
    public string $type = 'char_location';

    #[Required]
    public string $cited_text;

    #[Required]
    public int $document_index;

    #[Required]
    public ?string $document_title;

    #[Required]
    public int $end_char_index;

    #[Required]
    public int $start_char_index;

    /**
     * `new CitationCharLocationParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * CitationCharLocationParam::with(
     *   cited_text: ...,
     *   document_index: ...,
     *   document_title: ...,
     *   end_char_index: ...,
     *   start_char_index: ...,
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
        string $cited_text,
        int $document_index,
        ?string $document_title,
        int $end_char_index,
        int $start_char_index,
    ): self {
        $obj = new self;

        $obj['cited_text'] = $cited_text;
        $obj['document_index'] = $document_index;
        $obj['document_title'] = $document_title;
        $obj['end_char_index'] = $end_char_index;
        $obj['start_char_index'] = $start_char_index;

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

    public function withEndCharIndex(int $endCharIndex): self
    {
        $obj = clone $this;
        $obj['end_char_index'] = $endCharIndex;

        return $obj;
    }

    public function withStartCharIndex(int $startCharIndex): self
    {
        $obj = clone $this;
        $obj['start_char_index'] = $startCharIndex;

        return $obj;
    }
}
