<?php

declare(strict_types=1);

namespace Anthropic\Messages\RawContentBlockStartEvent;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Messages\BashCodeExecutionToolResultBlock;
use Anthropic\Messages\CodeExecutionToolResultBlock;
use Anthropic\Messages\ContainerUploadBlock;
use Anthropic\Messages\RedactedThinkingBlock;
use Anthropic\Messages\ServerToolUseBlock;
use Anthropic\Messages\TextBlock;
use Anthropic\Messages\TextEditorCodeExecutionToolResultBlock;
use Anthropic\Messages\ThinkingBlock;
use Anthropic\Messages\ToolSearchToolResultBlock;
use Anthropic\Messages\ToolUseBlock;
use Anthropic\Messages\WebFetchToolResultBlock;
use Anthropic\Messages\WebSearchToolResultBlock;

/**
 * Response model for a file uploaded to the container.
 *
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
}
