<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Serde\ListOf;
use Anthropic\Core\Serde\UnionOf;

class WebSearchToolResultBlock implements BaseModel
{
    use Model;

    /** @var list<WebSearchResultBlock>|WebSearchToolResultError $content */
    #[Api(
        type: new UnionOf(
            [WebSearchToolResultError::class, new ListOf(WebSearchResultBlock::class)]
        ),
    )]
    public mixed $content;

    #[Api('tool_use_id')]
    public string $toolUseID;

    #[Api]
    public string $type;

    /**
     * You must use named parameters to construct this object. If an named argument is not
     * given, it will not be included during JSON serialization. The arguments are untyped
     * so you can pass any JSON serializable value, but the API expects the types to match
     * the PHPDoc types.
     *
     * @param list<WebSearchResultBlock>|WebSearchToolResultError $content   `required`
     * @param string                                              $toolUseID `required`
     * @param string                                              $type      `required`
     */
    final public function __construct($content, $toolUseID, $type)
    {
        $this->constructFromArgs(func_get_args());
    }
}

WebSearchToolResultBlock::_loadMetadata();
