<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Serde\ListOf;
use Anthropic\Core\Serde\UnionOf;

final class TextBlockParam implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'text';

    #[Api]
    public string $text;

    #[Api('cache_control', optional: true)]
    public ?CacheControlEphemeral $cacheControl;

    /**
     * @var list<
     *   CitationCharLocationParam|CitationPageLocationParam|CitationContentBlockLocationParam|CitationWebSearchResultLocationParam
     * >|null $citations
     */
    #[Api(
        type: new ListOf(
            union: new UnionOf(
                [
                    CitationCharLocationParam::class,
                    CitationPageLocationParam::class,
                    CitationContentBlockLocationParam::class,
                    CitationWebSearchResultLocationParam::class,
                ],
            ),
        ),
        nullable: true,
        optional: true,
    )]
    public ?array $citations;

    /**
     * You must use named parameters to construct this object.
     *
     * @param list<
     *   CitationCharLocationParam|CitationPageLocationParam|CitationContentBlockLocationParam|CitationWebSearchResultLocationParam
     * >|null $citations
     */
    final public function __construct(
        string $text,
        ?CacheControlEphemeral $cacheControl = null,
        ?array $citations = null,
    ) {
        self::introspect();
        $this->unsetOptionalProperties();

        $this->text = $text;

        null !== $cacheControl && $this->cacheControl = $cacheControl;
        null !== $citations && $this->citations = $citations;
    }
}
