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
    public ?CacheControlEphemeral $cacheControl;

    /**
     * You must use named parameters to construct this object. If an named argument is not
     * given, it will not be included during JSON serialization. The arguments are untyped
     * so you can pass any JSON serializable value, but the API expects the types to match
     * the PHPDoc types.
     *
     * @param list<
     *   WebSearchResultBlockParam
     * >|WebSearchToolRequestError $content `required`
     * @param string                $toolUseID    `required`
     * @param string                $type         `required`
     * @param CacheControlEphemeral $cacheControl
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
