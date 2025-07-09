<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

class CitationCharLocation implements BaseModel
{
    use Model;

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

    #[Api]
    public string $type;

    /**
     * @param string      $citedText
     * @param int         $documentIndex
     * @param null|string $documentTitle
     * @param int         $endCharIndex
     * @param int         $startCharIndex
     * @param string      $type
     */
    final public function __construct(
        $citedText,
        $documentIndex,
        $documentTitle,
        $endCharIndex,
        $startCharIndex,
        $type,
    ) {
        $this->constructFromArgs(func_get_args());
    }
}

CitationCharLocation::_loadMetadata();
