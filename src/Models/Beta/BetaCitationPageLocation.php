<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

final class BetaCitationPageLocation implements BaseModel
{
    use Model;

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

    #[Api]
    public string $type = 'page_location';

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(
        string $citedText,
        int $documentIndex,
        ?string $documentTitle,
        int $endPageNumber,
        int $startPageNumber,
        string $type = 'page_location',
    ) {
        $this->citedText = $citedText;
        $this->documentIndex = $documentIndex;
        $this->documentTitle = $documentTitle;
        $this->endPageNumber = $endPageNumber;
        $this->startPageNumber = $startPageNumber;
        $this->type = $type;
    }
}

BetaCitationPageLocation::_loadMetadata();
