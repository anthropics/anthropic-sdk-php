<?php

declare(strict_types=1);

namespace Anthropic\Models;

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
    public static function new(
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
    public function setContent(array|WebSearchToolResultError $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function setToolUseID(string $toolUseID): self
    {
        $this->toolUseID = $toolUseID;

        return $this;
    }
}
