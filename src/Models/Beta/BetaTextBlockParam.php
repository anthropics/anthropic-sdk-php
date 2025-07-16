<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Serde\ListOf;
use Anthropic\Core\Serde\UnionOf;
use Anthropic\Models\Beta\BetaTextBlockParam\Type;

final class BetaTextBlockParam implements BaseModel
{
    use Model;

    #[Api]
    public string $text;

    /** @var Type::* $type */
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
     * You must use named parameters to construct this object.
     *
     * @param Type::* $type
     * @param list<
     *   BetaCitationCharLocationParam|BetaCitationPageLocationParam|BetaCitationContentBlockLocationParam|BetaCitationWebSearchResultLocationParam|BetaCitationSearchResultLocationParam
     * >|null $citations
     */
    final public function __construct(
        string $text,
        string $type,
        ?BetaCacheControlEphemeral $cacheControl = null,
        ?array $citations = null,
    ) {
        $this->text = $text;
        $this->type = $type;
        $this->cacheControl = $cacheControl;
        $this->citations = $citations;
    }
}

BetaTextBlockParam::_loadMetadata();
