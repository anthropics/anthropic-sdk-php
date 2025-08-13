<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type beta_citation_char_location_param_alias = array{
 *   citedText: string,
 *   documentIndex: int,
 *   documentTitle: string|null,
 *   endCharIndex: int,
 *   startCharIndex: int,
 *   type: string,
 * }
 */
final class BetaCitationCharLocationParam implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'char_location';

    #[Api('cited_text')]
    public string $citedText;

    #[Api('document_index')]
    public int $documentIndex;

    #[Api('document_title')]
    public ?string $documentTitle;

    #[Api('end_char_index')]
    public int $endCharIndex;

    #[Api('start_char_index')]
    public int $startCharIndex;

    /**
     * `new BetaCitationCharLocationParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaCitationCharLocationParam::with(
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
     * (new BetaCitationCharLocationParam)
     *   ->withCitedText(...)
     *   ->withDocumentIndex(...)
     *   ->withDocumentTitle(...)
     *   ->withEndCharIndex(...)
     *   ->withStartCharIndex(...)
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
        int $endCharIndex,
        int $startCharIndex,
    ): self {
        $obj = new self;

        $obj->citedText = $citedText;
        $obj->documentIndex = $documentIndex;
        $obj->documentTitle = $documentTitle;
        $obj->endCharIndex = $endCharIndex;
        $obj->startCharIndex = $startCharIndex;

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

    public function withEndCharIndex(int $endCharIndex): self
    {
        $obj = clone $this;
        $obj->endCharIndex = $endCharIndex;

        return $obj;
    }

    public function withStartCharIndex(int $startCharIndex): self
    {
        $obj = clone $this;
        $obj->startCharIndex = $startCharIndex;

        return $obj;
    }
}
