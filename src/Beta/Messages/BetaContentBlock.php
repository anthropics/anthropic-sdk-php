<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaContentBlock\Type;
use Anthropic\Beta\Messages\BetaServerToolUseBlock\Name;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-import-type BetaTextBlockShape from \Anthropic\Beta\Messages\BetaTextBlock
 * @phpstan-import-type BetaThinkingBlockShape from \Anthropic\Beta\Messages\BetaThinkingBlock
 * @phpstan-import-type BetaRedactedThinkingBlockShape from \Anthropic\Beta\Messages\BetaRedactedThinkingBlock
 * @phpstan-import-type BetaToolUseBlockShape from \Anthropic\Beta\Messages\BetaToolUseBlock
 * @phpstan-import-type BetaServerToolUseBlockShape from \Anthropic\Beta\Messages\BetaServerToolUseBlock
 * @phpstan-import-type BetaWebSearchToolResultBlockShape from \Anthropic\Beta\Messages\BetaWebSearchToolResultBlock
 * @phpstan-import-type BetaWebFetchToolResultBlockShape from \Anthropic\Beta\Messages\BetaWebFetchToolResultBlock
 * @phpstan-import-type BetaAdvisorToolResultBlockShape from \Anthropic\Beta\Messages\BetaAdvisorToolResultBlock
 * @phpstan-import-type BetaCodeExecutionToolResultBlockShape from \Anthropic\Beta\Messages\BetaCodeExecutionToolResultBlock
 * @phpstan-import-type BetaBashCodeExecutionToolResultBlockShape from \Anthropic\Beta\Messages\BetaBashCodeExecutionToolResultBlock
 * @phpstan-import-type BetaTextEditorCodeExecutionToolResultBlockShape from \Anthropic\Beta\Messages\BetaTextEditorCodeExecutionToolResultBlock
 * @phpstan-import-type BetaToolSearchToolResultBlockShape from \Anthropic\Beta\Messages\BetaToolSearchToolResultBlock
 * @phpstan-import-type BetaMCPToolUseBlockShape from \Anthropic\Beta\Messages\BetaMCPToolUseBlock
 * @phpstan-import-type BetaMCPToolResultBlockShape from \Anthropic\Beta\Messages\BetaMCPToolResultBlock
 * @phpstan-import-type BetaContainerUploadBlockShape from \Anthropic\Beta\Messages\BetaContainerUploadBlock
 * @phpstan-import-type BetaCompactionBlockShape from \Anthropic\Beta\Messages\BetaCompactionBlock
 * @phpstan-import-type BetaFallbackBlockShape from \Anthropic\Beta\Messages\BetaFallbackBlock
 * @phpstan-import-type BetaMCPToolListingBlockShape from \Anthropic\Beta\Messages\BetaMCPToolListingBlock
 * @phpstan-import-type BetaTextCitationShape from \Anthropic\Beta\Messages\BetaTextCitation
 * @phpstan-import-type CallerShape from \Anthropic\Beta\Messages\BetaToolUseBlock\Caller
 * @phpstan-import-type CallerShape from \Anthropic\Beta\Messages\BetaServerToolUseBlock\Caller as CallerShape1
 * @phpstan-import-type CallerShape from \Anthropic\Beta\Messages\BetaWebSearchToolResultBlock\Caller as CallerShape2
 * @phpstan-import-type CallerShape from \Anthropic\Beta\Messages\BetaWebFetchToolResultBlock\Caller as CallerShape3
 * @phpstan-import-type BetaWebSearchToolResultBlockContentShape from \Anthropic\Beta\Messages\BetaWebSearchToolResultBlockContent
 * @phpstan-import-type ContentShape from \Anthropic\Beta\Messages\BetaWebFetchToolResultBlock\Content
 * @phpstan-import-type ContentShape from \Anthropic\Beta\Messages\BetaAdvisorToolResultBlock\Content as ContentShape1
 * @phpstan-import-type BetaCodeExecutionToolResultBlockContentShape from \Anthropic\Beta\Messages\BetaCodeExecutionToolResultBlockContent
 * @phpstan-import-type ContentShape from \Anthropic\Beta\Messages\BetaBashCodeExecutionToolResultBlock\Content as ContentShape2
 * @phpstan-import-type ContentShape from \Anthropic\Beta\Messages\BetaTextEditorCodeExecutionToolResultBlock\Content as ContentShape3
 * @phpstan-import-type ContentShape from \Anthropic\Beta\Messages\BetaToolSearchToolResultBlock\Content as ContentShape4
 * @phpstan-import-type ContentShape from \Anthropic\Beta\Messages\BetaMCPToolResultBlock\Content as ContentShape5
 * @phpstan-import-type ToolChangeShape from \Anthropic\Beta\Messages\BetaCompactionBlock\ToolChange
 * @phpstan-import-type BetaFallbackRefusalTriggerShape from \Anthropic\Beta\Messages\BetaFallbackRefusalTrigger
 * @phpstan-import-type BetaMCPToolShape from \Anthropic\Beta\Messages\BetaMCPTool
 * @phpstan-import-type BetaFallbackInfoShape from \Anthropic\Beta\Messages\BetaFallbackInfo
 *
 * @phpstan-type BetaContentBlockVariants = BetaTextBlock|BetaThinkingBlock|BetaRedactedThinkingBlock|BetaToolUseBlock|BetaServerToolUseBlock|BetaWebSearchToolResultBlock|BetaWebFetchToolResultBlock|BetaAdvisorToolResultBlock|BetaCodeExecutionToolResultBlock|BetaBashCodeExecutionToolResultBlock|BetaTextEditorCodeExecutionToolResultBlock|BetaToolSearchToolResultBlock|BetaMCPToolUseBlock|BetaMCPToolResultBlock|BetaContainerUploadBlock|BetaCompactionBlock|BetaFallbackBlock|BetaMCPToolListingBlock
 * @phpstan-type BetaContentBlockShape = BetaContentBlockVariants|BetaTextBlockShape|BetaThinkingBlockShape|BetaRedactedThinkingBlockShape|BetaToolUseBlockShape|BetaServerToolUseBlockShape|BetaWebSearchToolResultBlockShape|BetaWebFetchToolResultBlockShape|BetaAdvisorToolResultBlockShape|BetaCodeExecutionToolResultBlockShape|BetaBashCodeExecutionToolResultBlockShape|BetaTextEditorCodeExecutionToolResultBlockShape|BetaToolSearchToolResultBlockShape|BetaMCPToolUseBlockShape|BetaMCPToolResultBlockShape|BetaContainerUploadBlockShape|BetaCompactionBlockShape|BetaFallbackBlockShape|BetaMCPToolListingBlockShape
 */
