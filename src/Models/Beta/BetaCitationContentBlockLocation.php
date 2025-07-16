<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Models\Beta\BetaCitationContentBlockLocation\Type;

final class BetaCitationContentBlockLocation implements BaseModel
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

    /** @var Type::* $type */
    #[Api]
    public string $type = 'content_block_location';

    /**
     * You must use named parameters to construct this object.
     *
     * @param Type::* $type
     */
    final public function __construct(
        string $citedText,
        int $documentIndex,
        ?string $documentTitle,
        int $endBlockIndex,
        int $startBlockIndex,
        string $type = 'content_block_location',
    ) {
        $this->citedText = $citedText;
        $this->documentIndex = $documentIndex;
        $this->documentTitle = $documentTitle;
        $this->endBlockIndex = $endBlockIndex;
        $this->startBlockIndex = $startBlockIndex;
        $this->type = $type;
    }
}

BetaCitationContentBlockLocation::_loadMetadata();
