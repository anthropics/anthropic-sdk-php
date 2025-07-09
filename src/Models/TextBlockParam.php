<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\None;
use Anthropic\Core\Serde\ListOf;
use Anthropic\Core\Serde\UnionOf;

class TextBlockParam implements BaseModel
{
    use Model;

    #[Api]
    public string $text;

    #[Api]
    public string $type;

    #[Api('cache_control', optional: true)]
    public ?CacheControlEphemeral $cacheControl;

    /**
     * @var null|list<CitationCharLocationParam|CitationContentBlockLocationParam|CitationPageLocationParam|CitationWebSearchResultLocationParam> $citations
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
     * @param string                                                                                                                                $text
     * @param string                                                                                                                                $type
     * @param null|CacheControlEphemeral                                                                                                            $cacheControl
     * @param null|list<CitationCharLocationParam|CitationContentBlockLocationParam|CitationPageLocationParam|CitationWebSearchResultLocationParam> $citations
     */
    final public function __construct(
        $text,
        $type,
        $cacheControl = None::NOT_GIVEN,
        $citations = None::NOT_GIVEN
    ) {
        $this->constructFromArgs(func_get_args());
    }
}

TextBlockParam::_loadMetadata();
