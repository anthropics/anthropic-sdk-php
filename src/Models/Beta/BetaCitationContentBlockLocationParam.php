<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

final class BetaCitationContentBlockLocationParam implements BaseModel
{
    use Model;

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

    #[Api]
    public string $type;

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(
        string $citedText,
        int $documentIndex,
        ?string $documentTitle,
        int $endBlockIndex,
        int $startBlockIndex,
        string $type,
    ) {
        $this->citedText = $citedText;
        $this->documentIndex = $documentIndex;
        $this->documentTitle = $documentTitle;
        $this->endBlockIndex = $endBlockIndex;
        $this->startBlockIndex = $startBlockIndex;
        $this->type = $type;
    }
}

BetaCitationContentBlockLocationParam::_loadMetadata();
