<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaRawContentBlockStartEvent\ContentBlock;
use Anthropic\Beta\Messages\BetaServerToolUseBlock\Name;
use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaRawContentBlockStartEventShape = array{
 *   content_block: BetaTextBlock|BetaThinkingBlock|BetaRedactedThinkingBlock|BetaToolUseBlock|BetaServerToolUseBlock|BetaWebSearchToolResultBlock|BetaWebFetchToolResultBlock|BetaCodeExecutionToolResultBlock|BetaBashCodeExecutionToolResultBlock|BetaTextEditorCodeExecutionToolResultBlock|BetaToolSearchToolResultBlock|BetaMCPToolUseBlock|BetaMCPToolResultBlock|BetaContainerUploadBlock,
 *   index: int,
 *   type: 'content_block_start',
 * }
 */
final class BetaRawContentBlockStartEvent implements BaseModel
{
    /** @use SdkModel<BetaRawContentBlockStartEventShape> */
    use SdkModel;

    /** @var 'content_block_start' $type */
    #[Api]
    public string $type = 'content_block_start';

    /**
     * Response model for a file uploaded to the container.
     */
    #[Api(union: ContentBlock::class)]
    public BetaTextBlock|BetaThinkingBlock|BetaRedactedThinkingBlock|BetaToolUseBlock|BetaServerToolUseBlock|BetaWebSearchToolResultBlock|BetaWebFetchToolResultBlock|BetaCodeExecutionToolResultBlock|BetaBashCodeExecutionToolResultBlock|BetaTextEditorCodeExecutionToolResultBlock|BetaToolSearchToolResultBlock|BetaMCPToolUseBlock|BetaMCPToolResultBlock|BetaContainerUploadBlock $content_block;

    #[Api]
    public int $index;

    /**
     * `new BetaRawContentBlockStartEvent()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaRawContentBlockStartEvent::with(content_block: ..., index: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaRawContentBlockStartEvent)->withContentBlock(...)->withIndex(...)
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
     * @param BetaTextBlock|array{
     *   citations: list<BetaCitationCharLocation|BetaCitationPageLocation|BetaCitationContentBlockLocation|BetaCitationsWebSearchResultLocation|BetaCitationSearchResultLocation>|null,
     *   text: string,
     *   type: 'text',
     * }|BetaThinkingBlock|array{
     *   signature: string, thinking: string, type: 'thinking'
     * }|BetaRedactedThinkingBlock|array{
     *   data: string, type: 'redacted_thinking'
     * }|BetaToolUseBlock|array{
     *   id: string,
     *   input: array<string,mixed>,
     *   name: string,
     *   type: 'tool_use',
     *   caller?: BetaDirectCaller|BetaServerToolCaller|null,
     * }|BetaServerToolUseBlock|array{
     *   id: string,
     *   caller: BetaDirectCaller|BetaServerToolCaller,
     *   input: array<string,mixed>,
     *   name: value-of<Name>,
     *   type: 'server_tool_use',
     * }|BetaWebSearchToolResultBlock|array{
     *   content: BetaWebSearchToolResultError|list<BetaWebSearchResultBlock>,
     *   tool_use_id: string,
     *   type: 'web_search_tool_result',
     * }|BetaWebFetchToolResultBlock|array{
     *   content: BetaWebFetchToolResultErrorBlock|BetaWebFetchBlock,
     *   tool_use_id: string,
     *   type: 'web_fetch_tool_result',
     * }|BetaCodeExecutionToolResultBlock|array{
     *   content: BetaCodeExecutionToolResultError|BetaCodeExecutionResultBlock,
     *   tool_use_id: string,
     *   type: 'code_execution_tool_result',
     * }|BetaBashCodeExecutionToolResultBlock|array{
     *   content: BetaBashCodeExecutionToolResultError|BetaBashCodeExecutionResultBlock,
     *   tool_use_id: string,
     *   type: 'bash_code_execution_tool_result',
     * }|BetaTextEditorCodeExecutionToolResultBlock|array{
     *   content: BetaTextEditorCodeExecutionToolResultError|BetaTextEditorCodeExecutionViewResultBlock|BetaTextEditorCodeExecutionCreateResultBlock|BetaTextEditorCodeExecutionStrReplaceResultBlock,
     *   tool_use_id: string,
     *   type: 'text_editor_code_execution_tool_result',
     * }|BetaToolSearchToolResultBlock|array{
     *   content: BetaToolSearchToolResultError|BetaToolSearchToolSearchResultBlock,
     *   tool_use_id: string,
     *   type: 'tool_search_tool_result',
     * }|BetaMCPToolUseBlock|array{
     *   id: string,
     *   input: array<string,mixed>,
     *   name: string,
     *   server_name: string,
     *   type: 'mcp_tool_use',
     * }|BetaMCPToolResultBlock|array{
     *   content: string|list<BetaTextBlock>,
     *   is_error: bool,
     *   tool_use_id: string,
     *   type: 'mcp_tool_result',
     * }|BetaContainerUploadBlock|array{
     *   file_id: string, type: 'container_upload'
     * } $content_block
     */
    public static function with(
        BetaTextBlock|array|BetaThinkingBlock|BetaRedactedThinkingBlock|BetaToolUseBlock|BetaServerToolUseBlock|BetaWebSearchToolResultBlock|BetaWebFetchToolResultBlock|BetaCodeExecutionToolResultBlock|BetaBashCodeExecutionToolResultBlock|BetaTextEditorCodeExecutionToolResultBlock|BetaToolSearchToolResultBlock|BetaMCPToolUseBlock|BetaMCPToolResultBlock|BetaContainerUploadBlock $content_block,
        int $index,
    ): self {
        $obj = new self;

        $obj['content_block'] = $content_block;
        $obj['index'] = $index;

        return $obj;
    }

