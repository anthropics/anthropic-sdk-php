<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Optional;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type TextBlockParamShape from \Anthropic\Messages\TextBlockParam
 * @phpstan-import-type CacheControlEphemeralShape from \Anthropic\Messages\CacheControlEphemeral
 * @phpstan-import-type CitationsConfigParamShape from \Anthropic\Messages\CitationsConfigParam
 *
 * @phpstan-type SearchResultBlockParamShape = array{
 *   content: list<TextBlockParamShape>,
 *   source: string,
 *   title: string,
 *   type: 'search_result',
 *   cacheControl?: null|CacheControlEphemeral|CacheControlEphemeralShape,
 *   citations?: null|CitationsConfigParam|CitationsConfigParamShape,
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
     * @param list<TextBlockParamShape> $content
     * @param CacheControlEphemeralShape|null $cacheControl
     * @param CitationsConfigParamShape $citations
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
     * @param list<TextBlockParamShape> $content
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
     * @param CacheControlEphemeralShape|null $cacheControl
     */
    public function withCacheControl(
        CacheControlEphemeral|array|null $cacheControl
    ): self {
        $self = clone $this;
        $self['cacheControl'] = $cacheControl;

        return $self;
    }

    /**
     * @param CitationsConfigParamShape $citations
     */
    public function withCitations(CitationsConfigParam|array $citations): self
    {
        $self = clone $this;
        $self['citations'] = $citations;

        return $self;
    }
}