final class BetaContentBlock implements ConverterSource
{
    use SdkUnion;

    public static function discriminator(): string
    {
        return 'type';
    }

    /**
     * @return list<string|Converter|ConverterSource>|array<string,string|Converter|ConverterSource>
     */
    public static function variants(): array
    {
        return [
            'text' => BetaTextBlock::class,
            'thinking' => BetaThinkingBlock::class,
            'redacted_thinking' => BetaRedactedThinkingBlock::class,
            'tool_use' => BetaToolUseBlock::class,
            'server_tool_use' => BetaServerToolUseBlock::class,
            'web_search_tool_result' => BetaWebSearchToolResultBlock::class,
            'web_fetch_tool_result' => BetaWebFetchToolResultBlock::class,
            'advisor_tool_result' => BetaAdvisorToolResultBlock::class,
            'code_execution_tool_result' => BetaCodeExecutionToolResultBlock::class,
            'bash_code_execution_tool_result' => BetaBashCodeExecutionToolResultBlock::class,
            'text_editor_code_execution_tool_result' => BetaTextEditorCodeExecutionToolResultBlock::class,
            'tool_search_tool_result' => BetaToolSearchToolResultBlock::class,
            'mcp_tool_use' => BetaMCPToolUseBlock::class,
            'mcp_tool_result' => BetaMCPToolResultBlock::class,
            'container_upload' => BetaContainerUploadBlock::class,
            'compaction' => BetaCompactionBlock::class,
            'fallback' => BetaFallbackBlock::class,
            'mcp_tool_listing' => BetaMCPToolListingBlock::class,
        ];
    }

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @param list<BetaTextCitationShape>|null $citations
     * @param array<string,mixed>|null $input
     * @param ($type is Type::TOOL_USE|'tool_use'|Type::MCP_TOOL_USE|'mcp_tool_use' ? string|null : Name|value-of<Name>|null) $name
     * @param ($type is Type::TOOL_USE|'tool_use' ? CallerShape|null : ($type is Type::SERVER_TOOL_USE|'server_tool_use' ? CallerShape1|null : ($type is Type::WEB_SEARCH_TOOL_RESULT|'web_search_tool_result' ? CallerShape2|null : CallerShape3|null))) $caller
     * @param ($type is Type::WEB_SEARCH_TOOL_RESULT|'web_search_tool_result' ? BetaWebSearchToolResultBlockContentShape|null : ($type is Type::WEB_FETCH_TOOL_RESULT|'web_fetch_tool_result' ? ContentShape|null : ($type is Type::ADVISOR_TOOL_RESULT|'advisor_tool_result' ? ContentShape1|null : ($type is Type::CODE_EXECUTION_TOOL_RESULT|'code_execution_tool_result' ? BetaCodeExecutionToolResultBlockContentShape|null : ($type is Type::BASH_CODE_EXECUTION_TOOL_RESULT|'bash_code_execution_tool_result' ? ContentShape2|null : ($type is Type::TEXT_EDITOR_CODE_EXECUTION_TOOL_RESULT|'text_editor_code_execution_tool_result' ? ContentShape3|null : ($type is Type::TOOL_SEARCH_TOOL_RESULT|'tool_search_tool_result' ? ContentShape4|null : ($type is Type::MCP_TOOL_RESULT|'mcp_tool_result' ? ContentShape5|null : string|null)))))))) $content
     * @param list<ToolChangeShape>|null $toolChanges
     * @param BetaFallbackInfo|BetaFallbackInfoShape|null $from
     * @param BetaFallbackInfo|BetaFallbackInfoShape|null $to
     * @param BetaFallbackRefusalTrigger|BetaFallbackRefusalTriggerShape|null $trigger
     * @param list<BetaMCPTool|BetaMCPToolShape>|null $tools
     *
     * @return ($type is Type::TEXT|'text' ? BetaTextBlock : ($type is Type::THINKING|'thinking' ? BetaThinkingBlock : ($type is Type::REDACTED_THINKING|'redacted_thinking' ? BetaRedactedThinkingBlock : ($type is Type::TOOL_USE|'tool_use' ? BetaToolUseBlock : ($type is Type::SERVER_TOOL_USE|'server_tool_use' ? BetaServerToolUseBlock : ($type is Type::WEB_SEARCH_TOOL_RESULT|'web_search_tool_result' ? BetaWebSearchToolResultBlock : ($type is Type::WEB_FETCH_TOOL_RESULT|'web_fetch_tool_result' ? BetaWebFetchToolResultBlock : ($type is Type::ADVISOR_TOOL_RESULT|'advisor_tool_result' ? BetaAdvisorToolResultBlock : ($type is Type::CODE_EXECUTION_TOOL_RESULT|'code_execution_tool_result' ? BetaCodeExecutionToolResultBlock : ($type is Type::BASH_CODE_EXECUTION_TOOL_RESULT|'bash_code_execution_tool_result' ? BetaBashCodeExecutionToolResultBlock : ($type is Type::TEXT_EDITOR_CODE_EXECUTION_TOOL_RESULT|'text_editor_code_execution_tool_result' ? BetaTextEditorCodeExecutionToolResultBlock : ($type is Type::TOOL_SEARCH_TOOL_RESULT|'tool_search_tool_result' ? BetaToolSearchToolResultBlock : ($type is Type::MCP_TOOL_USE|'mcp_tool_use' ? BetaMCPToolUseBlock : ($type is Type::MCP_TOOL_RESULT|'mcp_tool_result' ? BetaMCPToolResultBlock : ($type is Type::CONTAINER_UPLOAD|'container_upload' ? BetaContainerUploadBlock : ($type is Type::COMPACTION|'compaction' ? BetaCompactionBlock : ($type is Type::FALLBACK|'fallback' ? BetaFallbackBlock : ($type is Type::MCP_TOOL_LISTING|'mcp_tool_listing' ? BetaMCPToolListingBlock : BetaTextBlock|BetaThinkingBlock|BetaRedactedThinkingBlock|BetaToolUseBlock|BetaServerToolUseBlock|BetaWebSearchToolResultBlock|BetaWebFetchToolResultBlock|BetaAdvisorToolResultBlock|BetaCodeExecutionToolResultBlock|BetaBashCodeExecutionToolResultBlock|BetaTextEditorCodeExecutionToolResultBlock|BetaToolSearchToolResultBlock|BetaMCPToolUseBlock|BetaMCPToolResultBlock|BetaContainerUploadBlock|BetaCompactionBlock|BetaFallbackBlock|BetaMCPToolListingBlock))))))))))))))))))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        ?array $citations = null,
        ?string $text = null,
        ?string $signature = null,
        ?string $thinking = null,
        ?string $data = null,
        ?string $id = null,
        ?array $input = null,
        string|Name|null $name = null,
        BetaDirectCaller|array|BetaServerToolCaller|BetaServerToolCaller20260120|null $caller = null,
        ?string $toolsetName = null,
        string|BetaWebSearchToolResultError|array|BetaWebFetchToolResultErrorBlock|BetaWebFetchBlock|BetaAdvisorToolResultError|BetaAdvisorResultBlock|BetaAdvisorRedactedResultBlock|BetaCodeExecutionToolResultError|BetaCodeExecutionResultBlock|BetaEncryptedCodeExecutionResultBlock|BetaBashCodeExecutionToolResultError|BetaBashCodeExecutionResultBlock|BetaTextEditorCodeExecutionToolResultError|BetaTextEditorCodeExecutionViewResultBlock|BetaTextEditorCodeExecutionCreateResultBlock|BetaTextEditorCodeExecutionStrReplaceResultBlock|BetaToolSearchToolResultError|BetaToolSearchToolSearchResultBlock|null $content = null,
        ?string $toolUseID = null,
        ?string $serverName = null,
        ?bool $isError = null,
        ?string $fileID = null,
        ?string $encryptedContent = null,
        ?array $toolChanges = null,
        BetaFallbackInfo|array|null $from = null,
        BetaFallbackInfo|array|null $to = null,
        BetaFallbackRefusalTrigger|array|null $trigger = null,
        ?string $mcpServerName = null,
        ?array $tools = null,
    ): BetaTextBlock|BetaThinkingBlock|BetaRedactedThinkingBlock|BetaToolUseBlock|BetaServerToolUseBlock|BetaWebSearchToolResultBlock|BetaWebFetchToolResultBlock|BetaAdvisorToolResultBlock|BetaCodeExecutionToolResultBlock|BetaBashCodeExecutionToolResultBlock|BetaTextEditorCodeExecutionToolResultBlock|BetaToolSearchToolResultBlock|BetaMCPToolUseBlock|BetaMCPToolResultBlock|BetaContainerUploadBlock|BetaCompactionBlock|BetaFallbackBlock|BetaMCPToolListingBlock {
        return match ($type) {
            Type::TEXT, 'text' => BetaTextBlock::with(
                citations: $citations,
                text: $text ?? throw new \ArgumentCountError('$text is required'),
            ),
            Type::THINKING, 'thinking' => BetaThinkingBlock::with(
                signature: $signature ?? throw new \ArgumentCountError('$signature is required'),
                thinking: $thinking ?? throw new \ArgumentCountError('$thinking is required'),
            ),
            Type::REDACTED_THINKING, 'redacted_thinking' => BetaRedactedThinkingBlock::with(
                data: $data ?? throw new \ArgumentCountError('$data is required')
            ),
            Type::TOOL_USE, 'tool_use' => BetaToolUseBlock::with(
                id: $id ?? throw new \ArgumentCountError('$id is required'),
                input: $input ?? throw new \ArgumentCountError('$input is required'),
                // @phpstan-ignore argument.type
                name: $name ?? throw new \ArgumentCountError('$name is required'),
                caller: $caller,
                toolsetName: $toolsetName,
            ),
            Type::SERVER_TOOL_USE, 'server_tool_use' => BetaServerToolUseBlock::with(
                id: $id ?? throw new \ArgumentCountError('$id is required'),
                input: $input ?? throw new \ArgumentCountError('$input is required'),
                // @phpstan-ignore argument.type
                name: $name ?? throw new \ArgumentCountError('$name is required'),
                // @phpstan-ignore argument.type
                caller: $caller,
            ),
            Type::WEB_SEARCH_TOOL_RESULT, 'web_search_tool_result' => BetaWebSearchToolResultBlock::with(
                content: $content ?? throw new \ArgumentCountError('$content is required'),
                toolUseID: $toolUseID ?? throw new \ArgumentCountError('$toolUseID is required'),
                // @phpstan-ignore argument.type
                caller: $caller,
            ),
            Type::WEB_FETCH_TOOL_RESULT, 'web_fetch_tool_result' => BetaWebFetchToolResultBlock::with(
                // @phpstan-ignore argument.type
                content: $content ?? throw new \ArgumentCountError('$content is required'),
                toolUseID: $toolUseID ?? throw new \ArgumentCountError('$toolUseID is required'),
                // @phpstan-ignore argument.type
                caller: $caller,
            ),
            Type::ADVISOR_TOOL_RESULT, 'advisor_tool_result' => BetaAdvisorToolResultBlock::with(
                // @phpstan-ignore argument.type
                content: $content ?? throw new \ArgumentCountError('$content is required'),
                toolUseID: $toolUseID ?? throw new \ArgumentCountError('$toolUseID is required'),
            ),
            Type::CODE_EXECUTION_TOOL_RESULT, 'code_execution_tool_result' => BetaCodeExecutionToolResultBlock::with(
                // @phpstan-ignore argument.type
                content: $content ?? throw new \ArgumentCountError('$content is required'),
                toolUseID: $toolUseID ?? throw new \ArgumentCountError('$toolUseID is required'),
            ),
            Type::BASH_CODE_EXECUTION_TOOL_RESULT, 'bash_code_execution_tool_result' => BetaBashCodeExecutionToolResultBlock::with(
                // @phpstan-ignore argument.type
                content: $content ?? throw new \ArgumentCountError('$content is required'),
                toolUseID: $toolUseID ?? throw new \ArgumentCountError('$toolUseID is required'),
            ),
            Type::TEXT_EDITOR_CODE_EXECUTION_TOOL_RESULT, 'text_editor_code_execution_tool_result' => BetaTextEditorCodeExecutionToolResultBlock::with(
                // @phpstan-ignore argument.type
                content: $content ?? throw new \ArgumentCountError('$content is required'),
                toolUseID: $toolUseID ?? throw new \ArgumentCountError('$toolUseID is required'),
            ),
            Type::TOOL_SEARCH_TOOL_RESULT, 'tool_search_tool_result' => BetaToolSearchToolResultBlock::with(
                // @phpstan-ignore argument.type
                content: $content ?? throw new \ArgumentCountError('$content is required'),
                toolUseID: $toolUseID ?? throw new \ArgumentCountError('$toolUseID is required'),
            ),
            Type::MCP_TOOL_USE, 'mcp_tool_use' => BetaMCPToolUseBlock::with(
                id: $id ?? throw new \ArgumentCountError('$id is required'),
                input: $input ?? throw new \ArgumentCountError('$input is required'),
                // @phpstan-ignore argument.type
                name: $name ?? throw new \ArgumentCountError('$name is required'),
                serverName: $serverName ?? throw new \ArgumentCountError('$serverName is required'),
            ),
            Type::MCP_TOOL_RESULT, 'mcp_tool_result' => BetaMCPToolResultBlock::with(
                // @phpstan-ignore argument.type
                content: $content ?? throw new \ArgumentCountError('$content is required'),
                isError: $isError ?? false,
                toolUseID: $toolUseID ?? throw new \ArgumentCountError('$toolUseID is required'),
            ),
            Type::CONTAINER_UPLOAD, 'container_upload' => BetaContainerUploadBlock::with(
                fileID: $fileID ?? throw new \ArgumentCountError('$fileID is required'),
            ),
            Type::COMPACTION, 'compaction' => BetaCompactionBlock::with(
                // @phpstan-ignore argument.type
                content: $content,
                encryptedContent: $encryptedContent,
                signature: $signature,
                toolChanges: $toolChanges,
            ),
            Type::FALLBACK, 'fallback' => BetaFallbackBlock::with(
                from: $from ?? throw new \ArgumentCountError('$from is required'),
                to: $to ?? throw new \ArgumentCountError('$to is required'),
                trigger: $trigger ?? throw new \ArgumentCountError('$trigger is required'),
            ),
            Type::MCP_TOOL_LISTING, 'mcp_tool_listing' => BetaMCPToolListingBlock::with(
                mcpServerName: $mcpServerName ?? throw new \ArgumentCountError('$mcpServerName is required'),
                tools: $tools ?? throw new \ArgumentCountError('$tools is required'),
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
