<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type CitationsSearchResultLocationShape = array{
 *   cited_text: string,
 *   end_block_index: int,
 *   search_result_index: int,
 *   source: string,
 *   start_block_index: int,
 *   title: string|null,
 *   type: 'search_result_location',
 * }
 */
final class CitationsSearchResultLocation implements BaseModel
{
    /** @use SdkModel<CitationsSearchResultLocationShape> */
    use SdkModel;

    /** @var 'search_result_location' $type */
    #[Api]
    public string $type = 'search_result_location';

    #[Api]
    public string $cited_text;

    #[Api]
    public int $end_block_index;

    #[Api]
    public int $search_result_index;

    #[Api]
    public string $source;

    #[Api]
    public int $start_block_index;

    #[Api]
    public ?string $title;

    /**
     * `new CitationsSearchResultLocation()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * CitationsSearchResultLocation::with(
     *   cited_text: ...,
     *   end_block_index: ...,
     *   search_result_index: ...,
     *   source: ...,
     *   start_block_index: ...,
     *   title: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new CitationsSearchResultLocation)
     *   ->withCitedText(...)
     *   ->withEndBlockIndex(...)
     *   ->withSearchResultIndex(...)
     *   ->withSource(...)
     *   ->withStartBlockIndex(...)
     *   ->withTitle(...)
     * ```
     */
    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(
        string $cited_text,
        int $end_block_index,
        int $search_result_index,
        string $source,
        int $start_block_index,
        ?string $title,
    ): self {
        $obj = new self;

        $obj['cited_text'] = $cited_text;
        $obj['end_block_index'] = $end_block_index;
        $obj['search_result_index'] = $search_result_index;
        $obj['source'] = $source;
        $obj['start_block_index'] = $start_block_index;
        $obj['title'] = $title;

        return $obj;
    }

    public function withCitedText(string $citedText): self
    {
        $obj = clone $this;
        $obj['cited_text'] = $citedText;

        return $obj;
    }

    public function withEndBlockIndex(int $endBlockIndex): self
    {
        $obj = clone $this;
        $obj['end_block_index'] = $endBlockIndex;

        return $obj;
    }

    public function withSearchResultIndex(int $searchResultIndex): self
    {
        $obj = clone $this;
        $obj['search_result_index'] = $searchResultIndex;

        return $obj;
    }

    public function withSource(string $source): self
    {
        $obj = clone $this;
        $obj['source'] = $source;

        return $obj;
    }

    public function withStartBlockIndex(int $startBlockIndex): self
    {
        $obj = clone $this;
        $obj['start_block_index'] = $startBlockIndex;

        return $obj;
    }

    public function withTitle(?string $title): self
    {
        $obj = clone $this;
        $obj['title'] = $title;

        return $obj;
    }
}
