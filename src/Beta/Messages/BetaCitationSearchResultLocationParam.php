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

    public function withCitedText(string $citedText): self
    {
        $self = clone $this;
        $self['citedText'] = $citedText;

        return $self;
    }

    public function withEndBlockIndex(int $endBlockIndex): self
    {
        $self = clone $this;
        $self['endBlockIndex'] = $endBlockIndex;

        return $self;
    }

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
}
