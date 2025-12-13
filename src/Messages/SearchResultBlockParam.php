<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Messages\CacheControlEphemeral\TTL;

/**
 * @phpstan-type SearchResultBlockParamShape = array{
 *   content: list<TextBlockParam>,
 *   source: string,
 *   title: string,
 *   type?: 'search_result',
 *   cacheControl?: CacheControlEphemeral|null,
 *   citations?: CitationsConfigParam|null,
 * }
 */
final class SearchResultBlockParam implements BaseModel
{
    /** @use SdkModel<SearchResultBlockParamShape> */
    use SdkModel;

    /** @var 'search_result' $type */
    #[Required]
    public string $type = 'search_result';

    /** @var list<TextBlockParam> $content */
    #[Required(list: TextBlockParam::class)]
    public array $content;

    #[Required]
    public string $source;

    #[Required]
    public string $title;

    /**
     * Create a cache control breakpoint at this content block.
     */
    #[Optional('cache_control', nullable: true)]
    public ?CacheControlEphemeral $cacheControl;

    #[Optional]
    public ?CitationsConfigParam $citations;

    /**
     * `new SearchResultBlockParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * SearchResultBlockParam::with(content: ..., source: ..., title: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new SearchResultBlockParam)->withContent(...)->withSource(...)->withTitle(...)
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
     *
     * @param list<TextBlockParam|array{
     *   text: string,
     *   type?: 'text',
     *   cacheControl?: CacheControlEphemeral|null,
     *   citations?: list<CitationCharLocationParam|CitationPageLocationParam|CitationContentBlockLocationParam|CitationWebSearchResultLocationParam|CitationSearchResultLocationParam>|null,
     * }> $content
     * @param CacheControlEphemeral|array{
     *   type?: 'ephemeral', ttl?: value-of<TTL>|null
     * }|null $cacheControl
     * @param CitationsConfigParam|array{enabled?: bool|null} $citations
     */
    public static function with(
        array $content,
        string $source,
        string $title,
        CacheControlEphemeral|array|null $cacheControl = null,
        CitationsConfigParam|array|null $citations = null,
    ): self {
        $self = new self;

        $self['content'] = $content;
        $self['source'] = $source;
        $self['title'] = $title;

        null !== $cacheControl && $self['cacheControl'] = $cacheControl;
        null !== $citations && $self['citations'] = $citations;

        return $self;
    }

    /**
     * @param list<TextBlockParam|array{
     *   text: string,
     *   type?: 'text',
     *   cacheControl?: CacheControlEphemeral|null,
     *   citations?: list<CitationCharLocationParam|CitationPageLocationParam|CitationContentBlockLocationParam|CitationWebSearchResultLocationParam|CitationSearchResultLocationParam>|null,
     * }> $content
     */
    public function withContent(array $content): self
    {
        $self = clone $this;
        $self['content'] = $content;

        return $self;
    }

    public function withSource(string $source): self
    {
        $self = clone $this;
        $self['source'] = $source;

        return $self;
    }

    public function withTitle(string $title): self
    {
        $self = clone $this;
        $self['title'] = $title;

        return $self;
    }

    /**
     * Create a cache control breakpoint at this content block.
     *
     * @param CacheControlEphemeral|array{
     *   type?: 'ephemeral', ttl?: value-of<TTL>|null
     * }|null $cacheControl
     */
    public function withCacheControl(
        CacheControlEphemeral|array|null $cacheControl
    ): self {
        $self = clone $this;
        $self['cacheControl'] = $cacheControl;

        return $self;
    }

    /**
     * @param CitationsConfigParam|array{enabled?: bool|null} $citations
     */
    public function withCitations(CitationsConfigParam|array $citations): self
    {
        $self = clone $this;
        $self['citations'] = $citations;

        return $self;
    }
}
