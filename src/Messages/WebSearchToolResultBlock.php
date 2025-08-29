<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type web_search_tool_result_block = array{
 *   content: WebSearchToolResultError|list<WebSearchResultBlock>,
 *   toolUseID: string,
 *   type: string,
 * }
 */
final class WebSearchToolResultBlock implements BaseModel
{
    /** @use SdkModel<web_search_tool_result_block> */
    use SdkModel;

    #[Api]
    public string $type = 'web_search_tool_result';

    /** @var WebSearchToolResultError|list<WebSearchResultBlock> $content */
    #[Api(union: WebSearchToolResultBlockContent::class)]
    public WebSearchToolResultError|array $content;

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
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param WebSearchToolResultError|list<WebSearchResultBlock> $content
     */
    public static function with(
        WebSearchToolResultError|array $content,
        string $toolUseID
    ): self {
        $obj = new self;

        $obj->content = $content;
        $obj->toolUseID = $toolUseID;

        return $obj;
    }

    /**
     * @param WebSearchToolResultError|list<WebSearchResultBlock> $content
     */
    public function withContent(WebSearchToolResultError|array $content): self
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
