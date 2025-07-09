<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\None;
use Anthropic\Core\Serde\ListOf;
use Anthropic\Core\Serde\UnionOf;

class WebSearchToolResultBlockParam implements BaseModel
{
    use Model;

    /** @var list<WebSearchResultBlockParam>|WebSearchToolRequestError $content */
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
     * @param string                                                    $toolUseID
     * @param string                                                    $type
     * @param CacheControlEphemeral                                     $cacheControl
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

WebSearchToolResultBlockParam::_loadMetadata();
