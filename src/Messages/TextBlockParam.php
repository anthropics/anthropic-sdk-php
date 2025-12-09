<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Messages\CacheControlEphemeral\TTL;

/**
 * @phpstan-type TextBlockParamShape = array{
 *   text: string,
 *   type?: 'text',
 *   cacheControl?: CacheControlEphemeral|null,
 *   citations?: list<CitationCharLocationParam|CitationPageLocationParam|CitationContentBlockLocationParam|CitationWebSearchResultLocationParam|CitationSearchResultLocationParam>|null,
 * }
 */
final class TextBlockParam implements BaseModel
{
    /** @use SdkModel<TextBlockParamShape> */
    use SdkModel;

    /** @var 'text' $type */
    #[Required]
    public string $type = 'text';

    #[Required]
    public string $text;

    /**
     * Create a cache control breakpoint at this content block.
     */
    #[Optional('cache_control', nullable: true)]
    public ?CacheControlEphemeral $cacheControl;

    /**
     * @var list<CitationCharLocationParam|CitationPageLocationParam|CitationContentBlockLocationParam|CitationWebSearchResultLocationParam|CitationSearchResultLocationParam>|null $citations
     */
    #[Optional(list: TextCitationParam::class, nullable: true)]
    public ?array $citations;

    /**
     * `new TextBlockParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * TextBlockParam::with(text: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new TextBlockParam)->withText(...)
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
     * @param CacheControlEphemeral|array{
     *   type?: 'ephemeral', ttl?: value-of<TTL>|null
     * }|null $cacheControl
     * @param list<CitationCharLocationParam|array{
     *   citedText: string,
     *   documentIndex: int,
     *   documentTitle: string|null,
     *   endCharIndex: int,
     *   startCharIndex: int,
     *   type?: 'char_location',
     * }|CitationPageLocationParam|array{
     *   citedText: string,
     *   documentIndex: int,
     *   documentTitle: string|null,
     *   endPageNumber: int,
     *   startPageNumber: int,
     *   type?: 'page_location',
     * }|CitationContentBlockLocationParam|array{
     *   citedText: string,
     *   documentIndex: int,
     *   documentTitle: string|null,
     *   endBlockIndex: int,
     *   startBlockIndex: int,
     *   type?: 'content_block_location',
     * }|CitationWebSearchResultLocationParam|array{
     *   citedText: string,
     *   encryptedIndex: string,
     *   title: string|null,
     *   type?: 'web_search_result_location',
     *   url: string,
     * }|CitationSearchResultLocationParam|array{
     *   citedText: string,
     *   endBlockIndex: int,
     *   searchResultIndex: int,
     *   source: string,
     *   startBlockIndex: int,
     *   title: string|null,
     *   type?: 'search_result_location',
     * }>|null $citations
     */
    public static function with(
        string $text,
        CacheControlEphemeral|array|null $cacheControl = null,
        ?array $citations = null,
    ): self {
        $self = new self;

        $self['text'] = $text;

        null !== $cacheControl && $self['cacheControl'] = $cacheControl;
        null !== $citations && $self['citations'] = $citations;

        return $self;
    }

    public function withText(string $text): self
    {
        $self = clone $this;
        $self['text'] = $text;

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
     * @param list<CitationCharLocationParam|array{
     *   citedText: string,
     *   documentIndex: int,
     *   documentTitle: string|null,
     *   endCharIndex: int,
     *   startCharIndex: int,
     *   type?: 'char_location',
     * }|CitationPageLocationParam|array{
     *   citedText: string,
     *   documentIndex: int,
     *   documentTitle: string|null,
     *   endPageNumber: int,
     *   startPageNumber: int,
     *   type?: 'page_location',
     * }|CitationContentBlockLocationParam|array{
     *   citedText: string,
     *   documentIndex: int,
     *   documentTitle: string|null,
     *   endBlockIndex: int,
     *   startBlockIndex: int,
     *   type?: 'content_block_location',
     * }|CitationWebSearchResultLocationParam|array{
     *   citedText: string,
     *   encryptedIndex: string,
     *   title: string|null,
     *   type?: 'web_search_result_location',
     *   url: string,
     * }|CitationSearchResultLocationParam|array{
     *   citedText: string,
     *   endBlockIndex: int,
     *   searchResultIndex: int,
     *   source: string,
     *   startBlockIndex: int,
     *   title: string|null,
     *   type?: 'search_result_location',
     * }>|null $citations
     */
    public function withCitations(?array $citations): self
    {
        $self = clone $this;
        $self['citations'] = $citations;

        return $self;
    }
}
