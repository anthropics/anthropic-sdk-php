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
    public CacheControlEphemeral $cacheControl;

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
     * @param CacheControlEphemeral                                                                                                                 $cacheControl
     * @param null|list<CitationCharLocationParam|CitationContentBlockLocationParam|CitationPageLocationParam|CitationWebSearchResultLocationParam> $citations
     */
    final public function __construct(
        string $text,
        string $type,
        CacheControlEphemeral|None $cacheControl = None::NOT_SET,
        null|array|None $citations = None::NOT_SET
    ) {
        $args = func_get_args();

        $data = [];
        for ($i = 0; $i < count($args); ++$i) {
            if (None::NOT_SET !== $args[$i]) {
                $data[self::$_constructorArgNames[$i]] = $args[$i] ?? null;
            }
        }

        $this->__unserialize($data);
    }
}

TextBlockParam::_loadMetadata();
