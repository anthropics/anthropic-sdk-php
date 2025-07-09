<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

class BetaCitationPageLocationParam implements BaseModel
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
    public string $type;

    /**
     * @param string      $citedText
     * @param int         $documentIndex
     * @param null|string $documentTitle
     * @param int         $endPageNumber
     * @param int         $startPageNumber
     * @param string      $type
     */
    final public function __construct(
        $citedText,
        $documentIndex,
        $documentTitle,
        $endPageNumber,
        $startPageNumber,
        $type,
    ) {
        $this->constructFromArgs(func_get_args());
    }
}

BetaCitationPageLocationParam::_loadMetadata();
