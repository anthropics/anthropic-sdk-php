<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

final class BetaSearchResultBlockParam implements BaseModel
{
    use SdkModel;

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
    #[Api('cache_control', nullable: true, optional: true)]
    public ?BetaCacheControlEphemeral $cacheControl;

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
        self::introspect();
        $this->unsetOptionalProperties();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<BetaTextBlockParam> $content
     */
    public static function with(
        array $content,
        string $source,
        string $title,
        ?BetaCacheControlEphemeral $cacheControl = null,
        ?BetaCitationsConfigParam $citations = null,
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
     * @param list<BetaTextBlockParam> $content
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
    public function withCacheControl(
        BetaCacheControlEphemeral $cacheControl
    ): self {
        $obj = clone $this;
        $obj->cacheControl = $cacheControl;

        return $obj;
    }

    public function withCitations(BetaCitationsConfigParam $citations): self
    {
        $obj = clone $this;
        $obj->citations = $citations;

        return $obj;
    }
}
