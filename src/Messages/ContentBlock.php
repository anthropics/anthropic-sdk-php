<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Messages\ContentBlock\Type;
use Anthropic\Messages\ServerToolUseBlock\Name;

/**
 * @phpstan-import-type TextBlockShape from \Anthropic\Messages\TextBlock
 * @phpstan-import-type ThinkingBlockShape from \Anthropic\Messages\ThinkingBlock
 * @phpstan-import-type RedactedThinkingBlockShape from \Anthropic\Messages\RedactedThinkingBlock
 * @phpstan-import-type ToolUseBlockShape from \Anthropic\Messages\ToolUseBlock
 * @phpstan-import-type ServerToolUseBlockShape from \Anthropic\Messages\ServerToolUseBlock
 * @phpstan-import-type WebSearchToolResultBlockShape from \Anthropic\Messages\WebSearchToolResultBlock
 * @phpstan-import-type WebFetchToolResultBlockShape from \Anthropic\Messages\WebFetchToolResultBlock
 * @phpstan-import-type CodeExecutionToolResultBlockShape from \Anthropic\Messages\CodeExecutionToolResultBlock
 * @phpstan-import-type BashCodeExecutionToolResultBlockShape from \Anthropic\Messages\BashCodeExecutionToolResultBlock
 * @phpstan-import-type TextEditorCodeExecutionToolResultBlockShape from \Anthropic\Messages\TextEditorCodeExecutionToolResultBlock
 * @phpstan-import-type ToolSearchToolResultBlockShape from \Anthropic\Messages\ToolSearchToolResultBlock
 * @phpstan-import-type ContainerUploadBlockShape from \Anthropic\Messages\ContainerUploadBlock
 * @phpstan-import-type TextCitationShape from \Anthropic\Messages\TextCitation
 * @phpstan-import-type CallerShape from \Anthropic\Messages\ToolUseBlock\Caller
 * @phpstan-import-type CallerShape from \Anthropic\Messages\ServerToolUseBlock\Caller as CallerShape1
 * @phpstan-import-type CallerShape from \Anthropic\Messages\WebSearchToolResultBlock\Caller as CallerShape2
 * @phpstan-import-type CallerShape from \Anthropic\Messages\WebFetchToolResultBlock\Caller as CallerShape3
 * @phpstan-import-type WebSearchToolResultBlockContentShape from \Anthropic\Messages\WebSearchToolResultBlockContent
 * @phpstan-import-type ContentShape from \Anthropic\Messages\WebFetchToolResultBlock\Content
 * @phpstan-import-type CodeExecutionToolResultBlockContentShape from \Anthropic\Messages\CodeExecutionToolResultBlockContent
 * @phpstan-import-type ContentShape from \Anthropic\Messages\BashCodeExecutionToolResultBlock\Content as ContentShape1
 * @phpstan-import-type ContentShape from \Anthropic\Messages\TextEditorCodeExecutionToolResultBlock\Content as ContentShape2
 * @phpstan-import-type ContentShape from \Anthropic\Messages\ToolSearchToolResultBlock\Content as ContentShape3
 *
 * @phpstan-type ContentBlockVariants = TextBlock|ThinkingBlock|RedactedThinkingBlock|ToolUseBlock|ServerToolUseBlock|WebSearchToolResultBlock|WebFetchToolResultBlock|CodeExecutionToolResultBlock|BashCodeExecutionToolResultBlock|TextEditorCodeExecutionToolResultBlock|ToolSearchToolResultBlock|ContainerUploadBlock
 * @phpstan-type ContentBlockShape = ContentBlockVariants|TextBlockShape|ThinkingBlockShape|RedactedThinkingBlockShape|ToolUseBlockShape|ServerToolUseBlockShape|WebSearchToolResultBlockShape|WebFetchToolResultBlockShape|CodeExecutionToolResultBlockShape|BashCodeExecutionToolResultBlockShape|TextEditorCodeExecutionToolResultBlockShape|ToolSearchToolResultBlockShape|ContainerUploadBlockShape
 */
