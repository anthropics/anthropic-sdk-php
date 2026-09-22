<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Beta\Messages\BetaContentBlockParam\Type;
use Anthropic\Beta\Messages\BetaServerToolUseBlockParam\Name;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-import-type BetaImageBlockParamShape from \Anthropic\Beta\Messages\BetaImageBlockParam
 * @phpstan-import-type BetaRequestDocumentBlockShape from \Anthropic\Beta\Messages\BetaRequestDocumentBlock
 * @phpstan-import-type BetaSearchResultBlockParamShape from \Anthropic\Beta\Messages\BetaSearchResultBlockParam
 * @phpstan-import-type BetaThinkingBlockParamShape from \Anthropic\Beta\Messages\BetaThinkingBlockParam
 * @phpstan-import-type BetaRedactedThinkingBlockParamShape from \Anthropic\Beta\Messages\BetaRedactedThinkingBlockParam
 * @phpstan-import-type BetaToolUseBlockParamShape from \Anthropic\Beta\Messages\BetaToolUseBlockParam
 * @phpstan-import-type BetaToolResultBlockParamShape from \Anthropic\Beta\Messages\BetaToolResultBlockParam
 * @phpstan-import-type BetaServerToolUseBlockParamShape from \Anthropic\Beta\Messages\BetaServerToolUseBlockParam
 * @phpstan-import-type BetaWebSearchToolResultBlockParamShape from \Anthropic\Beta\Messages\BetaWebSearchToolResultBlockParam
 * @phpstan-import-type BetaWebFetchToolResultBlockParamShape from \Anthropic\Beta\Messages\BetaWebFetchToolResultBlockParam
 * @phpstan-import-type BetaAdvisorToolResultBlockParamShape from \Anthropic\Beta\Messages\BetaAdvisorToolResultBlockParam
 * @phpstan-import-type BetaCodeExecutionToolResultBlockParamShape from \Anthropic\Beta\Messages\BetaCodeExecutionToolResultBlockParam
 * @phpstan-import-type BetaBashCodeExecutionToolResultBlockParamShape from \Anthropic\Beta\Messages\BetaBashCodeExecutionToolResultBlockParam
 * @phpstan-import-type BetaTextEditorCodeExecutionToolResultBlockParamShape from \Anthropic\Beta\Messages\BetaTextEditorCodeExecutionToolResultBlockParam
 * @phpstan-import-type BetaToolSearchToolResultBlockParamShape from \Anthropic\Beta\Messages\BetaToolSearchToolResultBlockParam
 * @phpstan-import-type BetaMCPToolUseBlockParamShape from \Anthropic\Beta\Messages\BetaMCPToolUseBlockParam
 * @phpstan-import-type BetaRequestMCPToolResultBlockParamShape from \Anthropic\Beta\Messages\BetaRequestMCPToolResultBlockParam
 * @phpstan-import-type BetaContainerUploadBlockParamShape from \Anthropic\Beta\Messages\BetaContainerUploadBlockParam
 * @phpstan-import-type BetaCompactionBlockParamShape from \Anthropic\Beta\Messages\BetaCompactionBlockParam
 * @phpstan-import-type BetaRequestToolAdditionBlockShape from \Anthropic\Beta\Messages\BetaRequestToolAdditionBlock
 * @phpstan-import-type BetaRequestToolRemovalBlockShape from \Anthropic\Beta\Messages\BetaRequestToolRemovalBlock
 * @phpstan-import-type BetaMCPToolListingBlockParamShape from \Anthropic\Beta\Messages\BetaMCPToolListingBlockParam
 * @phpstan-import-type BetaFallbackBlockParamShape from \Anthropic\Beta\Messages\BetaFallbackBlockParam
 * @phpstan-import-type BetaCacheControlEphemeralShape from \Anthropic\Beta\Messages\BetaCacheControlEphemeral
 * @phpstan-import-type BetaTextCitationParamShape from \Anthropic\Beta\Messages\BetaTextCitationParam
 * @phpstan-import-type BetaCitationsConfigParamShape from \Anthropic\Beta\Messages\BetaCitationsConfigParam
 * @phpstan-import-type SourceShape from \Anthropic\Beta\Messages\BetaImageBlockParam\Source
 * @phpstan-import-type SourceShape from \Anthropic\Beta\Messages\BetaRequestDocumentBlock\Source as SourceShape1
 * @phpstan-import-type BetaImageTransformationsParamShape from \Anthropic\Beta\Messages\BetaImageTransformationsParam
 * @phpstan-import-type ContentShape from \Anthropic\Beta\Messages\BetaToolResultBlockParam\Content
 * @phpstan-import-type BetaWebSearchToolResultBlockParamContentShape from \Anthropic\Beta\Messages\BetaWebSearchToolResultBlockParamContent
 * @phpstan-import-type ContentShape from \Anthropic\Beta\Messages\BetaWebFetchToolResultBlockParam\Content as ContentShape1
 * @phpstan-import-type ContentShape from \Anthropic\Beta\Messages\BetaAdvisorToolResultBlockParam\Content as ContentShape2
 * @phpstan-import-type BetaCodeExecutionToolResultBlockParamContentShape from \Anthropic\Beta\Messages\BetaCodeExecutionToolResultBlockParamContent
 * @phpstan-import-type ContentShape from \Anthropic\Beta\Messages\BetaBashCodeExecutionToolResultBlockParam\Content as ContentShape3
 * @phpstan-import-type ContentShape from \Anthropic\Beta\Messages\BetaTextEditorCodeExecutionToolResultBlockParam\Content as ContentShape4
 * @phpstan-import-type ContentShape from \Anthropic\Beta\Messages\BetaToolSearchToolResultBlockParam\Content as ContentShape5
 * @phpstan-import-type ContentShape from \Anthropic\Beta\Messages\BetaRequestMCPToolResultBlockParam\Content as ContentShape6
 * @phpstan-import-type CallerShape from \Anthropic\Beta\Messages\BetaToolUseBlockParam\Caller
 * @phpstan-import-type CallerShape from \Anthropic\Beta\Messages\BetaServerToolUseBlockParam\Caller as CallerShape1
 * @phpstan-import-type CallerShape from \Anthropic\Beta\Messages\BetaWebSearchToolResultBlockParam\Caller as CallerShape2
 * @phpstan-import-type CallerShape from \Anthropic\Beta\Messages\BetaWebFetchToolResultBlockParam\Caller as CallerShape3
 * @phpstan-import-type ToolChangeShape from \Anthropic\Beta\Messages\BetaCompactionBlockParam\ToolChange
 * @phpstan-import-type ToolShape from \Anthropic\Beta\Messages\BetaRequestToolAdditionBlock\Tool
 * @phpstan-import-type ToolShape from \Anthropic\Beta\Messages\BetaRequestToolRemovalBlock\Tool as ToolShape1
 * @phpstan-import-type BetaMCPToolParamShape from \Anthropic\Beta\Messages\BetaMCPToolParam
 * @phpstan-import-type BetaTextBlockParamShape from \Anthropic\Beta\Messages\BetaTextBlockParam
 * @phpstan-import-type BetaFallbackInfoParamShape from \Anthropic\Beta\Messages\BetaFallbackInfoParam
 *
 * @phpstan-type BetaContentBlockParamVariants = BetaTextBlockParam|BetaImageBlockParam|BetaRequestDocumentBlock|BetaSearchResultBlockParam|BetaThinkingBlockParam|BetaRedactedThinkingBlockParam|BetaToolUseBlockParam|BetaToolResultBlockParam|BetaServerToolUseBlockParam|BetaWebSearchToolResultBlockParam|BetaWebFetchToolResultBlockParam|BetaAdvisorToolResultBlockParam|BetaCodeExecutionToolResultBlockParam|BetaBashCodeExecutionToolResultBlockParam|BetaTextEditorCodeExecutionToolResultBlockParam|BetaToolSearchToolResultBlockParam|BetaMCPToolUseBlockParam|BetaRequestMCPToolResultBlockParam|BetaContainerUploadBlockParam|BetaCompactionBlockParam|BetaRequestToolAdditionBlock|BetaRequestToolRemovalBlock|BetaMCPToolListingBlockParam|BetaFallbackBlockParam
 * @phpstan-type BetaContentBlockParamShape = BetaContentBlockParamVariants|BetaTextBlockParamShape|BetaImageBlockParamShape|BetaRequestDocumentBlockShape|BetaSearchResultBlockParamShape|BetaThinkingBlockParamShape|BetaRedactedThinkingBlockParamShape|BetaToolUseBlockParamShape|BetaToolResultBlockParamShape|BetaServerToolUseBlockParamShape|BetaWebSearchToolResultBlockParamShape|BetaWebFetchToolResultBlockParamShape|BetaAdvisorToolResultBlockParamShape|BetaCodeExecutionToolResultBlockParamShape|BetaBashCodeExecutionToolResultBlockParamShape|BetaTextEditorCodeExecutionToolResultBlockParamShape|BetaToolSearchToolResultBlockParamShape|BetaMCPToolUseBlockParamShape|BetaRequestMCPToolResultBlockParamShape|BetaContainerUploadBlockParamShape|BetaCompactionBlockParamShape|BetaRequestToolAdditionBlockShape|BetaRequestToolRemovalBlockShape|BetaMCPToolListingBlockParamShape|BetaFallbackBlockParamShape
 */
