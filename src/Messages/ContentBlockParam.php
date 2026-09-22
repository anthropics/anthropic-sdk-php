<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Messages\ContentBlockParam\Type;
use Anthropic\Messages\ServerToolUseBlockParam\Name;

/**
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
 * @phpstan-import-type CacheControlEphemeralShape from \Anthropic\Messages\CacheControlEphemeral
 * @phpstan-import-type TextCitationParamShape from \Anthropic\Messages\TextCitationParam
 * @phpstan-import-type CitationsConfigParamShape from \Anthropic\Messages\CitationsConfigParam
 * @phpstan-import-type SourceShape from \Anthropic\Messages\ImageBlockParam\Source
 * @phpstan-import-type SourceShape from \Anthropic\Messages\DocumentBlockParam\Source as SourceShape1
 * @phpstan-import-type ImageTransformationsParamShape from \Anthropic\Messages\ImageTransformationsParam
 * @phpstan-import-type ContentShape from \Anthropic\Messages\ToolResultBlockParam\Content
 * @phpstan-import-type WebSearchToolResultBlockParamContentShape from \Anthropic\Messages\WebSearchToolResultBlockParamContent
 * @phpstan-import-type ContentShape from \Anthropic\Messages\WebFetchToolResultBlockParam\Content as ContentShape1
 * @phpstan-import-type CodeExecutionToolResultBlockParamContentShape from \Anthropic\Messages\CodeExecutionToolResultBlockParamContent
 * @phpstan-import-type ContentShape from \Anthropic\Messages\BashCodeExecutionToolResultBlockParam\Content as ContentShape2
 * @phpstan-import-type ContentShape from \Anthropic\Messages\TextEditorCodeExecutionToolResultBlockParam\Content as ContentShape3
 * @phpstan-import-type ContentShape from \Anthropic\Messages\ToolSearchToolResultBlockParam\Content as ContentShape4
 * @phpstan-import-type CallerShape from \Anthropic\Messages\ToolUseBlockParam\Caller
 * @phpstan-import-type CallerShape from \Anthropic\Messages\ServerToolUseBlockParam\Caller as CallerShape1
 * @phpstan-import-type CallerShape from \Anthropic\Messages\WebSearchToolResultBlockParam\Caller as CallerShape2
 * @phpstan-import-type CallerShape from \Anthropic\Messages\WebFetchToolResultBlockParam\Caller as CallerShape3
 * @phpstan-import-type TextBlockParamShape from \Anthropic\Messages\TextBlockParam
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

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @param CacheControlEphemeral|CacheControlEphemeralShape|null $cacheControl
     * @param ($type is Type::TEXT|'text' ? list<TextCitationParamShape>|null : CitationsConfigParam|CitationsConfigParamShape|null) $citations
     * @param ($type is Type::IMAGE|'image' ? SourceShape|null : ($type is Type::DOCUMENT|'document' ? SourceShape1|null : string|null)) $source
     * @param ImageTransformationsParam|ImageTransformationsParamShape|null $transformations
     * @param ($type is Type::SEARCH_RESULT|'search_result' ? list<TextBlockParam|TextBlockParamShape>|null : ($type is Type::TOOL_RESULT|'tool_result' ? ContentShape|null : ($type is Type::WEB_SEARCH_TOOL_RESULT|'web_search_tool_result' ? WebSearchToolResultBlockParamContentShape|null : ($type is Type::WEB_FETCH_TOOL_RESULT|'web_fetch_tool_result' ? ContentShape1|null : ($type is Type::CODE_EXECUTION_TOOL_RESULT|'code_execution_tool_result' ? CodeExecutionToolResultBlockParamContentShape|null : ($type is Type::BASH_CODE_EXECUTION_TOOL_RESULT|'bash_code_execution_tool_result' ? ContentShape2|null : ($type is Type::TEXT_EDITOR_CODE_EXECUTION_TOOL_RESULT|'text_editor_code_execution_tool_result' ? ContentShape3|null : ContentShape4|null))))))) $content
     * @param array<string,mixed>|null $input
     * @param ($type is Type::TOOL_USE|'tool_use' ? string|null : Name|value-of<Name>|null) $name
     * @param ($type is Type::TOOL_USE|'tool_use' ? CallerShape|null : ($type is Type::SERVER_TOOL_USE|'server_tool_use' ? CallerShape1|null : ($type is Type::WEB_SEARCH_TOOL_RESULT|'web_search_tool_result' ? CallerShape2|null : CallerShape3|null))) $caller
     *
     * @return ($type is Type::TEXT|'text' ? TextBlockParam : ($type is Type::IMAGE|'image' ? ImageBlockParam : ($type is Type::DOCUMENT|'document' ? DocumentBlockParam : ($type is Type::SEARCH_RESULT|'search_result' ? SearchResultBlockParam : ($type is Type::THINKING|'thinking' ? ThinkingBlockParam : ($type is Type::REDACTED_THINKING|'redacted_thinking' ? RedactedThinkingBlockParam : ($type is Type::TOOL_USE|'tool_use' ? ToolUseBlockParam : ($type is Type::TOOL_RESULT|'tool_result' ? ToolResultBlockParam : ($type is Type::SERVER_TOOL_USE|'server_tool_use' ? ServerToolUseBlockParam : ($type is Type::WEB_SEARCH_TOOL_RESULT|'web_search_tool_result' ? WebSearchToolResultBlockParam : ($type is Type::WEB_FETCH_TOOL_RESULT|'web_fetch_tool_result' ? WebFetchToolResultBlockParam : ($type is Type::CODE_EXECUTION_TOOL_RESULT|'code_execution_tool_result' ? CodeExecutionToolResultBlockParam : ($type is Type::BASH_CODE_EXECUTION_TOOL_RESULT|'bash_code_execution_tool_result' ? BashCodeExecutionToolResultBlockParam : ($type is Type::TEXT_EDITOR_CODE_EXECUTION_TOOL_RESULT|'text_editor_code_execution_tool_result' ? TextEditorCodeExecutionToolResultBlockParam : ($type is Type::TOOL_SEARCH_TOOL_RESULT|'tool_search_tool_result' ? ToolSearchToolResultBlockParam : ($type is Type::CONTAINER_UPLOAD|'container_upload' ? ContainerUploadBlockParam : TextBlockParam|ImageBlockParam|DocumentBlockParam|SearchResultBlockParam|ThinkingBlockParam|RedactedThinkingBlockParam|ToolUseBlockParam|ToolResultBlockParam|ServerToolUseBlockParam|WebSearchToolResultBlockParam|WebFetchToolResultBlockParam|CodeExecutionToolResultBlockParam|BashCodeExecutionToolResultBlockParam|TextEditorCodeExecutionToolResultBlockParam|ToolSearchToolResultBlockParam|ContainerUploadBlockParam))))))))))))))))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        ?string $text = null,
        CacheControlEphemeral|array|null $cacheControl = null,
        array|CitationsConfigParam|null $citations = null,
        string|Base64ImageSource|array|URLImageSource|FileImageSource|Base64PDFSource|PlainTextSource|ContentBlockSource|URLPDFSource|FileDocumentSource|null $source = null,
        ImageTransformationsParam|array|null $transformations = null,
        ?string $context = null,
        ?string $title = null,
        string|array|WebSearchToolRequestError|WebFetchToolResultErrorBlockParam|WebFetchBlockParam|CodeExecutionToolResultErrorParam|CodeExecutionResultBlockParam|EncryptedCodeExecutionResultBlockParam|BashCodeExecutionToolResultErrorParam|BashCodeExecutionResultBlockParam|TextEditorCodeExecutionToolResultErrorParam|TextEditorCodeExecutionViewResultBlockParam|TextEditorCodeExecutionCreateResultBlockParam|TextEditorCodeExecutionStrReplaceResultBlockParam|ToolSearchToolResultErrorParam|ToolSearchToolSearchResultBlockParam|null $content = null,
        ?string $signature = null,
        ?string $thinking = null,
        ?string $data = null,
        ?string $id = null,
        ?array $input = null,
        string|Name|null $name = null,
        DirectCaller|array|ServerToolCaller|ServerToolCaller20260120|null $caller = null,
        ?string $toolsetName = null,
        ?string $toolUseID = null,
        ?bool $isError = null,
        ?string $fileID = null,
    ): TextBlockParam|ImageBlockParam|DocumentBlockParam|SearchResultBlockParam|ThinkingBlockParam|RedactedThinkingBlockParam|ToolUseBlockParam|ToolResultBlockParam|ServerToolUseBlockParam|WebSearchToolResultBlockParam|WebFetchToolResultBlockParam|CodeExecutionToolResultBlockParam|BashCodeExecutionToolResultBlockParam|TextEditorCodeExecutionToolResultBlockParam|ToolSearchToolResultBlockParam|ContainerUploadBlockParam {
        return match ($type) {
            Type::TEXT, 'text' => TextBlockParam::with(
                text: $text ?? throw new \ArgumentCountError('$text is required'),
                cacheControl: $cacheControl,
                citations: $citations,
            ),
            Type::IMAGE, 'image' => ImageBlockParam::with(
                source: $source ?? throw new \ArgumentCountError('$source is required'),
                cacheControl: $cacheControl,
                transformations: $transformations,
            ),
            Type::DOCUMENT, 'document' => DocumentBlockParam::with(
                // @phpstan-ignore argument.type
                source: $source ?? throw new \ArgumentCountError('$source is required'),
                cacheControl: $cacheControl,
                // @phpstan-ignore argument.type
                citations: $citations,
                context: $context,
                title: $title,
            ),
            Type::SEARCH_RESULT, 'search_result' => SearchResultBlockParam::with(
                content: $content ?? throw new \ArgumentCountError('$content is required'),
                // @phpstan-ignore argument.type
                source: $source ?? throw new \ArgumentCountError('$source is required'),
                title: $title ?? throw new \ArgumentCountError('$title is required'),
                cacheControl: $cacheControl,
                // @phpstan-ignore argument.type
                citations: $citations,
            ),
            Type::THINKING, 'thinking' => ThinkingBlockParam::with(
                signature: $signature ?? throw new \ArgumentCountError('$signature is required'),
                thinking: $thinking ?? throw new \ArgumentCountError('$thinking is required'),
            ),
            Type::REDACTED_THINKING, 'redacted_thinking' => RedactedThinkingBlockParam::with(
                data: $data ?? throw new \ArgumentCountError('$data is required')
            ),
            Type::TOOL_USE, 'tool_use' => ToolUseBlockParam::with(
                id: $id ?? throw new \ArgumentCountError('$id is required'),
                input: $input ?? throw new \ArgumentCountError('$input is required'),
                name: $name ?? throw new \ArgumentCountError('$name is required'),
                cacheControl: $cacheControl,
                caller: $caller,
                toolsetName: $toolsetName,
            ),
            Type::TOOL_RESULT, 'tool_result' => ToolResultBlockParam::with(
                toolUseID: $toolUseID ?? throw new \ArgumentCountError('$toolUseID is required'),
                cacheControl: $cacheControl,
                // @phpstan-ignore argument.type
                content: $content,
                isError: $isError,
                toolsetName: $toolsetName,
            ),
            Type::SERVER_TOOL_USE, 'server_tool_use' => ServerToolUseBlockParam::with(
                id: $id ?? throw new \ArgumentCountError('$id is required'),
                input: $input ?? throw new \ArgumentCountError('$input is required'),
                // @phpstan-ignore argument.type
                name: $name ?? throw new \ArgumentCountError('$name is required'),
                cacheControl: $cacheControl,
                // @phpstan-ignore argument.type
                caller: $caller,
            ),
            Type::WEB_SEARCH_TOOL_RESULT, 'web_search_tool_result' => WebSearchToolResultBlockParam::with(
                // @phpstan-ignore argument.type
                content: $content ?? throw new \ArgumentCountError('$content is required'),
                toolUseID: $toolUseID ?? throw new \ArgumentCountError('$toolUseID is required'),
                cacheControl: $cacheControl,
                // @phpstan-ignore argument.type
                caller: $caller,
            ),
            Type::WEB_FETCH_TOOL_RESULT, 'web_fetch_tool_result' => WebFetchToolResultBlockParam::with(
                // @phpstan-ignore argument.type
                content: $content ?? throw new \ArgumentCountError('$content is required'),
                toolUseID: $toolUseID ?? throw new \ArgumentCountError('$toolUseID is required'),
                cacheControl: $cacheControl,
                // @phpstan-ignore argument.type
                caller: $caller,
            ),
            Type::CODE_EXECUTION_TOOL_RESULT, 'code_execution_tool_result' => CodeExecutionToolResultBlockParam::with(
                // @phpstan-ignore argument.type
                content: $content ?? throw new \ArgumentCountError('$content is required'),
                toolUseID: $toolUseID ?? throw new \ArgumentCountError('$toolUseID is required'),
                cacheControl: $cacheControl,
            ),
            Type::BASH_CODE_EXECUTION_TOOL_RESULT, 'bash_code_execution_tool_result' => BashCodeExecutionToolResultBlockParam::with(
                // @phpstan-ignore argument.type
                content: $content ?? throw new \ArgumentCountError('$content is required'),
                toolUseID: $toolUseID ?? throw new \ArgumentCountError('$toolUseID is required'),
                cacheControl: $cacheControl,
            ),
            Type::TEXT_EDITOR_CODE_EXECUTION_TOOL_RESULT, 'text_editor_code_execution_tool_result' => TextEditorCodeExecutionToolResultBlockParam::with(
                // @phpstan-ignore argument.type
                content: $content ?? throw new \ArgumentCountError('$content is required'),
                toolUseID: $toolUseID ?? throw new \ArgumentCountError('$toolUseID is required'),
                cacheControl: $cacheControl,
            ),
            Type::TOOL_SEARCH_TOOL_RESULT, 'tool_search_tool_result' => ToolSearchToolResultBlockParam::with(
                // @phpstan-ignore argument.type
                content: $content ?? throw new \ArgumentCountError('$content is required'),
                toolUseID: $toolUseID ?? throw new \ArgumentCountError('$toolUseID is required'),
                cacheControl: $cacheControl,
            ),
            Type::CONTAINER_UPLOAD, 'container_upload' => ContainerUploadBlockParam::with(
                fileID: $fileID ?? throw new \ArgumentCountError('$fileID is required'),
                cacheControl: $cacheControl,
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
