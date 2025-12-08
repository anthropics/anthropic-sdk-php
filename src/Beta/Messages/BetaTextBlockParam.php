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
 *   type: 'text',
 *   cache_control?: BetaCacheControlEphemeral|null,
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
    #[Optional(nullable: true)]
    public ?BetaCacheControlEphemeral $cache_control;

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
     *   type: 'ephemeral', ttl?: value-of<TTL>|null
     * }|null $cache_control
     * @param list<BetaCitationCharLocationParam|array{
     *   cited_text: string,
     *   document_index: int,
     *   document_title: string|null,
     *   end_char_index: int,
     *   start_char_index: int,
     *   type: 'char_location',
     * }|BetaCitationPageLocationParam|array{
     *   cited_text: string,
     *   document_index: int,
     *   document_title: string|null,
     *   end_page_number: int,
     *   start_page_number: int,
     *   type: 'page_location',
     * }|BetaCitationContentBlockLocationParam|array{
     *   cited_text: string,
     *   document_index: int,
     *   document_title: string|null,
     *   end_block_index: int,
     *   start_block_index: int,
     *   type: 'content_block_location',
     * }|BetaCitationWebSearchResultLocationParam|array{
     *   cited_text: string,
     *   encrypted_index: string,
     *   title: string|null,
     *   type: 'web_search_result_location',
     *   url: string,
     * }|BetaCitationSearchResultLocationParam|array{
     *   cited_text: string,
     *   end_block_index: int,
     *   search_result_index: int,
     *   source: string,
     *   start_block_index: int,
     *   title: string|null,
     *   type: 'search_result_location',
     * }>|null $citations
     */
    public static function with(
        string $text,
        BetaCacheControlEphemeral|array|null $cache_control = null,
        ?array $citations = null,
    ): self {
        $obj = new self;

        $obj['text'] = $text;

        null !== $cache_control && $obj['cache_control'] = $cache_control;
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
     *   type: 'ephemeral', ttl?: value-of<TTL>|null
     * }|null $cacheControl
     */
    public function withCacheControl(
        BetaCacheControlEphemeral|array|null $cacheControl
    ): self {
        $obj = clone $this;
        $obj['cache_control'] = $cacheControl;

        return $obj;
    }

    /**
     * @param list<BetaCitationCharLocationParam|array{
     *   cited_text: string,
     *   document_index: int,
     *   document_title: string|null,
     *   end_char_index: int,
     *   start_char_index: int,
     *   type: 'char_location',
     * }|BetaCitationPageLocationParam|array{
     *   cited_text: string,
     *   document_index: int,
     *   document_title: string|null,
     *   end_page_number: int,
     *   start_page_number: int,
     *   type: 'page_location',
     * }|BetaCitationContentBlockLocationParam|array{
     *   cited_text: string,
     *   document_index: int,
     *   document_title: string|null,
     *   end_block_index: int,
     *   start_block_index: int,
     *   type: 'content_block_location',
     * }|BetaCitationWebSearchResultLocationParam|array{
     *   cited_text: string,
     *   encrypted_index: string,
     *   title: string|null,
     *   type: 'web_search_result_location',
     *   url: string,
     * }|BetaCitationSearchResultLocationParam|array{
     *   cited_text: string,
     *   end_block_index: int,
     *   search_result_index: int,
     *   source: string,
     *   start_block_index: int,
     *   title: string|null,
     *   type: 'search_result_location',
     * }>|null $citations
     */
    public function withCitations(?array $citations): self
    {
        $obj = clone $this;
        $obj['citations'] = $citations;

        return $obj;
    }
}