    /**
     * Response model for a file uploaded to the container.
     *
     * @param BetaTextBlock|array{
     *   citations: list<BetaCitationCharLocation|BetaCitationPageLocation|BetaCitationContentBlockLocation|BetaCitationsWebSearchResultLocation|BetaCitationSearchResultLocation>|null,
     *   text: string,
     *   type: 'text',
     * }|BetaThinkingBlock|array{
     *   signature: string, thinking: string, type: 'thinking'
     * }|BetaRedactedThinkingBlock|array{
     *   data: string, type: 'redacted_thinking'
     * }|BetaToolUseBlock|array{
     *   id: string,
     *   input: array<string,mixed>,
     *   name: string,
     *   type: 'tool_use',
     *   caller?: BetaDirectCaller|BetaServerToolCaller|null,
     * }|BetaServerToolUseBlock|array{
     *   id: string,
     *   caller: BetaDirectCaller|BetaServerToolCaller,
     *   input: array<string,mixed>,
     *   name: value-of<Name>,
     *   type: 'server_tool_use',
     * }|BetaWebSearchToolResultBlock|array{
     *   content: BetaWebSearchToolResultError|list<BetaWebSearchResultBlock>,
     *   tool_use_id: string,
     *   type: 'web_search_tool_result',
     * }|BetaWebFetchToolResultBlock|array{
     *   content: BetaWebFetchToolResultErrorBlock|BetaWebFetchBlock,
     *   tool_use_id: string,
     *   type: 'web_fetch_tool_result',
     * }|BetaCodeExecutionToolResultBlock|array{
     *   content: BetaCodeExecutionToolResultError|BetaCodeExecutionResultBlock,
     *   tool_use_id: string,
     *   type: 'code_execution_tool_result',
     * }|BetaBashCodeExecutionToolResultBlock|array{
     *   content: BetaBashCodeExecutionToolResultError|BetaBashCodeExecutionResultBlock,
     *   tool_use_id: string,
     *   type: 'bash_code_execution_tool_result',
     * }|BetaTextEditorCodeExecutionToolResultBlock|array{
     *   content: BetaTextEditorCodeExecutionToolResultError|BetaTextEditorCodeExecutionViewResultBlock|BetaTextEditorCodeExecutionCreateResultBlock|BetaTextEditorCodeExecutionStrReplaceResultBlock,
     *   tool_use_id: string,
     *   type: 'text_editor_code_execution_tool_result',
     * }|BetaToolSearchToolResultBlock|array{
     *   content: BetaToolSearchToolResultError|BetaToolSearchToolSearchResultBlock,
     *   tool_use_id: string,
     *   type: 'tool_search_tool_result',
     * }|BetaMCPToolUseBlock|array{
     *   id: string,
     *   input: array<string,mixed>,
     *   name: string,
     *   server_name: string,
     *   type: 'mcp_tool_use',
     * }|BetaMCPToolResultBlock|array{
     *   content: string|list<BetaTextBlock>,
     *   is_error: bool,
     *   tool_use_id: string,
     *   type: 'mcp_tool_result',
     * }|BetaContainerUploadBlock|array{
     *   file_id: string, type: 'container_upload'
     * } $contentBlock
     */
    public function withContentBlock(
        BetaTextBlock|array|BetaThinkingBlock|BetaRedactedThinkingBlock|BetaToolUseBlock|BetaServerToolUseBlock|BetaWebSearchToolResultBlock|BetaWebFetchToolResultBlock|BetaCodeExecutionToolResultBlock|BetaBashCodeExecutionToolResultBlock|BetaTextEditorCodeExecutionToolResultBlock|BetaToolSearchToolResultBlock|BetaMCPToolUseBlock|BetaMCPToolResultBlock|BetaContainerUploadBlock $contentBlock,
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