final class ContentBlock implements ConverterSource
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
            'text' => TextBlock::class,
            'thinking' => ThinkingBlock::class,
            'redacted_thinking' => RedactedThinkingBlock::class,
            'tool_use' => ToolUseBlock::class,
            'server_tool_use' => ServerToolUseBlock::class,
            'web_search_tool_result' => WebSearchToolResultBlock::class,
            'web_fetch_tool_result' => WebFetchToolResultBlock::class,
            'code_execution_tool_result' => CodeExecutionToolResultBlock::class,
            'bash_code_execution_tool_result' => BashCodeExecutionToolResultBlock::class,
            'text_editor_code_execution_tool_result' => TextEditorCodeExecutionToolResultBlock::class,
            'tool_search_tool_result' => ToolSearchToolResultBlock::class,
            'container_upload' => ContainerUploadBlock::class,
        ];
    }

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @param list<TextCitationShape>|null $citations
     * @param ($type is Type::TOOL_USE|'tool_use' ? CallerShape|null : ($type is Type::SERVER_TOOL_USE|'server_tool_use' ? CallerShape1|null : ($type is Type::WEB_SEARCH_TOOL_RESULT|'web_search_tool_result' ? CallerShape2|null : CallerShape3|null))) $caller
     * @param array<string,mixed>|null $input
     * @param ($type is Type::TOOL_USE|'tool_use' ? string|null : Name|value-of<Name>|null) $name
     * @param ($type is Type::WEB_SEARCH_TOOL_RESULT|'web_search_tool_result' ? WebSearchToolResultBlockContentShape|null : ($type is Type::WEB_FETCH_TOOL_RESULT|'web_fetch_tool_result' ? ContentShape|null : ($type is Type::CODE_EXECUTION_TOOL_RESULT|'code_execution_tool_result' ? CodeExecutionToolResultBlockContentShape|null : ($type is Type::BASH_CODE_EXECUTION_TOOL_RESULT|'bash_code_execution_tool_result' ? ContentShape1|null : ($type is Type::TEXT_EDITOR_CODE_EXECUTION_TOOL_RESULT|'text_editor_code_execution_tool_result' ? ContentShape2|null : ContentShape3|null))))) $content
     *
     * @return ($type is Type::TEXT|'text' ? TextBlock : ($type is Type::THINKING|'thinking' ? ThinkingBlock : ($type is Type::REDACTED_THINKING|'redacted_thinking' ? RedactedThinkingBlock : ($type is Type::TOOL_USE|'tool_use' ? ToolUseBlock : ($type is Type::SERVER_TOOL_USE|'server_tool_use' ? ServerToolUseBlock : ($type is Type::WEB_SEARCH_TOOL_RESULT|'web_search_tool_result' ? WebSearchToolResultBlock : ($type is Type::WEB_FETCH_TOOL_RESULT|'web_fetch_tool_result' ? WebFetchToolResultBlock : ($type is Type::CODE_EXECUTION_TOOL_RESULT|'code_execution_tool_result' ? CodeExecutionToolResultBlock : ($type is Type::BASH_CODE_EXECUTION_TOOL_RESULT|'bash_code_execution_tool_result' ? BashCodeExecutionToolResultBlock : ($type is Type::TEXT_EDITOR_CODE_EXECUTION_TOOL_RESULT|'text_editor_code_execution_tool_result' ? TextEditorCodeExecutionToolResultBlock : ($type is Type::TOOL_SEARCH_TOOL_RESULT|'tool_search_tool_result' ? ToolSearchToolResultBlock : ($type is Type::CONTAINER_UPLOAD|'container_upload' ? ContainerUploadBlock : TextBlock|ThinkingBlock|RedactedThinkingBlock|ToolUseBlock|ServerToolUseBlock|WebSearchToolResultBlock|WebFetchToolResultBlock|CodeExecutionToolResultBlock|BashCodeExecutionToolResultBlock|TextEditorCodeExecutionToolResultBlock|ToolSearchToolResultBlock|ContainerUploadBlock))))))))))))
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
        DirectCaller|array|ServerToolCaller|ServerToolCaller20260120|null $caller = null,
        ?array $input = null,
        string|Name|null $name = null,
        ?string $toolsetName = null,
        WebSearchToolResultError|array|WebFetchToolResultErrorBlock|WebFetchBlock|CodeExecutionToolResultError|CodeExecutionResultBlock|EncryptedCodeExecutionResultBlock|BashCodeExecutionToolResultError|BashCodeExecutionResultBlock|TextEditorCodeExecutionToolResultError|TextEditorCodeExecutionViewResultBlock|TextEditorCodeExecutionCreateResultBlock|TextEditorCodeExecutionStrReplaceResultBlock|ToolSearchToolResultError|ToolSearchToolSearchResultBlock|null $content = null,
        ?string $toolUseID = null,
        ?string $fileID = null,
    ): TextBlock|ThinkingBlock|RedactedThinkingBlock|ToolUseBlock|ServerToolUseBlock|WebSearchToolResultBlock|WebFetchToolResultBlock|CodeExecutionToolResultBlock|BashCodeExecutionToolResultBlock|TextEditorCodeExecutionToolResultBlock|ToolSearchToolResultBlock|ContainerUploadBlock {
        return match ($type) {
            Type::TEXT, 'text' => TextBlock::with(
                citations: $citations,
                text: $text ?? throw new \ArgumentCountError('$text is required'),
            ),
            Type::THINKING, 'thinking' => ThinkingBlock::with(
                signature: $signature ?? throw new \ArgumentCountError('$signature is required'),
                thinking: $thinking ?? throw new \ArgumentCountError('$thinking is required'),
            ),
            Type::REDACTED_THINKING, 'redacted_thinking' => RedactedThinkingBlock::with(
                data: $data ?? throw new \ArgumentCountError('$data is required')
            ),
            Type::TOOL_USE, 'tool_use' => ToolUseBlock::with(
                id: $id ?? throw new \ArgumentCountError('$id is required'),
                caller: $caller ?? ['type' => 'direct'],
                input: $input ?? throw new \ArgumentCountError('$input is required'),
                name: $name ?? throw new \ArgumentCountError('$name is required'),
                toolsetName: $toolsetName,
            ),
            Type::SERVER_TOOL_USE, 'server_tool_use' => ServerToolUseBlock::with(
                id: $id ?? throw new \ArgumentCountError('$id is required'),
                // @phpstan-ignore argument.type
                caller: $caller ?? ['type' => 'direct'],
                input: $input ?? throw new \ArgumentCountError('$input is required'),
                // @phpstan-ignore argument.type
                name: $name ?? throw new \ArgumentCountError('$name is required'),
            ),
            Type::WEB_SEARCH_TOOL_RESULT, 'web_search_tool_result' => WebSearchToolResultBlock::with(
                // @phpstan-ignore argument.type
                caller: $caller ?? ['type' => 'direct'],
                content: $content ?? throw new \ArgumentCountError('$content is required'),
                toolUseID: $toolUseID ?? throw new \ArgumentCountError('$toolUseID is required'),
            ),
            Type::WEB_FETCH_TOOL_RESULT, 'web_fetch_tool_result' => WebFetchToolResultBlock::with(
                // @phpstan-ignore argument.type
                caller: $caller ?? ['type' => 'direct'],
                // @phpstan-ignore argument.type
                content: $content ?? throw new \ArgumentCountError('$content is required'),
                toolUseID: $toolUseID ?? throw new \ArgumentCountError('$toolUseID is required'),
            ),
            Type::CODE_EXECUTION_TOOL_RESULT, 'code_execution_tool_result' => CodeExecutionToolResultBlock::with(
                // @phpstan-ignore argument.type
                content: $content ?? throw new \ArgumentCountError('$content is required'),
                toolUseID: $toolUseID ?? throw new \ArgumentCountError('$toolUseID is required'),
            ),
            Type::BASH_CODE_EXECUTION_TOOL_RESULT, 'bash_code_execution_tool_result' => BashCodeExecutionToolResultBlock::with(
                // @phpstan-ignore argument.type
                content: $content ?? throw new \ArgumentCountError('$content is required'),
                toolUseID: $toolUseID ?? throw new \ArgumentCountError('$toolUseID is required'),
            ),
            Type::TEXT_EDITOR_CODE_EXECUTION_TOOL_RESULT, 'text_editor_code_execution_tool_result' => TextEditorCodeExecutionToolResultBlock::with(
                // @phpstan-ignore argument.type
                content: $content ?? throw new \ArgumentCountError('$content is required'),
                toolUseID: $toolUseID ?? throw new \ArgumentCountError('$toolUseID is required'),
            ),
            Type::TOOL_SEARCH_TOOL_RESULT, 'tool_search_tool_result' => ToolSearchToolResultBlock::with(
                // @phpstan-ignore argument.type
                content: $content ?? throw new \ArgumentCountError('$content is required'),
                toolUseID: $toolUseID ?? throw new \ArgumentCountError('$toolUseID is required'),
            ),
            Type::CONTAINER_UPLOAD, 'container_upload' => ContainerUploadBlock::with(
                fileID: $fileID ?? throw new \ArgumentCountError('$fileID is required'),
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
