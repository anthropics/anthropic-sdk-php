<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model as ModelTrait;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ListOf;

/**
 * @phpstan-type text_block_param_alias = array{
 *   text: string,
 *   type: string,
 *   cacheControl?: CacheControlEphemeral,
 *   citations?: list<CitationCharLocationParam|CitationPageLocationParam|CitationContentBlockLocationParam|CitationWebSearchResultLocationParam|CitationSearchResultLocationParam>|null,
 * }
 */
final class TextBlockParam implements BaseModel
{
    use ModelTrait;

    #[Api]
    public string $type = 'text';

    #[Api]
    public string $text;

    /**
     * Create a cache control breakpoint at this content block.
     */
    #[Api('cache_control', optional: true)]
    public ?CacheControlEphemeral $cacheControl;

    /**
     * @var null|list<CitationCharLocationParam|CitationContentBlockLocationParam|CitationPageLocationParam|CitationSearchResultLocationParam|CitationWebSearchResultLocationParam> $citations
     */
    #[Api(
        type: new ListOf(union: TextCitationParam::class),
        nullable: true,
        optional: true,
    )]
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
        self::introspect();
        $this->unsetOptionalProperties();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param null|list<CitationCharLocationParam|CitationContentBlockLocationParam|CitationPageLocationParam|CitationSearchResultLocationParam|CitationWebSearchResultLocationParam> $citations
     */
    public static function with(
        string $text,
        ?CacheControlEphemeral $cacheControl = null,
        ?array $citations = null,
    ): self {
        $obj = new self;

        $obj->text = $text;

        null !== $cacheControl && $obj->cacheControl = $cacheControl;
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
    public function withCacheControl(CacheControlEphemeral $cacheControl): self
    {
        $obj = clone $this;
        $obj->cacheControl = $cacheControl;

        return $obj;
    }

    /**
     * @param null|list<CitationCharLocationParam|CitationContentBlockLocationParam|CitationPageLocationParam|CitationSearchResultLocationParam|CitationWebSearchResultLocationParam> $citations
     */
    public function withCitations(?array $citations): self
    {
        $obj = clone $this;
        $obj->citations = $citations;

        return $obj;
    }
}
