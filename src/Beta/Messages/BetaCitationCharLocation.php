<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaCitationCharLocationShape = array{
 *   cited_text: string,
 *   document_index: int,
 *   document_title: string|null,
 *   end_char_index: int,
 *   file_id: string|null,
 *   start_char_index: int,
 *   type: 'char_location',
 * }
 */
final class BetaCitationCharLocation implements BaseModel
{
    /** @use SdkModel<BetaCitationCharLocationShape> */
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
    public ?string $file_id;

    #[Required]
    public int $start_char_index;

    /**
     * `new BetaCitationCharLocation()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaCitationCharLocation::with(
     *   cited_text: ...,
     *   document_index: ...,
     *   document_title: ...,
     *   end_char_index: ...,
     *   file_id: ...,
     *   start_char_index: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaCitationCharLocation)
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
        string $cited_text,
        int $document_index,
        ?string $document_title,
        int $end_char_index,
        ?string $file_id,
        int $start_char_index,
    ): self {
        $obj = new self;

        $obj['cited_text'] = $cited_text;
        $obj['document_index'] = $document_index;
        $obj['document_title'] = $document_title;
        $obj['end_char_index'] = $end_char_index;
        $obj['file_id'] = $file_id;
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

    public function withFileID(?string $fileID): self
    {
        $obj = clone $this;
        $obj['file_id'] = $fileID;

        return $obj;
    }

    public function withStartCharIndex(int $startCharIndex): self
    {
        $obj = clone $this;
        $obj['start_char_index'] = $startCharIndex;

        return $obj;
    }
}
