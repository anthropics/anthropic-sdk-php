<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

final class CitationContentBlockLocationParam implements BaseModel
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
     * You must use named parameters to construct this object. If an named argument is not
     * given, it will not be included during JSON serialization. The arguments are untyped
     * so you can pass any JSON serializable value, but the API expects the types to match
     * the PHPDoc types.
     *
     * @param string      $citedText       `required`
     * @param int         $documentIndex   `required`
     * @param null|string $documentTitle   `required`
     * @param int         $endBlockIndex   `required`
     * @param int         $startBlockIndex `required`
     * @param string      $type            `required`
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
