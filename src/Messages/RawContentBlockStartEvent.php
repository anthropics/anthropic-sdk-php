<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Messages\RawContentBlockStartEvent\ContentBlock;

/**
 * @phpstan-type RawContentBlockStartEventShape = array{
 *   contentBlock: TextBlock|ThinkingBlock|RedactedThinkingBlock|ToolUseBlock|ServerToolUseBlock|WebSearchToolResultBlock,
 *   index: int,
 *   type?: 'content_block_start',
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
        'content_block',
        union: ContentBlock::class,
    )]
    public TextBlock|ThinkingBlock|RedactedThinkingBlock|ToolUseBlock|ServerToolUseBlock|WebSearchToolResultBlock $contentBlock;

    #[Required]
    public int $index;

    /**
     * `new RawContentBlockStartEvent()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * RawContentBlockStartEvent::with(contentBlock: ..., index: ...)
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
     *   type?: 'text',
     * }|ThinkingBlock|array{
     *   signature: string, thinking: string, type?: 'thinking'
     * }|RedactedThinkingBlock|array{
     *   data: string, type?: 'redacted_thinking'
     * }|ToolUseBlock|array{
     *   id: string, input: array<string,mixed>, name: string, type?: 'tool_use'
     * }|ServerToolUseBlock|array{
     *   id: string,
     *   input: array<string,mixed>,
     *   name?: 'web_search',
     *   type?: 'server_tool_use',
     * }|WebSearchToolResultBlock|array{
     *   content: WebSearchToolResultError|list<WebSearchResultBlock>,
     *   toolUseID: string,
     *   type?: 'web_search_tool_result',
     * } $contentBlock
     */
    public static function with(
        TextBlock|array|ThinkingBlock|RedactedThinkingBlock|ToolUseBlock|ServerToolUseBlock|WebSearchToolResultBlock $contentBlock,
        int $index,
    ): self {
        $self = new self;

        $self['contentBlock'] = $contentBlock;
        $self['index'] = $index;

        return $self;
    }

    /**
     * @param TextBlock|array{
     *   citations: list<CitationCharLocation|CitationPageLocation|CitationContentBlockLocation|CitationsWebSearchResultLocation|CitationsSearchResultLocation>|null,
     *   text: string,
     *   type?: 'text',
     * }|ThinkingBlock|array{
     *   signature: string, thinking: string, type?: 'thinking'
     * }|RedactedThinkingBlock|array{
     *   data: string, type?: 'redacted_thinking'
     * }|ToolUseBlock|array{
     *   id: string, input: array<string,mixed>, name: string, type?: 'tool_use'
     * }|ServerToolUseBlock|array{
     *   id: string,
     *   input: array<string,mixed>,
     *   name?: 'web_search',
     *   type?: 'server_tool_use',
     * }|WebSearchToolResultBlock|array{
     *   content: WebSearchToolResultError|list<WebSearchResultBlock>,
     *   toolUseID: string,
     *   type?: 'web_search_tool_result',
     * } $contentBlock
     */
    public function withContentBlock(
        TextBlock|array|ThinkingBlock|RedactedThinkingBlock|ToolUseBlock|ServerToolUseBlock|WebSearchToolResultBlock $contentBlock,
    ): self {
        $self = clone $this;
        $self['contentBlock'] = $contentBlock;

        return $self;
    }

    public function withIndex(int $index): self
    {
        $self = clone $this;
        $self['index'] = $index;

        return $self;
    }
}
