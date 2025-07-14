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
     * You must use named parameters to construct this object. If an named argument is not
     * given, it will not be included during JSON serialization. The arguments are untyped
     * so you can pass any JSON serializable value, but the API expects the types to match
     * the PHPDoc types.
     *
     * @param string                                                                                                                                $text         `required`
     * @param string                                                                                                                                $type         `required`
     * @param CacheControlEphemeral                                                                                                                 $cacheControl
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
