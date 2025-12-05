<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaCacheControlEphemeral\TTL;
use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaSearchResultBlockParamShape = array{
 *   content: list<BetaTextBlockParam>,
 *   source: string,
 *   title: string,
 *   type: 'search_result',
 *   cache_control?: BetaCacheControlEphemeral|null,
 *   citations?: BetaCitationsConfigParam|null,
 * }
 */
final class BetaSearchResultBlockParam implements BaseModel
{
    /** @use SdkModel<BetaSearchResultBlockParamShape> */
    use SdkModel;

    /** @var 'search_result' $type */
    #[Api]
    public string $type = 'search_result';

    /** @var list<BetaTextBlockParam> $content */
    #[Api(list: BetaTextBlockParam::class)]
    public array $content;

    #[Api]
    public string $source;

    #[Api]
    public string $title;

    /**
     * Create a cache control breakpoint at this content block.
     */
    #[Api(nullable: true, optional: true)]
    public ?BetaCacheControlEphemeral $cache_control;

    #[Api(optional: true)]
    public ?BetaCitationsConfigParam $citations;

    /**
     * `new BetaSearchResultBlockParam()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaSearchResultBlockParam::with(content: ..., source: ..., title: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaSearchResultBlockParam)
     *   ->withContent(...)
     *   ->withSource(...)
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
     *
     * @param list<BetaTextBlockParam|array{
     *   text: string,
     *   type: 'text',
     *   cache_control?: BetaCacheControlEphemeral|null,
     *   citations?: list<BetaCitationCharLocationParam|BetaCitationPageLocationParam|BetaCitationContentBlockLocationParam|BetaCitationWebSearchResultLocationParam|BetaCitationSearchResultLocationParam>|null,
     * }> $content
     * @param BetaCacheControlEphemeral|array{
     *   type: 'ephemeral', ttl?: value-of<TTL>|null
     * }|null $cache_control
     * @param BetaCitationsConfigParam|array{enabled?: bool|null} $citations
     */
    public static function with(
        array $content,
        string $source,
        string $title,
        BetaCacheControlEphemeral|array|null $cache_control = null,
        BetaCitationsConfigParam|array|null $citations = null,
    ): self {
        $obj = new self;

        $obj['content'] = $content;
        $obj['source'] = $source;
        $obj['title'] = $title;

        null !== $cache_control && $obj['cache_control'] = $cache_control;
        null !== $citations && $obj['citations'] = $citations;

        return $obj;
    }

    /**
     * @param list<BetaTextBlockParam|array{
     *   text: string,
     *   type: 'text',
     *   cache_control?: BetaCacheControlEphemeral|null,
     *   citations?: list<BetaCitationCharLocationParam|BetaCitationPageLocationParam|BetaCitationContentBlockLocationParam|BetaCitationWebSearchResultLocationParam|BetaCitationSearchResultLocationParam>|null,
     * }> $content
     */
    public function withContent(array $content): self
    {
        $obj = clone $this;
        $obj['content'] = $content;

        return $obj;
    }

    public function withSource(string $source): self
    {
        $obj = clone $this;
        $obj['source'] = $source;

        return $obj;
    }

    public function withTitle(string $title): self
    {
        $obj = clone $this;
        $obj['title'] = $title;

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
     * @param BetaCitationsConfigParam|array{enabled?: bool|null} $citations
     */
    public function withCitations(
        BetaCitationsConfigParam|array $citations
    ): self {
        $obj = clone $this;
        $obj['citations'] = $citations;

        return $obj;
    }
}
