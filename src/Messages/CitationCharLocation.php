<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model as ModelTrait;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type citation_char_location_alias = array{
 *   citedText: string,
 *   documentIndex: int,
 *   documentTitle: string|null,
 *   endCharIndex: int,
 *   fileID: string|null,
 *   startCharIndex: int,
 *   type: string,
 * }
 */
final class CitationCharLocation implements BaseModel
{
    use ModelTrait;

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

    #[Api('file_id')]
    public ?string $fileID;

    #[Api('start_char_index')]
    public int $startCharIndex;

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
    public static function from(
        string $citedText,
        int $documentIndex,
        ?string $documentTitle,
        int $endCharIndex,
        ?string $fileID,
        int $startCharIndex,
    ): self {
        $obj = new self;

        $obj->citedText = $citedText;
        $obj->documentIndex = $documentIndex;
        $obj->documentTitle = $documentTitle;
        $obj->endCharIndex = $endCharIndex;
        $obj->fileID = $fileID;
        $obj->startCharIndex = $startCharIndex;

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

    public function setEndCharIndex(int $endCharIndex): self
    {
        $this->endCharIndex = $endCharIndex;

        return $this;
    }

    public function setFileID(?string $fileID): self
    {
        $this->fileID = $fileID;

        return $this;
    }

    public function setStartCharIndex(int $startCharIndex): self
    {
        $this->startCharIndex = $startCharIndex;

        return $this;
    }
}
