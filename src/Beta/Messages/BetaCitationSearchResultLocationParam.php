<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaCitationSearchResultLocationParamShape = array{
 *   citedText: string,
 *   endBlockIndex: int,
 *   searchResultIndex: int,
 *   source: string,
 *   startBlockIndex: int,
 *   title: string|null,
 *   type: 'search_result_location',
 * }
 */
final class BetaCitationSearchResultLocationParam implements BaseModel
{
    /** @use SdkModel<BetaCitationSearchResultLocationParamShape> */
    use SdkModel;

    /** @var 'search_result_location' $type */
    #[Required]
    public string $type = 'search_result_location';

    /**
     * The full text of the cited block range, concatenated.
     *
     * Always equals the contents of `content[start_block_index:end_block_index]` joined together. The text block is the minimal citable unit; this field is never a substring of a single block. Not counted toward output tokens, and not counted toward input tokens when sent back in subsequent turns.
     */
    #[Required('cited_text')]
    public string $citedText;

    /**
     * Exclusive 0-based end index of the cited block range in the source's `content` array.
     *
     * Always greater than `start_block_index`; a single-block citation has `end_block_index = start_block_index + 1`.
     */
    #[Required('end_block_index')]
    public int $endBlockIndex;

    /**
     * 0-based index of the cited search result among all `search_result` content blocks in the request, in the order they appear across messages and tool results.
     *
     * Counted separately from `document_index`; server-side web search results are not included in this count.
     */
    #[Required('search_result_index')]
    public int $searchResultIndex;

    #[Required]
    public string $source;

    /**
     * 0-based index of the first cited block in the source's `content` array.
     */
    #[Required('start_block_index')]
    public int $startBlockIndex;

    #[Required]
    public ?string $title;

    /**
     * `new BetaCitationSearchResultLocationParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaCitationSearchResultLocationParam::with(
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
     * (new BetaCitationSearchResultLocationParam)
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
        $self = new self;

        $self['citedText'] = $citedText;
        $self['endBlockIndex'] = $endBlockIndex;
        $self['searchResultIndex'] = $searchResultIndex;
        $self['source'] = $source;
        $self['startBlockIndex'] = $startBlockIndex;
        $self['title'] = $title;

        return $self;
    }

    /**
     * The full text of the cited block range, concatenated.
     *
     * Always equals the contents of `content[start_block_index:end_block_index]` joined together. The text block is the minimal citable unit; this field is never a substring of a single block. Not counted toward output tokens, and not counted toward input tokens when sent back in subsequent turns.
     */
    public function withCitedText(string $citedText): self
    {
        $self = clone $this;
        $self['citedText'] = $citedText;

        return $self;
    }

    /**
     * Exclusive 0-based end index of the cited block range in the source's `content` array.
     *
     * Always greater than `start_block_index`; a single-block citation has `end_block_index = start_block_index + 1`.
     */
    public function withEndBlockIndex(int $endBlockIndex): self
    {
        $self = clone $this;
        $self['endBlockIndex'] = $endBlockIndex;

        return $self;
    }

    /**
     * 0-based index of the cited search result among all `search_result` content blocks in the request, in the order they appear across messages and tool results.
     *
     * Counted separately from `document_index`; server-side web search results are not included in this count.
     */
    public function withSearchResultIndex(int $searchResultIndex): self
    {
        $self = clone $this;
        $self['searchResultIndex'] = $searchResultIndex;

        return $self;
    }

    public function withSource(string $source): self
    {
        $self = clone $this;
        $self['source'] = $source;

        return $self;
    }

    /**
     * 0-based index of the first cited block in the source's `content` array.
     */
    public function withStartBlockIndex(int $startBlockIndex): self
    {
        $self = clone $this;
        $self['startBlockIndex'] = $startBlockIndex;

        return $self;
    }

    public function withTitle(?string $title): self
    {
        $self = clone $this;
        $self['title'] = $title;

        return $self;
    }

    /**
     * @param 'search_result_location' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
