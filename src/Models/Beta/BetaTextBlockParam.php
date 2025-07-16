<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Serde\ListOf;
use Anthropic\Core\Serde\UnionOf;

final class BetaTextBlockParam implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'text';

    #[Api]
    public string $text;

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
     * @param list<
     *   BetaCitationCharLocationParam|BetaCitationPageLocationParam|BetaCitationContentBlockLocationParam|BetaCitationWebSearchResultLocationParam|BetaCitationSearchResultLocationParam
     * >|null $citations
     */
    final public function __construct(
        string $text,
        ?BetaCacheControlEphemeral $cacheControl = null,
        ?array $citations = null,
    ) {
        $this->text = $text;

        self::_introspect();
        $this->unsetOptionalProperties();

        null != $cacheControl && $this->cacheControl = $cacheControl;
        null != $citations && $this->citations = $citations;
    }
}
