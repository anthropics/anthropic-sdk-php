<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Messages\RawContentBlockStartEvent\ContentBlock;

/**
 * @phpstan-type RawContentBlockStartEventShape = array{
 *   content_block: TextBlock|ThinkingBlock|RedactedThinkingBlock|ToolUseBlock|ServerToolUseBlock|WebSearchToolResultBlock,
 *   index: int,
 *   type: 'content_block_start',
 * }
 */
final class RawContentBlockStartEvent implements BaseModel
{
    /** @use SdkModel<RawContentBlockStartEventShape> */
    use SdkModel;

    /** @var 'content_block_start' $type */
    #[Required]
    public string $type = 'content_block_start';

    #[Required(
        union: ContentBlock::class
    )]
    public TextBlock|ThinkingBlock|RedactedThinkingBlock|ToolUseBlock|ServerToolUseBlock|WebSearchToolResultBlock $content_block;

    #[Required]
    public int $index;

    /**
     * `new RawContentBlockStartEvent()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * RawContentBlockStartEvent::with(content_block: ..., index: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new RawContentBlockStartEvent)->withContentBlock(...)->withIndex(...)
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
     * @param TextBlock|array{
     *   citations: list<CitationCharLocation|CitationPageLocation|CitationContentBlockLocation|CitationsWebSearchResultLocation|CitationsSearchResultLocation>|null,
     *   text: string,
     *   type: 'text',
     * }|ThinkingBlock|array{
     *   signature: string, thinking: string, type: 'thinking'
     * }|RedactedThinkingBlock|array{
     *   data: string, type: 'redacted_thinking'
     * }|ToolUseBlock|array{
     *   id: string, input: array<string,mixed>, name: string, type: 'tool_use'
     * }|ServerToolUseBlock|array{
     *   id: string,
     *   input: array<string,mixed>,
     *   name: 'web_search',
     *   type: 'server_tool_use',
     * }|WebSearchToolResultBlock|array{
     *   content: WebSearchToolResultError|list<WebSearchResultBlock>,
     *   tool_use_id: string,
     *   type: 'web_search_tool_result',
     * } $content_block
     */
    public static function with(
        TextBlock|array|ThinkingBlock|RedactedThinkingBlock|ToolUseBlock|ServerToolUseBlock|WebSearchToolResultBlock $content_block,
        int $index,
    ): self {
        $obj = new self;

        $obj['content_block'] = $content_block;
        $obj['index'] = $index;

        return $obj;
    }

    /**
     * @param TextBlock|array{
     *   citations: list<CitationCharLocation|CitationPageLocation|CitationContentBlockLocation|CitationsWebSearchResultLocation|CitationsSearchResultLocation>|null,
     *   text: string,
     *   type: 'text',
     * }|ThinkingBlock|array{
     *   signature: string, thinking: string, type: 'thinking'
     * }|RedactedThinkingBlock|array{
     *   data: string, type: 'redacted_thinking'
     * }|ToolUseBlock|array{
     *   id: string, input: array<string,mixed>, name: string, type: 'tool_use'
     * }|ServerToolUseBlock|array{
     *   id: string,
     *   input: array<string,mixed>,
     *   name: 'web_search',
     *   type: 'server_tool_use',
     * }|WebSearchToolResultBlock|array{
     *   content: WebSearchToolResultError|list<WebSearchResultBlock>,
     *   tool_use_id: string,
     *   type: 'web_search_tool_result',
     * } $contentBlock
     */
    public function withContentBlock(
        TextBlock|array|ThinkingBlock|RedactedThinkingBlock|ToolUseBlock|ServerToolUseBlock|WebSearchToolResultBlock $contentBlock,
    ): self {
        $obj = clone $this;
        $obj['content_block'] = $contentBlock;

        return $obj;
    }

    public function withIndex(int $index): self
    {
        $obj = clone $this;
        $obj['index'] = $index;

        return $obj;
    }
}
