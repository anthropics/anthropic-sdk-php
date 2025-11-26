<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type TextBlockParamShape = array{
 *   text: string,
 *   type: 'text',
 *   cache_control?: CacheControlEphemeral|null,
 *   citations?: list<CitationCharLocationParam|CitationPageLocationParam|CitationContentBlockLocationParam|CitationWebSearchResultLocationParam|CitationSearchResultLocationParam>|null,
 * }
 */
final class TextBlockParam implements BaseModel
{
    /** @use SdkModel<TextBlockParamShape> */
    use SdkModel;

    /** @var 'text' $type */
    #[Api]
    public string $type = 'text';

    #[Api]
    public string $text;

    /**
     * Create a cache control breakpoint at this content block.
     */
    #[Api(nullable: true, optional: true)]
    public ?CacheControlEphemeral $cache_control;

    /**
     * @var list<CitationCharLocationParam|CitationPageLocationParam|CitationContentBlockLocationParam|CitationWebSearchResultLocationParam|CitationSearchResultLocationParam>|null $citations
     */
    #[Api(list: TextCitationParam::class, nullable: true, optional: true)]
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
     * @param list<CitationCharLocationParam|CitationPageLocationParam|CitationContentBlockLocationParam|CitationWebSearchResultLocationParam|CitationSearchResultLocationParam>|null $citations
     */
    public static function with(
        string $text,
        ?CacheControlEphemeral $cache_control = null,
        ?array $citations = null,
    ): self {
        $obj = new self;

        $obj->text = $text;

        null !== $cache_control && $obj->cache_control = $cache_control;
        null !== $citations && $obj->citations = $citations;

        return $obj;
    }

    public function withText(string $text): self
    {
        $obj = clone $this;
        $obj->text = $text;

        return $obj;
    }

    /**
     * Create a cache control breakpoint at this content block.
     */
    public function withCacheControl(?CacheControlEphemeral $cacheControl): self
    {
        $obj = clone $this;
        $obj->cache_control = $cacheControl;

        return $obj;
    }

    /**
     * @param list<CitationCharLocationParam|CitationPageLocationParam|CitationContentBlockLocationParam|CitationWebSearchResultLocationParam|CitationSearchResultLocationParam>|null $citations
     */
    public function withCitations(?array $citations): self
    {
        $obj = clone $this;
        $obj->citations = $citations;

        return $obj;
    }
}
