<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model as ModelTrait;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ListOf;

/**
 * @phpstan-type search_result_block_param_alias = array{
 *   content: list<TextBlockParam>,
 *   source: string,
 *   title: string,
 *   type: string,
 *   cacheControl?: CacheControlEphemeral,
 *   citations?: CitationsConfigParam,
 * }
 */
final class SearchResultBlockParam implements BaseModel
{
    use ModelTrait;

    #[Api]
    public string $type = 'search_result';

    /** @var list<TextBlockParam> $content */
    #[Api(type: new ListOf(TextBlockParam::class))]
    public array $content;

    #[Api]
    public string $source;

    #[Api]
    public string $title;

    /**
     * Create a cache control breakpoint at this content block.
     */
    #[Api('cache_control', optional: true)]
    public ?CacheControlEphemeral $cacheControl;

    #[Api(optional: true)]
    public ?CitationsConfigParam $citations;

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
    public static function from(
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
    public function setContent(array $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function setSource(string $source): self
    {
        $this->source = $source;

        return $this;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Create a cache control breakpoint at this content block.
     */
    public function setCacheControl(CacheControlEphemeral $cacheControl): self
    {
        $this->cacheControl = $cacheControl;

        return $this;
    }

    public function setCitations(CitationsConfigParam $citations): self
    {
        $this->citations = $citations;

        return $this;
    }
}
