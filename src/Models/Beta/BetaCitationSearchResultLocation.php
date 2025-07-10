<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

class BetaCitationSearchResultLocation implements BaseModel
{
    use Model;

    #[Api('cited_text')]
    public string $citedText;

    #[Api('end_block_index')]
    public int $endBlockIndex;

    #[Api('search_result_index')]
    public int $searchResultIndex;

    #[Api]
    public string $source;

    #[Api('start_block_index')]
    public int $startBlockIndex;

    #[Api]
    public ?string $title;

    #[Api]
    public string $type;

    /**
     * You must use named parameters to construct this object. If an named argument is not
     * given, it will not be included during JSON serialization. The arguments are untyped
     * so you can pass any JSON serializable value, but the API expects the types to match
     * the PHPDoc types.
     *
     * @param string      $citedText         `required`
     * @param int         $endBlockIndex     `required`
     * @param int         $searchResultIndex `required`
     * @param string      $source            `required`
     * @param int         $startBlockIndex   `required`
     * @param null|string $title             `required`
     * @param string      $type              `required`
     */
    final public function __construct(
        $citedText,
        $endBlockIndex,
        $searchResultIndex,
        $source,
        $startBlockIndex,
        $title,
        $type,
    ) {
        $this->constructFromArgs(func_get_args());
    }
}

BetaCitationSearchResultLocation::_loadMetadata();
