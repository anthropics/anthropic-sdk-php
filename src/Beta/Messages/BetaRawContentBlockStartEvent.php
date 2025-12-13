<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaRawContentBlockStartEvent\ContentBlock;
use Anthropic\Beta\Messages\BetaServerToolUseBlock\Name;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaRawContentBlockStartEventShape = array{
 *   contentBlock: BetaTextBlock|BetaThinkingBlock|BetaRedactedThinkingBlock|BetaToolUseBlock|BetaServerToolUseBlock|BetaWebSearchToolResultBlock|BetaWebFetchToolResultBlock|BetaCodeExecutionToolResultBlock|BetaBashCodeExecutionToolResultBlock|BetaTextEditorCodeExecutionToolResultBlock|BetaToolSearchToolResultBlock|BetaMCPToolUseBlock|BetaMCPToolResultBlock|BetaContainerUploadBlock,
 *   index: int,
 *   type?: 'content_block_start',
 * }
 */
final class BetaRawContentBlockStartEvent implements BaseModel
{
    /** @use SdkModel<BetaRawContentBlockStartEventShape> */
    use SdkModel;

    /** @var 'content_block_start' $type */
    #[Required]
    public string $type = 'content_block_start';

    /**
     * Response model for a file uploaded to the container.
     */
    #[Required('content_block', union: ContentBlock::class)]
    public BetaTextBlock|BetaThinkingBlock|BetaRedactedThinkingBlock|BetaToolUseBlock|BetaServerToolUseBlock|BetaWebSearchToolResultBlock|BetaWebFetchToolResultBlock|BetaCodeExecutionToolResultBlock|BetaBashCodeExecutionToolResultBlock|BetaTextEditorCodeExecutionToolResultBlock|BetaToolSearchToolResultBlock|BetaMCPToolUseBlock|BetaMCPToolResultBlock|BetaContainerUploadBlock $contentBlock;

    #[Required]
    public int $index;

    /**
     * `new BetaRawContentBlockStartEvent()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaRawContentBlockStartEvent::with(contentBlock: ..., index: ...)
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
     *   type?: 'text',
     * }|BetaThinkingBlock|array{
     *   signature: string, thinking: string, type?: 'thinking'
     * }|BetaRedactedThinkingBlock|array{
     *   data: string, type?: 'redacted_thinking'
     * }|BetaToolUseBlock|array{
     *   id: string,
     *   input: array<string,mixed>,
     *   name: string,
     *   type?: 'tool_use',
     *   caller?: BetaDirectCaller|BetaServerToolCaller|null,
     * }|BetaServerToolUseBlock|array{
     *   id: string,
     *   caller: BetaDirectCaller|BetaServerToolCaller,
     *   input: array<string,mixed>,
     *   name: value-of<Name>,
     *   type?: 'server_tool_use',
     * }|BetaWebSearchToolResultBlock|array{
     *   content: BetaWebSearchToolResultError|list<BetaWebSearchResultBlock>,
     *   toolUseID: string,
     *   type?: 'web_search_tool_result',
     * }|BetaWebFetchToolResultBlock|array{
     *   content: BetaWebFetchToolResultErrorBlock|BetaWebFetchBlock,
     *   toolUseID: string,
     *   type?: 'web_fetch_tool_result',
     * }|BetaCodeExecutionToolResultBlock|array{
     *   content: BetaCodeExecutionToolResultError|BetaCodeExecutionResultBlock,
     *   toolUseID: string,
     *   type?: 'code_execution_tool_result',
     * }|BetaBashCodeExecutionToolResultBlock|array{
     *   content: BetaBashCodeExecutionToolResultError|BetaBashCodeExecutionResultBlock,
     *   toolUseID: string,
     *   type?: 'bash_code_execution_tool_result',
     * }|BetaTextEditorCodeExecutionToolResultBlock|array{
     *   content: BetaTextEditorCodeExecutionToolResultError|BetaTextEditorCodeExecutionViewResultBlock|BetaTextEditorCodeExecutionCreateResultBlock|BetaTextEditorCodeExecutionStrReplaceResultBlock,
     *   toolUseID: string,
     *   type?: 'text_editor_code_execution_tool_result',
     * }|BetaToolSearchToolResultBlock|array{
     *   content: BetaToolSearchToolResultError|BetaToolSearchToolSearchResultBlock,
     *   toolUseID: string,
     *   type?: 'tool_search_tool_result',
     * }|BetaMCPToolUseBlock|array{
     *   id: string,
     *   input: array<string,mixed>,
     *   name: string,
     *   serverName: string,
     *   type?: 'mcp_tool_use',
     * }|BetaMCPToolResultBlock|array{
     *   content: string|list<BetaTextBlock>,
     *   isError: bool,
     *   toolUseID: string,
     *   type?: 'mcp_tool_result',
     * }|BetaContainerUploadBlock|array{
     *   fileID: string, type?: 'container_upload'
     * } $contentBlock
     */
    public static function with(
        BetaTextBlock|array|BetaThinkingBlock|BetaRedactedThinkingBlock|BetaToolUseBlock|BetaServerToolUseBlock|BetaWebSearchToolResultBlock|BetaWebFetchToolResultBlock|BetaCodeExecutionToolResultBlock|BetaBashCodeExecutionToolResultBlock|BetaTextEditorCodeExecutionToolResultBlock|BetaToolSearchToolResultBlock|BetaMCPToolUseBlock|BetaMCPToolResultBlock|BetaContainerUploadBlock $contentBlock,
        int $index,
    ): self {
        $self = new self;

        $self['contentBlock'] = $contentBlock;
        $self['index'] = $index;

        return $self;
    }

