<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model as ModelTrait;
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
    use ModelTrait;

    #[Api]
    public string $type = 'web_search_tool_result';

    /** @var list<WebSearchResultBlock>|WebSearchToolResultError $content */
    #[Api(union: WebSearchToolResultBlockContent::class)]
    public array|WebSearchToolResultError $content;

    #[Api('tool_use_id')]
    public string $toolUseID;

    /**
     * `new WebSearchToolResultBlock()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * WebSearchToolResultBlock::with(content: ..., toolUseID: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new WebSearchToolResultBlock)->withContent(...)->withToolUseID(...)
     * ```
     */
    public function __construct()
    {
        self::introspect();
        $this->unsetOptionalProperties();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param list<WebSearchResultBlock>|WebSearchToolResultError $content
     */
    public static function with(
        array|WebSearchToolResultError $content,
        string $toolUseID
    ): self {
        $obj = new self;

        $obj->content = $content;
        $obj->toolUseID = $toolUseID;

        return $obj;
    }

    /**
     * @param list<WebSearchResultBlock>|WebSearchToolResultError $content
     */
    public function withContent(array|WebSearchToolResultError $content): self
    {
        $obj = clone $this;
        $obj->content = $content;

        return $obj;
    }

    public function withToolUseID(string $toolUseID): self
    {
        $obj = clone $this;
        $obj->toolUseID = $toolUseID;

        return $obj;
    }
}
