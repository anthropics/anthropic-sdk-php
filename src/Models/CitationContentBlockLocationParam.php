<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

class CitationContentBlockLocationParam implements BaseModel
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
     * @param string      $citedText
     * @param int         $documentIndex
     * @param null|string $documentTitle
     * @param int         $endBlockIndex
     * @param int         $startBlockIndex
     * @param string      $type
     */
    final public function __construct(
        $citedText,
        $documentIndex,
        $documentTitle,
        $endBlockIndex,
        $startBlockIndex,
        $type,
    ) {
        $this->constructFromArgs(func_get_args());
    }
}

CitationContentBlockLocationParam::_loadMetadata();
