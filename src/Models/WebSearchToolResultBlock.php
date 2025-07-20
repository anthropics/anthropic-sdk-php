<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type web_search_tool_result_block_alias = array{
 *   content: WebSearchToolResultError|list<WebSearchResultBlock>,
 *   toolUseID: string,
 *   type: string,
 * }
 */
final class WebSearchToolResultBlock implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'web_search_tool_result';

    /** @var list<WebSearchResultBlock>|WebSearchToolResultError $content */
    #[Api(union: WebSearchToolResultBlockContent::class)]
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
        self::introspect();

        $this->content = $content;
        $this->toolUseID = $toolUseID;
    }
}
