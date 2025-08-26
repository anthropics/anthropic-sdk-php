<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type search_result_block_param = array{
 *   content: list<TextBlockParam>,
 *   source: string,
 *   title: string,
 *   type: string,
 *   cacheControl?: CacheControlEphemeral|null,
 *   citations?: CitationsConfigParam|null,
 * }
 */
final class SearchResultBlockParam implements BaseModel
{
    /** @use SdkModel<search_result_block_param> */
    use SdkModel;

    #[Api]
    public string $type = 'search_result';

    /** @var list<TextBlockParam> $content */
    #[Api(list: TextBlockParam::class)]
    public array $content;

    #[Api]
    public string $source;

    #[Api]
    public string $title;

    /**
     * Create a cache control breakpoint at this content block.
     */
    #[Api('cache_control', nullable: true, optional: true)]
    public ?CacheControlEphemeral $cacheControl;

    #[Api(optional: true)]
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
        self::introspect();
        $this->unsetOptionalProperties();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<TextBlockParam> $content
     */
    public static function with(
        array $content,
        string $source,
        string $title,
        ?CacheControlEphemeral $cacheControl = null,
        ?CitationsConfigParam $citations = null,
    ): self {
        $obj = new self;

        $obj->content = $content;
        $obj->source = $source;
        $obj->title = $title;

        null !== $cacheControl && $obj->cacheControl = $cacheControl;
        null !== $citations && $obj->citations = $citations;

        return $obj;
    }

    /**
     * @param list<TextBlockParam> $content
     */
    public function withContent(array $content): self
    {
        $obj = clone $this;
        $obj->content = $content;

        return $obj;
    }

    public function withSource(string $source): self
    {
        $obj = clone $this;
        $obj->source = $source;

        return $obj;
    }

    public function withTitle(string $title): self
    {
        $obj = clone $this;
        $obj->title = $title;

        return $obj;
    }

    /**
     * Create a cache control breakpoint at this content block.
     */
    public function withCacheControl(CacheControlEphemeral $cacheControl): self
    {
        $obj = clone $this;
        $obj->cacheControl = $cacheControl;

        return $obj;
    }

    public function withCitations(CitationsConfigParam $citations): self
    {
        $obj = clone $this;
        $obj->citations = $citations;

        return $obj;
    }
}
