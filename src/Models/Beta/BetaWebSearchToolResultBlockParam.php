<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta;

use Anthropic\Core\None;
use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Serde\UnionOf;
use Anthropic\Core\Serde\ListOf;

class BetaWebSearchToolResultBlockParam implements BaseModel
{
    use Model;

    /**
     * @var list<BetaWebSearchResultBlockParam>|BetaWebSearchToolRequestError $content
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
     * @param list<BetaWebSearchResultBlockParam>|BetaWebSearchToolRequestError $content
     * @param BetaCacheControlEphemeral                                         $cacheControl
     */
    final public function __construct(
        mixed $content,
        string $toolUseID,
        string $type,
        BetaCacheControlEphemeral|None $cacheControl = None::NOT_SET,
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

BetaWebSearchToolResultBlockParam::_loadMetadata();
