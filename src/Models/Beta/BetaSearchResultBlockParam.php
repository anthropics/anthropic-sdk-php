<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\None;
use Anthropic\Core\Serde\ListOf;

class BetaSearchResultBlockParam implements BaseModel
{
    use Model;

    /** @var list<BetaTextBlockParam> $content */
    #[Api(type: new ListOf(BetaTextBlockParam::class))]
    public array $content;

    #[Api]
    public string $source;

    #[Api]
    public string $title;

    #[Api]
    public string $type;

    #[Api('cache_control', optional: true)]
    public BetaCacheControlEphemeral $cacheControl;

    #[Api(optional: true)]
    public BetaCitationsConfigParam $citations;

    /**
     * @param list<BetaTextBlockParam>  $content
     * @param string                    $source
     * @param string                    $title
     * @param string                    $type
     * @param BetaCacheControlEphemeral $cacheControl
     * @param BetaCitationsConfigParam  $citations
     */
    final public function __construct(
        $content,
        $source,
        $title,
        $type,
        $cacheControl = None::NOT_GIVEN,
        $citations = None::NOT_GIVEN,
    ) {
        $this->constructFromArgs(func_get_args());
    }
}

BetaSearchResultBlockParam::_loadMetadata();
