<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\None;
use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Serde\UnionOf;
use Anthropic\Core\Serde\ListOf;

class WebSearchToolResultBlockParam implements BaseModel
{
    use Model;

    /**
     * @var list<WebSearchResultBlockParam>|WebSearchToolRequestError $content
     */
    #[Api(
        type: new UnionOf(
            [
                new ListOf(WebSearchResultBlockParam::class),
                WebSearchToolRequestError::class,
            ],
        ),
    )]
    public mixed $content;

    #[Api('tool_use_id')]
    public string $toolUseID;

    #[Api]
    public string $type;

    #[Api('cache_control', optional: true)]
    public CacheControlEphemeral $cacheControl;

    /**
     * @param list<WebSearchResultBlockParam>|WebSearchToolRequestError $content
     * @param CacheControlEphemeral                                     $cacheControl
     */
    final public function __construct(
        mixed $content,
        string $toolUseID,
        string $type,
        CacheControlEphemeral|None $cacheControl = None::NOT_SET,
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

WebSearchToolResultBlockParam::_loadMetadata();
