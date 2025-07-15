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
    public ?BetaCacheControlEphemeral $cacheControl;

    /**
     * @var list<
     *   BetaCitationCharLocationParam|BetaCitationPageLocationParam|BetaCitationContentBlockLocationParam|BetaCitationWebSearchResultLocationParam|BetaCitationSearchResultLocationParam
     * >|null $citations
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
     * You must use named parameters to construct this object. If an named argument is not
     * given, it will not be included during JSON serialization. The arguments are untyped
     * so you can pass any JSON serializable value, but the API expects the types to match
     * the PHPDoc types.
     *
     * @param string                    $text         `required`
     * @param string                    $type         `required`
     * @param BetaCacheControlEphemeral $cacheControl
     * @param list<
     *   BetaCitationCharLocationParam|BetaCitationPageLocationParam|BetaCitationContentBlockLocationParam|BetaCitationWebSearchResultLocationParam|BetaCitationSearchResultLocationParam
     * >|null $citations
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

BetaTextBlockParam::_loadMetadata();
