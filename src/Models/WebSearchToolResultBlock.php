<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Serde\ListOf;
use Anthropic\Core\Serde\UnionOf;

final class WebSearchToolResultBlock implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'web_search_tool_result';

    /** @var list<WebSearchResultBlock>|WebSearchToolResultError $content */
    #[Api(
        type: new UnionOf(
            [WebSearchToolResultError::class, new ListOf(WebSearchResultBlock::class)]
        ),
    )]
    public array|WebSearchToolResultError $content;

    #[Api('tool_use_id')]
    public string $toolUseID;

    /**
     * You must use named parameters to construct this object.
     *
     * @param list<WebSearchResultBlock>|WebSearchToolResultError $content
     */
    final public function __construct(
        array|WebSearchToolResultError $content,
        string $toolUseID
    ) {
        $this->content = $content;
        $this->toolUseID = $toolUseID;

        self::_introspect();
    }
}
