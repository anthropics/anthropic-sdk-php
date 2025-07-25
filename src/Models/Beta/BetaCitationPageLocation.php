<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type beta_citation_page_location_alias = array{
 *   citedText: string,
 *   documentIndex: int,
 *   documentTitle: string|null,
 *   endPageNumber: int,
 *   startPageNumber: int,
 *   type: string,
 * }
 */
final class BetaCitationPageLocation implements BaseModel
{
    use Model;

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
    public static function new(
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

    public function setCitedText(string $citedText): self
    {
        $this->citedText = $citedText;

        return $this;
    }

    public function setDocumentIndex(int $documentIndex): self
    {
        $this->documentIndex = $documentIndex;

        return $this;
    }

    public function setDocumentTitle(?string $documentTitle): self
    {
        $this->documentTitle = $documentTitle;

        return $this;
    }

    public function setEndPageNumber(int $endPageNumber): self
    {
        $this->endPageNumber = $endPageNumber;

        return $this;
    }

    public function setStartPageNumber(int $startPageNumber): self
    {
        $this->startPageNumber = $startPageNumber;

        return $this;
    }
}
