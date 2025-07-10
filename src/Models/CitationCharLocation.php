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
     * You must use named parameters to construct this object. If an named argument is not
     * given, it will not be included during JSON serialization. The arguments are untyped
     * so you can pass any JSON serializable value, but the API expects the types to match
     * the PHPDoc types.
     *
     * @param string      $citedText      `required`
     * @param int         $documentIndex  `required`
     * @param null|string $documentTitle  `required`
     * @param int         $endCharIndex   `required`
     * @param int         $startCharIndex `required`
     * @param string      $type           `required`
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
