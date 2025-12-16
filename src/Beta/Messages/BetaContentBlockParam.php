<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Regular text content.
 *
 * @phpstan-import-type BetaTextBlockParamShape from \Anthropic\Beta\Messages\BetaTextBlockParam
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
 * @phpstan-import-type BetaCodeExecutionToolResultBlockParamShape from \Anthropic\Beta\Messages\BetaCodeExecutionToolResultBlockParam
 * @phpstan-import-type BetaBashCodeExecutionToolResultBlockParamShape from \Anthropic\Beta\Messages\BetaBashCodeExecutionToolResultBlockParam
 * @phpstan-import-type BetaTextEditorCodeExecutionToolResultBlockParamShape from \Anthropic\Beta\Messages\BetaTextEditorCodeExecutionToolResultBlockParam
 * @phpstan-import-type BetaToolSearchToolResultBlockParamShape from \Anthropic\Beta\Messages\BetaToolSearchToolResultBlockParam
 * @phpstan-import-type BetaMCPToolUseBlockParamShape from \Anthropic\Beta\Messages\BetaMCPToolUseBlockParam
 * @phpstan-import-type BetaRequestMCPToolResultBlockParamShape from \Anthropic\Beta\Messages\BetaRequestMCPToolResultBlockParam
 * @phpstan-import-type BetaContainerUploadBlockParamShape from \Anthropic\Beta\Messages\BetaContainerUploadBlockParam
 *
 * @phpstan-type BetaContentBlockParamShape = BetaTextBlockParamShape|BetaImageBlockParamShape|BetaRequestDocumentBlockShape|BetaSearchResultBlockParamShape|BetaThinkingBlockParamShape|BetaRedactedThinkingBlockParamShape|BetaToolUseBlockParamShape|BetaToolResultBlockParamShape|BetaServerToolUseBlockParamShape|BetaWebSearchToolResultBlockParamShape|BetaWebFetchToolResultBlockParamShape|BetaCodeExecutionToolResultBlockParamShape|BetaBashCodeExecutionToolResultBlockParamShape|BetaTextEditorCodeExecutionToolResultBlockParamShape|BetaToolSearchToolResultBlockParamShape|BetaMCPToolUseBlockParamShape|BetaRequestMCPToolResultBlockParamShape|BetaContainerUploadBlockParamShape
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
            'code_execution_tool_result' => BetaCodeExecutionToolResultBlockParam::class,
            'bash_code_execution_tool_result' => BetaBashCodeExecutionToolResultBlockParam::class,
            'text_editor_code_execution_tool_result' => BetaTextEditorCodeExecutionToolResultBlockParam::class,
            'tool_search_tool_result' => BetaToolSearchToolResultBlockParam::class,
            'mcp_tool_use' => BetaMCPToolUseBlockParam::class,
            'mcp_tool_result' => BetaRequestMCPToolResultBlockParam::class,
            'container_upload' => BetaContainerUploadBlockParam::class,
        ];
    }
}
