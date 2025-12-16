<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type BetaTextBlockParamShape from \Anthropic\Beta\Messages\BetaTextBlockParam
 * @phpstan-import-type BetaCacheControlEphemeralShape from \Anthropic\Beta\Messages\BetaCacheControlEphemeral
 * @phpstan-import-type BetaCitationsConfigParamShape from \Anthropic\Beta\Messages\BetaCitationsConfigParam
 *
 * @phpstan-type BetaSearchResultBlockParamShape = array{
 *   content: list<BetaTextBlockParamShape>,
 *   source: string,
 *   title: string,
 *   type: 'search_result',
 *   cacheControl?: null|BetaCacheControlEphemeral|BetaCacheControlEphemeralShape,
 *   citations?: null|BetaCitationsConfigParam|BetaCitationsConfigParamShape,
 * }
 */
final class BetaSearchResultBlockParam implements BaseModel
{
    /** @use SdkModel<BetaSearchResultBlockParamShape> */
    use SdkModel;

    /** @var 'search_result' $type */
    #[Required]
    public string $type = 'search_result';

    /** @var list<BetaTextBlockParam> $content */
    #[Required(list: BetaTextBlockParam::class)]
    public array $content;

    #[Required]
    public string $source;

    #[Required]
    public string $title;

    /**
     * Create a cache control breakpoint at this content block.
     */
    #[Optional('cache_control', nullable: true)]
    public ?BetaCacheControlEphemeral $cacheControl;

    #[Optional]
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
     * @param list<BetaTextBlockParamShape> $content
     * @param BetaCacheControlEphemeralShape|null $cacheControl
     * @param BetaCitationsConfigParamShape $citations
     */
    public static function with(
        array $content,
        string $source,
        string $title,
        BetaCacheControlEphemeral|array|null $cacheControl = null,
        BetaCitationsConfigParam|array|null $citations = null,
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
     * @param list<BetaTextBlockParamShape> $content
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
     * @param BetaCacheControlEphemeralShape|null $cacheControl
     */
    public function withCacheControl(
        BetaCacheControlEphemeral|array|null $cacheControl
    ): self {
        $self = clone $this;
        $self['cacheControl'] = $cacheControl;

        return $self;
    }

    /**
     * @param BetaCitationsConfigParamShape $citations
     */
    public function withCitations(
        BetaCitationsConfigParam|array $citations
    ): self {
        $self = clone $this;
        $self['citations'] = $citations;

        return $self;
    }
}
