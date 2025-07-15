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
    public string $text;

    #[Api]
    public string $type;

    #[Api('cache_control', optional: true)]
    public ?CacheControlEphemeral $cacheControl;

    /**
     * @var list<
     *   CitationCharLocationParam|CitationPageLocationParam|CitationContentBlockLocationParam|CitationWebSearchResultLocationParam
     * >|null $citations
     */
    #[Api(
        type: new UnionOf(
            [
                new ListOf(
                    new UnionOf(
                        [
                            CitationCharLocationParam::class,
                            CitationPageLocationParam::class,
                            CitationContentBlockLocationParam::class,
                            CitationWebSearchResultLocationParam::class,
                        ],
                    ),
                ),
                'null',
            ],
        ),
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
        string $type,
        ?CacheControlEphemeral $cacheControl = null,
        ?array $citations = null,
    ) {
        $this->text = $text;
        $this->type = $type;
        $this->cacheControl = $cacheControl;
        $this->citations = $citations;
    }
}

TextBlockParam::_loadMetadata();