    /**
     * Response model for a file uploaded to the container.
     *
     * @param BetaTextBlock|array{
     *   citations: list<BetaCitationCharLocation|BetaCitationPageLocation|BetaCitationContentBlockLocation|BetaCitationsWebSearchResultLocation|BetaCitationSearchResultLocation>|null,
     *   text: string,
     *   type?: 'text',
     * }|BetaThinkingBlock|array{
     *   signature: string, thinking: string, type?: 'thinking'
     * }|BetaRedactedThinkingBlock|array{
     *   data: string, type?: 'redacted_thinking'
     * }|BetaToolUseBlock|array{
     *   id: string,
     *   input: array<string,mixed>,
     *   name: string,
     *   type?: 'tool_use',
     *   caller?: BetaDirectCaller|BetaServerToolCaller|null,
     * }|BetaServerToolUseBlock|array{
     *   id: string,
     *   caller: BetaDirectCaller|BetaServerToolCaller,
     *   input: array<string,mixed>,
     *   name: value-of<Name>,
     *   type?: 'server_tool_use',
     * }|BetaWebSearchToolResultBlock|array{
     *   content: BetaWebSearchToolResultError|list<BetaWebSearchResultBlock>,
     *   toolUseID: string,
     *   type?: 'web_search_tool_result',
     * }|BetaWebFetchToolResultBlock|array{
     *   content: BetaWebFetchToolResultErrorBlock|BetaWebFetchBlock,
     *   toolUseID: string,
     *   type?: 'web_fetch_tool_result',
     * }|BetaCodeExecutionToolResultBlock|array{
     *   content: BetaCodeExecutionToolResultError|BetaCodeExecutionResultBlock,
     *   toolUseID: string,
     *   type?: 'code_execution_tool_result',
     * }|BetaBashCodeExecutionToolResultBlock|array{
     *   content: BetaBashCodeExecutionToolResultError|BetaBashCodeExecutionResultBlock,
     *   toolUseID: string,
     *   type?: 'bash_code_execution_tool_result',
     * }|BetaTextEditorCodeExecutionToolResultBlock|array{
     *   content: BetaTextEditorCodeExecutionToolResultError|BetaTextEditorCodeExecutionViewResultBlock|BetaTextEditorCodeExecutionCreateResultBlock|BetaTextEditorCodeExecutionStrReplaceResultBlock,
     *   toolUseID: string,
     *   type?: 'text_editor_code_execution_tool_result',
     * }|BetaToolSearchToolResultBlock|array{
     *   content: BetaToolSearchToolResultError|BetaToolSearchToolSearchResultBlock,
     *   toolUseID: string,
     *   type?: 'tool_search_tool_result',
     * }|BetaMCPToolUseBlock|array{
     *   id: string,
     *   input: array<string,mixed>,
     *   name: string,
     *   serverName: string,
     *   type?: 'mcp_tool_use',
     * }|BetaMCPToolResultBlock|array{
     *   content: string|list<BetaTextBlock>,
     *   isError: bool,
     *   toolUseID: string,
     *   type?: 'mcp_tool_result',
     * }|BetaContainerUploadBlock|array{
     *   fileID: string, type?: 'container_upload'
     * } $contentBlock
     */
    public function withContentBlock(
        BetaTextBlock|array|BetaThinkingBlock|BetaRedactedThinkingBlock|BetaToolUseBlock|BetaServerToolUseBlock|BetaWebSearchToolResultBlock|BetaWebFetchToolResultBlock|BetaCodeExecutionToolResultBlock|BetaBashCodeExecutionToolResultBlock|BetaTextEditorCodeExecutionToolResultBlock|BetaToolSearchToolResultBlock|BetaMCPToolUseBlock|BetaMCPToolResultBlock|BetaContainerUploadBlock $contentBlock,
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
