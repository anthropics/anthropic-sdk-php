<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\None;
use Anthropic\Core\Serde\ListOf;
use Anthropic\Core\Serde\UnionOf;

class BetaTextBlockParam implements BaseModel
{
    use Model;

    #[Api]
    public string $text;

    #[Api]
    public string $type;

    #[Api('cache_control', optional: true)]
    public BetaCacheControlEphemeral $cacheControl;

    /**
     * @var null|list<BetaCitationCharLocationParam|BetaCitationContentBlockLocationParam|BetaCitationPageLocationParam|BetaCitationSearchResultLocationParam|BetaCitationWebSearchResultLocationParam> $citations
     */
    #[Api(
        type: new UnionOf(
            [
                new ListOf(
                    new UnionOf(
                        [
                            BetaCitationCharLocationParam::class,
                            BetaCitationPageLocationParam::class,
                            BetaCitationContentBlockLocationParam::class,
                            BetaCitationWebSearchResultLocationParam::class,
                            BetaCitationSearchResultLocationParam::class,
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
     * @param BetaCacheControlEphemeral                                                                                                                                                                   $cacheControl
     * @param null|list<BetaCitationCharLocationParam|BetaCitationContentBlockLocationParam|BetaCitationPageLocationParam|BetaCitationSearchResultLocationParam|BetaCitationWebSearchResultLocationParam> $citations
     */
    final public function __construct(
        string $text,
        string $type,
        BetaCacheControlEphemeral|None $cacheControl = None::NOT_SET,
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

BetaTextBlockParam::_loadMetadata();
