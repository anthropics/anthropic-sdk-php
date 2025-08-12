<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type beta_citation_content_block_location_alias = array{
 *   citedText: string,
 *   documentIndex: int,
 *   documentTitle: string|null,
 *   endBlockIndex: int,
 *   fileID: string|null,
 *   startBlockIndex: int,
 *   type: string,
 * }
 */
final class BetaCitationContentBlockLocation implements BaseModel
{
    use Model;

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

    #[Api('file_id')]
    public ?string $fileID;

    #[Api('start_block_index')]
    public int $startBlockIndex;

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
        int $endBlockIndex,
        ?string $fileID,
        int $startBlockIndex,
    ): self {
        $obj = new self;

        $obj->citedText = $citedText;
        $obj->documentIndex = $documentIndex;
        $obj->documentTitle = $documentTitle;
        $obj->endBlockIndex = $endBlockIndex;
        $obj->fileID = $fileID;
        $obj->startBlockIndex = $startBlockIndex;

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

    public function setEndBlockIndex(int $endBlockIndex): self
    {
        $this->endBlockIndex = $endBlockIndex;

        return $this;
    }

    public function setFileID(?string $fileID): self
    {
        $this->fileID = $fileID;

        return $this;
    }

    public function setStartBlockIndex(int $startBlockIndex): self
    {
        $this->startBlockIndex = $startBlockIndex;

        return $this;
    }
}
