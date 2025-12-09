<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaCitationSearchResultLocationShape = array{
 *   citedText: string,
 *   endBlockIndex: int,
 *   searchResultIndex: int,
 *   source: string,
 *   startBlockIndex: int,
 *   title: string|null,
 *   type?: 'search_result_location',
 * }
 */
final class BetaCitationSearchResultLocation implements BaseModel
{
    /** @use SdkModel<BetaCitationSearchResultLocationShape> */
    use SdkModel;

    /** @var 'search_result_location' $type */
    #[Required]
    public string $type = 'search_result_location';

    #[Required('cited_text')]
    public string $citedText;

    #[Required('end_block_index')]
    public int $endBlockIndex;

    #[Required('search_result_index')]
    public int $searchResultIndex;

    #[Required]
    public string $source;

    #[Required('start_block_index')]
    public int $startBlockIndex;

    #[Required]
    public ?string $title;

    /**
     * `new BetaCitationSearchResultLocation()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaCitationSearchResultLocation::with(
     *   citedText: ...,
     *   endBlockIndex: ...,
     *   searchResultIndex: ...,
     *   source: ...,
     *   startBlockIndex: ...,
     *   title: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaCitationSearchResultLocation)
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
        string $citedText,
        int $endBlockIndex,
        int $searchResultIndex,
        string $source,
        int $startBlockIndex,
        ?string $title,
    ): self {
        $obj = new self;

        $obj['citedText'] = $citedText;
        $obj['endBlockIndex'] = $endBlockIndex;
        $obj['searchResultIndex'] = $searchResultIndex;
        $obj['source'] = $source;
        $obj['startBlockIndex'] = $startBlockIndex;
        $obj['title'] = $title;

        return $obj;
    }

    public function withCitedText(string $citedText): self
    {
        $obj = clone $this;
        $obj['citedText'] = $citedText;

        return $obj;
    }

    public function withEndBlockIndex(int $endBlockIndex): self
    {
        $obj = clone $this;
        $obj['endBlockIndex'] = $endBlockIndex;

        return $obj;
    }

    public function withSearchResultIndex(int $searchResultIndex): self
    {
        $obj = clone $this;
        $obj['searchResultIndex'] = $searchResultIndex;

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
        $obj['startBlockIndex'] = $startBlockIndex;

        return $obj;
    }

    public function withTitle(?string $title): self
    {
        $obj = clone $this;
        $obj['title'] = $title;

        return $obj;
    }
}
