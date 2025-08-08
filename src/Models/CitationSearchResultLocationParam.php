<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model as ModelTrait;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type citation_search_result_location_param_alias = array{
 *   citedText: string,
 *   endBlockIndex: int,
 *   searchResultIndex: int,
 *   source: string,
 *   startBlockIndex: int,
 *   title: string|null,
 *   type: string,
 * }
 */
final class CitationSearchResultLocationParam implements BaseModel
{
    use ModelTrait;

    #[Api]
    public string $type = 'search_result_location';

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

    public function __construct()
    {
        self::introspect();
        $this->unsetOptionalProperties();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function new(
        string $citedText,
        int $endBlockIndex,
        int $searchResultIndex,
        string $source,
        int $startBlockIndex,
        ?string $title,
    ): self {
        $obj = new self;

        $obj->citedText = $citedText;
        $obj->endBlockIndex = $endBlockIndex;
        $obj->searchResultIndex = $searchResultIndex;
        $obj->source = $source;
        $obj->startBlockIndex = $startBlockIndex;
        $obj->title = $title;

        return $obj;
    }

    public function setCitedText(string $citedText): self
    {
        $this->citedText = $citedText;

        return $this;
    }

    public function setEndBlockIndex(int $endBlockIndex): self
    {
        $this->endBlockIndex = $endBlockIndex;

        return $this;
    }

    public function setSearchResultIndex(int $searchResultIndex): self
    {
        $this->searchResultIndex = $searchResultIndex;

        return $this;
    }

    public function setSource(string $source): self
    {
        $this->source = $source;

        return $this;
    }

    public function setStartBlockIndex(int $startBlockIndex): self
    {
        $this->startBlockIndex = $startBlockIndex;

        return $this;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }
}