final class BetaContentBlockParam implements ConverterSource
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
            'text' => BetaTextBlockParam::class,
            'image' => BetaImageBlockParam::class,
            'document' => BetaRequestDocumentBlock::class,
            'search_result' => BetaSearchResultBlockParam::class,
            'thinking' => BetaThinkingBlockParam::class,
            'redacted_thinking' => BetaRedactedThinkingBlockParam::class,
            'tool_use' => BetaToolUseBlockParam::class,
            'tool_result' => BetaToolResultBlockParam::class,
            'server_tool_use' => BetaServerToolUseBlockParam::class,
            'web_search_tool_result' => BetaWebSearchToolResultBlockParam::class,
            'web_fetch_tool_result' => BetaWebFetchToolResultBlockParam::class,
            'advisor_tool_result' => BetaAdvisorToolResultBlockParam::class,
            'code_execution_tool_result' => BetaCodeExecutionToolResultBlockParam::class,
            'bash_code_execution_tool_result' => BetaBashCodeExecutionToolResultBlockParam::class,
            'text_editor_code_execution_tool_result' => BetaTextEditorCodeExecutionToolResultBlockParam::class,
            'tool_search_tool_result' => BetaToolSearchToolResultBlockParam::class,
            'mcp_tool_use' => BetaMCPToolUseBlockParam::class,
            'mcp_tool_result' => BetaRequestMCPToolResultBlockParam::class,
            'container_upload' => BetaContainerUploadBlockParam::class,
            'compaction' => BetaCompactionBlockParam::class,
            'tool_addition' => BetaRequestToolAdditionBlock::class,
            'tool_removal' => BetaRequestToolRemovalBlock::class,
            'mcp_tool_listing' => BetaMCPToolListingBlockParam::class,
            'fallback' => BetaFallbackBlockParam::class,
        ];
    }

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @param BetaCacheControlEphemeral|BetaCacheControlEphemeralShape|null $cacheControl
     * @param ($type is Type::TEXT|'text' ? list<BetaTextCitationParamShape>|null : BetaCitationsConfigParam|BetaCitationsConfigParamShape|null) $citations
     * @param ($type is Type::IMAGE|'image' ? SourceShape|null : ($type is Type::DOCUMENT|'document' ? SourceShape1|null : string|null)) $source
     * @param BetaImageTransformationsParam|BetaImageTransformationsParamShape|null $transformations
     * @param ($type is Type::SEARCH_RESULT|'search_result' ? list<BetaTextBlockParam|BetaTextBlockParamShape>|null : ($type is Type::TOOL_RESULT|'tool_result' ? ContentShape|null : ($type is Type::WEB_SEARCH_TOOL_RESULT|'web_search_tool_result' ? BetaWebSearchToolResultBlockParamContentShape|null : ($type is Type::WEB_FETCH_TOOL_RESULT|'web_fetch_tool_result' ? ContentShape1|null : ($type is Type::ADVISOR_TOOL_RESULT|'advisor_tool_result' ? ContentShape2|null : ($type is Type::CODE_EXECUTION_TOOL_RESULT|'code_execution_tool_result' ? BetaCodeExecutionToolResultBlockParamContentShape|null : ($type is Type::BASH_CODE_EXECUTION_TOOL_RESULT|'bash_code_execution_tool_result' ? ContentShape3|null : ($type is Type::TEXT_EDITOR_CODE_EXECUTION_TOOL_RESULT|'text_editor_code_execution_tool_result' ? ContentShape4|null : ($type is Type::TOOL_SEARCH_TOOL_RESULT|'tool_search_tool_result' ? ContentShape5|null : ($type is Type::MCP_TOOL_RESULT|'mcp_tool_result' ? ContentShape6|null : string|null)))))))))) $content
     * @param array<string,mixed>|null $input
     * @param ($type is Type::TOOL_USE|'tool_use'|Type::MCP_TOOL_USE|'mcp_tool_use' ? string|null : Name|value-of<Name>|null) $name
     * @param ($type is Type::TOOL_USE|'tool_use' ? CallerShape|null : ($type is Type::SERVER_TOOL_USE|'server_tool_use' ? CallerShape1|null : ($type is Type::WEB_SEARCH_TOOL_RESULT|'web_search_tool_result' ? CallerShape2|null : CallerShape3|null))) $caller
     * @param list<ToolChangeShape>|null $toolChanges
     * @param ($type is Type::TOOL_ADDITION|'tool_addition' ? ToolShape|null : ToolShape1|null) $tool
     * @param list<BetaMCPToolParam|BetaMCPToolParamShape>|null $tools
     * @param BetaFallbackInfoParam|BetaFallbackInfoParamShape|null $from
     * @param BetaFallbackInfoParam|BetaFallbackInfoParamShape|null $to
     *
     * @return ($type is Type::TEXT|'text' ? BetaTextBlockParam : ($type is Type::IMAGE|'image' ? BetaImageBlockParam : ($type is Type::DOCUMENT|'document' ? BetaRequestDocumentBlock : ($type is Type::SEARCH_RESULT|'search_result' ? BetaSearchResultBlockParam : ($type is Type::THINKING|'thinking' ? BetaThinkingBlockParam : ($type is Type::REDACTED_THINKING|'redacted_thinking' ? BetaRedactedThinkingBlockParam : ($type is Type::TOOL_USE|'tool_use' ? BetaToolUseBlockParam : ($type is Type::TOOL_RESULT|'tool_result' ? BetaToolResultBlockParam : ($type is Type::SERVER_TOOL_USE|'server_tool_use' ? BetaServerToolUseBlockParam : ($type is Type::WEB_SEARCH_TOOL_RESULT|'web_search_tool_result' ? BetaWebSearchToolResultBlockParam : ($type is Type::WEB_FETCH_TOOL_RESULT|'web_fetch_tool_result' ? BetaWebFetchToolResultBlockParam : ($type is Type::ADVISOR_TOOL_RESULT|'advisor_tool_result' ? BetaAdvisorToolResultBlockParam : ($type is Type::CODE_EXECUTION_TOOL_RESULT|'code_execution_tool_result' ? BetaCodeExecutionToolResultBlockParam : ($type is Type::BASH_CODE_EXECUTION_TOOL_RESULT|'bash_code_execution_tool_result' ? BetaBashCodeExecutionToolResultBlockParam : ($type is Type::TEXT_EDITOR_CODE_EXECUTION_TOOL_RESULT|'text_editor_code_execution_tool_result' ? BetaTextEditorCodeExecutionToolResultBlockParam : ($type is Type::TOOL_SEARCH_TOOL_RESULT|'tool_search_tool_result' ? BetaToolSearchToolResultBlockParam : ($type is Type::MCP_TOOL_USE|'mcp_tool_use' ? BetaMCPToolUseBlockParam : ($type is Type::MCP_TOOL_RESULT|'mcp_tool_result' ? BetaRequestMCPToolResultBlockParam : ($type is Type::CONTAINER_UPLOAD|'container_upload' ? BetaContainerUploadBlockParam : ($type is Type::COMPACTION|'compaction' ? BetaCompactionBlockParam : ($type is Type::TOOL_ADDITION|'tool_addition' ? BetaRequestToolAdditionBlock : ($type is Type::TOOL_REMOVAL|'tool_removal' ? BetaRequestToolRemovalBlock : ($type is Type::MCP_TOOL_LISTING|'mcp_tool_listing' ? BetaMCPToolListingBlockParam : ($type is Type::FALLBACK|'fallback' ? BetaFallbackBlockParam : BetaTextBlockParam|BetaImageBlockParam|BetaRequestDocumentBlock|BetaSearchResultBlockParam|BetaThinkingBlockParam|BetaRedactedThinkingBlockParam|BetaToolUseBlockParam|BetaToolResultBlockParam|BetaServerToolUseBlockParam|BetaWebSearchToolResultBlockParam|BetaWebFetchToolResultBlockParam|BetaAdvisorToolResultBlockParam|BetaCodeExecutionToolResultBlockParam|BetaBashCodeExecutionToolResultBlockParam|BetaTextEditorCodeExecutionToolResultBlockParam|BetaToolSearchToolResultBlockParam|BetaMCPToolUseBlockParam|BetaRequestMCPToolResultBlockParam|BetaContainerUploadBlockParam|BetaCompactionBlockParam|BetaRequestToolAdditionBlock|BetaRequestToolRemovalBlock|BetaMCPToolListingBlockParam|BetaFallbackBlockParam))))))))))))))))))))))))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        ?string $text = null,
        BetaCacheControlEphemeral|array|null $cacheControl = null,
        array|BetaCitationsConfigParam|null $citations = null,
        string|BetaBase64ImageSource|array|BetaURLImageSource|BetaFileImageSource|BetaBase64PDFSource|BetaPlainTextSource|BetaContentBlockSource|BetaURLPDFSource|BetaFileDocumentSource|null $source = null,
        BetaImageTransformationsParam|array|null $transformations = null,
        ?string $context = null,
        ?string $title = null,
        string|array|BetaWebSearchToolRequestError|BetaWebFetchToolResultErrorBlockParam|BetaWebFetchBlockParam|BetaAdvisorToolResultErrorParam|BetaAdvisorResultBlockParam|BetaAdvisorRedactedResultBlockParam|BetaCodeExecutionToolResultErrorParam|BetaCodeExecutionResultBlockParam|BetaEncryptedCodeExecutionResultBlockParam|BetaBashCodeExecutionToolResultErrorParam|BetaBashCodeExecutionResultBlockParam|BetaTextEditorCodeExecutionToolResultErrorParam|BetaTextEditorCodeExecutionViewResultBlockParam|BetaTextEditorCodeExecutionCreateResultBlockParam|BetaTextEditorCodeExecutionStrReplaceResultBlockParam|BetaToolSearchToolResultErrorParam|BetaToolSearchToolSearchResultBlockParam|null $content = null,
        ?string $signature = null,
        ?string $thinking = null,
        ?string $data = null,
        ?string $id = null,
        ?array $input = null,
        string|Name|null $name = null,
        BetaDirectCaller|array|BetaServerToolCaller|BetaServerToolCaller20260120|null $caller = null,
        ?string $toolsetName = null,
        ?string $toolUseID = null,
        ?bool $isError = null,
        ?string $serverName = null,
        ?string $fileID = null,
        ?string $encryptedContent = null,
        ?array $toolChanges = null,
        BetaToolChangeToolReference|array|BetaToolChangeMCPToolReference|BetaToolChangeMCPToolsetReference|BetaToolChangeToolDefinitionParam|null $tool = null,
        ?string $mcpServerName = null,
        ?array $tools = null,
        BetaFallbackInfoParam|array|null $from = null,
        BetaFallbackInfoParam|array|null $to = null,
        mixed $trigger = null,
    ): BetaTextBlockParam|BetaImageBlockParam|BetaRequestDocumentBlock|BetaSearchResultBlockParam|BetaThinkingBlockParam|BetaRedactedThinkingBlockParam|BetaToolUseBlockParam|BetaToolResultBlockParam|BetaServerToolUseBlockParam|BetaWebSearchToolResultBlockParam|BetaWebFetchToolResultBlockParam|BetaAdvisorToolResultBlockParam|BetaCodeExecutionToolResultBlockParam|BetaBashCodeExecutionToolResultBlockParam|BetaTextEditorCodeExecutionToolResultBlockParam|BetaToolSearchToolResultBlockParam|BetaMCPToolUseBlockParam|BetaRequestMCPToolResultBlockParam|BetaContainerUploadBlockParam|BetaCompactionBlockParam|BetaRequestToolAdditionBlock|BetaRequestToolRemovalBlock|BetaMCPToolListingBlockParam|BetaFallbackBlockParam {
        return match ($type) {
            Type::TEXT, 'text' => BetaTextBlockParam::with(
                text: $text ?? throw new \ArgumentCountError('$text is required'),
                cacheControl: $cacheControl,
                citations: $citations,
            ),
            Type::IMAGE, 'image' => BetaImageBlockParam::with(
                source: $source ?? throw new \ArgumentCountError('$source is required'),
                cacheControl: $cacheControl,
                transformations: $transformations,
            ),
            Type::DOCUMENT, 'document' => BetaRequestDocumentBlock::with(
                // @phpstan-ignore argument.type
                source: $source ?? throw new \ArgumentCountError('$source is required'),
                cacheControl: $cacheControl,
                // @phpstan-ignore argument.type
                citations: $citations,
                context: $context,
                title: $title,
            ),
            Type::SEARCH_RESULT, 'search_result' => BetaSearchResultBlockParam::with(
                content: $content ?? throw new \ArgumentCountError('$content is required'),
                // @phpstan-ignore argument.type
                source: $source ?? throw new \ArgumentCountError('$source is required'),
                title: $title ?? throw new \ArgumentCountError('$title is required'),
                cacheControl: $cacheControl,
                // @phpstan-ignore argument.type
                citations: $citations,
            ),
            Type::THINKING, 'thinking' => BetaThinkingBlockParam::with(
                signature: $signature ?? throw new \ArgumentCountError('$signature is required'),
                thinking: $thinking ?? throw new \ArgumentCountError('$thinking is required'),
            ),
            Type::REDACTED_THINKING, 'redacted_thinking' => BetaRedactedThinkingBlockParam::with(
                data: $data ?? throw new \ArgumentCountError('$data is required')
            ),
            Type::TOOL_USE, 'tool_use' => BetaToolUseBlockParam::with(
                id: $id ?? throw new \ArgumentCountError('$id is required'),
                input: $input ?? throw new \ArgumentCountError('$input is required'),
                // @phpstan-ignore argument.type
                name: $name ?? throw new \ArgumentCountError('$name is required'),
                cacheControl: $cacheControl,
                caller: $caller,
                toolsetName: $toolsetName,
            ),
            Type::TOOL_RESULT, 'tool_result' => BetaToolResultBlockParam::with(
                toolUseID: $toolUseID ?? throw new \ArgumentCountError('$toolUseID is required'),
                cacheControl: $cacheControl,
                // @phpstan-ignore argument.type
                content: $content,
                isError: $isError,
                toolsetName: $toolsetName,
            ),
            Type::SERVER_TOOL_USE, 'server_tool_use' => BetaServerToolUseBlockParam::with(
                id: $id ?? throw new \ArgumentCountError('$id is required'),
                input: $input ?? throw new \ArgumentCountError('$input is required'),
                // @phpstan-ignore argument.type
                name: $name ?? throw new \ArgumentCountError('$name is required'),
                cacheControl: $cacheControl,
                // @phpstan-ignore argument.type
                caller: $caller,
            ),
            Type::WEB_SEARCH_TOOL_RESULT, 'web_search_tool_result' => BetaWebSearchToolResultBlockParam::with(
                // @phpstan-ignore argument.type
                content: $content ?? throw new \ArgumentCountError('$content is required'),
                toolUseID: $toolUseID ?? throw new \ArgumentCountError('$toolUseID is required'),
                cacheControl: $cacheControl,
                // @phpstan-ignore argument.type
                caller: $caller,
            ),
            Type::WEB_FETCH_TOOL_RESULT, 'web_fetch_tool_result' => BetaWebFetchToolResultBlockParam::with(
                // @phpstan-ignore argument.type
                content: $content ?? throw new \ArgumentCountError('$content is required'),
                toolUseID: $toolUseID ?? throw new \ArgumentCountError('$toolUseID is required'),
                cacheControl: $cacheControl,
                // @phpstan-ignore argument.type
                caller: $caller,
            ),
            Type::ADVISOR_TOOL_RESULT, 'advisor_tool_result' => BetaAdvisorToolResultBlockParam::with(
                // @phpstan-ignore argument.type
                content: $content ?? throw new \ArgumentCountError('$content is required'),
                toolUseID: $toolUseID ?? throw new \ArgumentCountError('$toolUseID is required'),
                cacheControl: $cacheControl,
            ),
            Type::CODE_EXECUTION_TOOL_RESULT, 'code_execution_tool_result' => BetaCodeExecutionToolResultBlockParam::with(
                // @phpstan-ignore argument.type
                content: $content ?? throw new \ArgumentCountError('$content is required'),
                toolUseID: $toolUseID ?? throw new \ArgumentCountError('$toolUseID is required'),
                cacheControl: $cacheControl,
            ),
            Type::BASH_CODE_EXECUTION_TOOL_RESULT, 'bash_code_execution_tool_result' => BetaBashCodeExecutionToolResultBlockParam::with(
                // @phpstan-ignore argument.type
                content: $content ?? throw new \ArgumentCountError('$content is required'),
                toolUseID: $toolUseID ?? throw new \ArgumentCountError('$toolUseID is required'),
                cacheControl: $cacheControl,
            ),
            Type::TEXT_EDITOR_CODE_EXECUTION_TOOL_RESULT, 'text_editor_code_execution_tool_result' => BetaTextEditorCodeExecutionToolResultBlockParam::with(
                // @phpstan-ignore argument.type
                content: $content ?? throw new \ArgumentCountError('$content is required'),
                toolUseID: $toolUseID ?? throw new \ArgumentCountError('$toolUseID is required'),
                cacheControl: $cacheControl,
            ),
            Type::TOOL_SEARCH_TOOL_RESULT, 'tool_search_tool_result' => BetaToolSearchToolResultBlockParam::with(
                // @phpstan-ignore argument.type
                content: $content ?? throw new \ArgumentCountError('$content is required'),
                toolUseID: $toolUseID ?? throw new \ArgumentCountError('$toolUseID is required'),
                cacheControl: $cacheControl,
            ),
            Type::MCP_TOOL_USE, 'mcp_tool_use' => BetaMCPToolUseBlockParam::with(
                id: $id ?? throw new \ArgumentCountError('$id is required'),
                input: $input ?? throw new \ArgumentCountError('$input is required'),
                // @phpstan-ignore argument.type
                name: $name ?? throw new \ArgumentCountError('$name is required'),
                serverName: $serverName ?? throw new \ArgumentCountError('$serverName is required'),
                cacheControl: $cacheControl,
            ),
            Type::MCP_TOOL_RESULT, 'mcp_tool_result' => BetaRequestMCPToolResultBlockParam::with(
                toolUseID: $toolUseID ?? throw new \ArgumentCountError('$toolUseID is required'),
                cacheControl: $cacheControl,
                // @phpstan-ignore argument.type
                content: $content,
                isError: $isError,
            ),
            Type::CONTAINER_UPLOAD, 'container_upload' => BetaContainerUploadBlockParam::with(
                fileID: $fileID ?? throw new \ArgumentCountError('$fileID is required'),
                cacheControl: $cacheControl,
            ),
            Type::COMPACTION, 'compaction' => BetaCompactionBlockParam::with(
                cacheControl: $cacheControl,
                // @phpstan-ignore argument.type
                content: $content,
                encryptedContent: $encryptedContent,
                signature: $signature,
                toolChanges: $toolChanges,
            ),
            Type::TOOL_ADDITION, 'tool_addition' => BetaRequestToolAdditionBlock::with(
                tool: $tool ?? throw new \ArgumentCountError('$tool is required'),
                cacheControl: $cacheControl,
            ),
            Type::TOOL_REMOVAL, 'tool_removal' => BetaRequestToolRemovalBlock::with(
                // @phpstan-ignore argument.type
                tool: $tool ?? throw new \ArgumentCountError('$tool is required'),
                cacheControl: $cacheControl,
            ),
            Type::MCP_TOOL_LISTING, 'mcp_tool_listing' => BetaMCPToolListingBlockParam::with(
                mcpServerName: $mcpServerName ?? throw new \ArgumentCountError('$mcpServerName is required'),
                tools: $tools ?? throw new \ArgumentCountError('$tools is required'),
            ),
            Type::FALLBACK, 'fallback' => BetaFallbackBlockParam::with(
                from: $from ?? throw new \ArgumentCountError('$from is required'),
                to: $to ?? throw new \ArgumentCountError('$to is required'),
                trigger: $trigger,
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
