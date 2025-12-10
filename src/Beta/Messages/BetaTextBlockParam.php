<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaCacheControlEphemeral\TTL;
use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaTextBlockParamShape = array{
 *   text: string,
 *   type?: 'text',
 *   cacheControl?: BetaCacheControlEphemeral|null,
 *   citations?: list<BetaCitationCharLocationParam|BetaCitationPageLocationParam|BetaCitationContentBlockLocationParam|BetaCitationWebSearchResultLocationParam|BetaCitationSearchResultLocationParam>|null,
 * }
 */
final class BetaTextBlockParam implements BaseModel
{
    /** @use SdkModel<BetaTextBlockParamShape> */
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
    public ?BetaCacheControlEphemeral $cacheControl;

    /**
     * @var list<BetaCitationCharLocationParam|BetaCitationPageLocationParam|BetaCitationContentBlockLocationParam|BetaCitationWebSearchResultLocationParam|BetaCitationSearchResultLocationParam>|null $citations
     */
    #[Optional(list: BetaTextCitationParam::class, nullable: true)]
    public ?array $citations;

    /**
     * `new BetaTextBlockParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaTextBlockParam::with(text: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaTextBlockParam)->withText(...)
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
     * @param BetaCacheControlEphemeral|array{
     *   type?: 'ephemeral', ttl?: value-of<TTL>|null
     * }|null $cacheControl
     * @param list<BetaCitationCharLocationParam|array{
     *   citedText: string,
     *   documentIndex: int,
     *   documentTitle: string|null,
     *   endCharIndex: int,
     *   startCharIndex: int,
     *   type?: 'char_location',
     * }|BetaCitationPageLocationParam|array{
     *   citedText: string,
     *   documentIndex: int,
     *   documentTitle: string|null,
     *   endPageNumber: int,
     *   startPageNumber: int,
     *   type?: 'page_location',
     * }|BetaCitationContentBlockLocationParam|array{
     *   citedText: string,
     *   documentIndex: int,
     *   documentTitle: string|null,
     *   endBlockIndex: int,
     *   startBlockIndex: int,
     *   type?: 'content_block_location',
     * }|BetaCitationWebSearchResultLocationParam|array{
     *   citedText: string,
     *   encryptedIndex: string,
     *   title: string|null,
     *   type?: 'web_search_result_location',
     *   url: string,
     * }|BetaCitationSearchResultLocationParam|array{
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
        BetaCacheControlEphemeral|array|null $cacheControl = null,
        ?array $citations = null,
    ): self {
        $obj = new self;

        $obj['text'] = $text;

        null !== $cacheControl && $obj['cacheControl'] = $cacheControl;
        null !== $citations && $obj['citations'] = $citations;

        return $obj;
    }

    public function withText(string $text): self
    {
        $obj = clone $this;
        $obj['text'] = $text;

        return $obj;
    }

    /**
     * Create a cache control breakpoint at this content block.
     *
     * @param BetaCacheControlEphemeral|array{
     *   type?: 'ephemeral', ttl?: value-of<TTL>|null
     * }|null $cacheControl
     */
    public function withCacheControl(
        BetaCacheControlEphemeral|array|null $cacheControl
    ): self {
        $obj = clone $this;
        $obj['cacheControl'] = $cacheControl;

        return $obj;
    }

    /**
     * @param list<BetaCitationCharLocationParam|array{
     *   citedText: string,
     *   documentIndex: int,
     *   documentTitle: string|null,
     *   endCharIndex: int,
     *   startCharIndex: int,
     *   type?: 'char_location',
     * }|BetaCitationPageLocationParam|array{
     *   citedText: string,
     *   documentIndex: int,
     *   documentTitle: string|null,
     *   endPageNumber: int,
     *   startPageNumber: int,
     *   type?: 'page_location',
     * }|BetaCitationContentBlockLocationParam|array{
     *   citedText: string,
     *   documentIndex: int,
     *   documentTitle: string|null,
     *   endBlockIndex: int,
     *   startBlockIndex: int,
     *   type?: 'content_block_location',
     * }|BetaCitationWebSearchResultLocationParam|array{
     *   citedText: string,
     *   encryptedIndex: string,
     *   title: string|null,
     *   type?: 'web_search_result_location',
     *   url: string,
     * }|BetaCitationSearchResultLocationParam|array{
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
        $obj = clone $this;
        $obj['citations'] = $citations;

        return $obj;
    }
}
