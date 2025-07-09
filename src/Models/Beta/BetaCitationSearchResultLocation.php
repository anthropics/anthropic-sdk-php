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
     * @param string      $citedText
     * @param int         $endBlockIndex
     * @param int         $searchResultIndex
     * @param string      $source
     * @param int         $startBlockIndex
     * @param null|string $title
     * @param string      $type
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
