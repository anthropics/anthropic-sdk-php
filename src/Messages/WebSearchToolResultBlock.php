<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Messages\WebSearchToolResultError\ErrorCode;

/**
 * @phpstan-type WebSearchToolResultBlockShape = array{
 *   content: WebSearchToolResultError|list<WebSearchResultBlock>,
 *   tool_use_id: string,
 *   type: 'web_search_tool_result',
 * }
 */
final class WebSearchToolResultBlock implements BaseModel
{
    /** @use SdkModel<WebSearchToolResultBlockShape> */
    use SdkModel;

    /** @var 'web_search_tool_result' $type */
    #[Required]
    public string $type = 'web_search_tool_result';

    /** @var WebSearchToolResultError|list<WebSearchResultBlock> $content */
    #[Required(union: WebSearchToolResultBlockContent::class)]
    public WebSearchToolResultError|array $content;

    #[Required]
    public string $tool_use_id;

    /**
     * `new WebSearchToolResultBlock()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * WebSearchToolResultBlock::with(content: ..., tool_use_id: ...)
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
     * @param WebSearchToolResultError|array{
     *   error_code: value-of<ErrorCode>, type: 'web_search_tool_result_error'
     * }|list<WebSearchResultBlock|array{
     *   encrypted_content: string,
     *   page_age: string|null,
     *   title: string,
     *   type: 'web_search_result',
     *   url: string,
     * }> $content
     */
    public static function with(
        WebSearchToolResultError|array $content,
        string $tool_use_id
    ): self {
        $obj = new self;

        $obj['content'] = $content;
        $obj['tool_use_id'] = $tool_use_id;

        return $obj;
    }

    /**
     * @param WebSearchToolResultError|array{
     *   error_code: value-of<ErrorCode>, type: 'web_search_tool_result_error'
     * }|list<WebSearchResultBlock|array{
     *   encrypted_content: string,
     *   page_age: string|null,
     *   title: string,
     *   type: 'web_search_result',
     *   url: string,
     * }> $content
     */
    public function withContent(WebSearchToolResultError|array $content): self
    {
        $obj = clone $this;
        $obj['content'] = $content;

        return $obj;
    }

    public function withToolUseID(string $toolUseID): self
    {
        $obj = clone $this;
        $obj['tool_use_id'] = $toolUseID;

        return $obj;
    }
}
