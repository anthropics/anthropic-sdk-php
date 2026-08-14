<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Regular text content.
 *
 * @phpstan-import-type TextBlockParamShape from \Anthropic\Messages\TextBlockParam
 * @phpstan-import-type ImageBlockParamShape from \Anthropic\Messages\ImageBlockParam
 * @phpstan-import-type DocumentBlockParamShape from \Anthropic\Messages\DocumentBlockParam
 * @phpstan-import-type SearchResultBlockParamShape from \Anthropic\Messages\SearchResultBlockParam
 * @phpstan-import-type ThinkingBlockParamShape from \Anthropic\Messages\ThinkingBlockParam
 * @phpstan-import-type RedactedThinkingBlockParamShape from \Anthropic\Messages\RedactedThinkingBlockParam
 * @phpstan-import-type ToolUseBlockParamShape from \Anthropic\Messages\ToolUseBlockParam
 * @phpstan-import-type ToolResultBlockParamShape from \Anthropic\Messages\ToolResultBlockParam
 * @phpstan-import-type ServerToolUseBlockParamShape from \Anthropic\Messages\ServerToolUseBlockParam
 * @phpstan-import-type WebSearchToolResultBlockParamShape from \Anthropic\Messages\WebSearchToolResultBlockParam
 * @phpstan-import-type WebFetchToolResultBlockParamShape from \Anthropic\Messages\WebFetchToolResultBlockParam
 * @phpstan-import-type CodeExecutionToolResultBlockParamShape from \Anthropic\Messages\CodeExecutionToolResultBlockParam
 * @phpstan-import-type BashCodeExecutionToolResultBlockParamShape from \Anthropic\Messages\BashCodeExecutionToolResultBlockParam
 * @phpstan-import-type TextEditorCodeExecutionToolResultBlockParamShape from \Anthropic\Messages\TextEditorCodeExecutionToolResultBlockParam
 * @phpstan-import-type ToolSearchToolResultBlockParamShape from \Anthropic\Messages\ToolSearchToolResultBlockParam
 * @phpstan-import-type ContainerUploadBlockParamShape from \Anthropic\Messages\ContainerUploadBlockParam
 *
 * @phpstan-type ContentBlockParamVariants = TextBlockParam|ImageBlockParam|DocumentBlockParam|SearchResultBlockParam|ThinkingBlockParam|RedactedThinkingBlockParam|ToolUseBlockParam|ToolResultBlockParam|ServerToolUseBlockParam|WebSearchToolResultBlockParam|WebFetchToolResultBlockParam|CodeExecutionToolResultBlockParam|BashCodeExecutionToolResultBlockParam|TextEditorCodeExecutionToolResultBlockParam|ToolSearchToolResultBlockParam|ContainerUploadBlockParam
 * @phpstan-type ContentBlockParamShape = ContentBlockParamVariants|TextBlockParamShape|ImageBlockParamShape|DocumentBlockParamShape|SearchResultBlockParamShape|ThinkingBlockParamShape|RedactedThinkingBlockParamShape|ToolUseBlockParamShape|ToolResultBlockParamShape|ServerToolUseBlockParamShape|WebSearchToolResultBlockParamShape|WebFetchToolResultBlockParamShape|CodeExecutionToolResultBlockParamShape|BashCodeExecutionToolResultBlockParamShape|TextEditorCodeExecutionToolResultBlockParamShape|ToolSearchToolResultBlockParamShape|ContainerUploadBlockParamShape
 */
final class ContentBlockParam implements ConverterSource
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
            'text' => TextBlockParam::class,
            'image' => ImageBlockParam::class,
            'document' => DocumentBlockParam::class,
            'search_result' => SearchResultBlockParam::class,
            'thinking' => ThinkingBlockParam::class,
            'redacted_thinking' => RedactedThinkingBlockParam::class,
            'tool_use' => ToolUseBlockParam::class,
            'tool_result' => ToolResultBlockParam::class,
            'server_tool_use' => ServerToolUseBlockParam::class,
            'web_search_tool_result' => WebSearchToolResultBlockParam::class,
            'web_fetch_tool_result' => WebFetchToolResultBlockParam::class,
            'code_execution_tool_result' => CodeExecutionToolResultBlockParam::class,
            'bash_code_execution_tool_result' => BashCodeExecutionToolResultBlockParam::class,
            'text_editor_code_execution_tool_result' => TextEditorCodeExecutionToolResultBlockParam::class,
            'tool_search_tool_result' => ToolSearchToolResultBlockParam::class,
            'container_upload' => ContainerUploadBlockParam::class,
        ];
    }
}
