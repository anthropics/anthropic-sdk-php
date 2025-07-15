<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

final class BetaCitationSearchResultLocation implements BaseModel
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
    public string $type = 'search_result_location';

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(
        string $citedText,
        int $endBlockIndex,
        int $searchResultIndex,
        string $source,
        int $startBlockIndex,
        ?string $title,
        string $type = 'search_result_location',
    ) {
        $this->citedText = $citedText;
        $this->endBlockIndex = $endBlockIndex;
        $this->searchResultIndex = $searchResultIndex;
        $this->source = $source;
        $this->startBlockIndex = $startBlockIndex;
        $this->title = $title;
        $this->type = $type;
    }
}

BetaCitationSearchResultLocation::_loadMetadata();
