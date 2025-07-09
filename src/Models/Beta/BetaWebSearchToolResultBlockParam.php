<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\None;
use Anthropic\Core\Serde\ListOf;
use Anthropic\Core\Serde\UnionOf;

class BetaWebSearchToolResultBlockParam implements BaseModel
{
    use Model;

    /**
     * @var BetaWebSearchToolRequestError|list<BetaWebSearchResultBlockParam> $content
     */
    #[Api(
        type: new UnionOf(
            [
                new ListOf(BetaWebSearchResultBlockParam::class),
                BetaWebSearchToolRequestError::class,
            ],
        ),
    )]
    public mixed $content;

    #[Api('tool_use_id')]
    public string $toolUseID;

    #[Api]
    public string $type;

    #[Api('cache_control', optional: true)]
    public BetaCacheControlEphemeral $cacheControl;

    /**
     * @param BetaWebSearchToolRequestError|list<BetaWebSearchResultBlockParam> $content
     * @param string                                                            $toolUseID
     * @param string                                                            $type
     * @param BetaCacheControlEphemeral                                         $cacheControl
     */
    final public function __construct(
        $content,
        $toolUseID,
        $type,
        $cacheControl = None::NOT_GIVEN
    ) {
        $this->constructFromArgs(func_get_args());
    }
}

BetaWebSearchToolResultBlockParam::_loadMetadata();
