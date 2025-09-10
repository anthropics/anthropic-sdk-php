<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaRawContentBlockStartEvent;

use Anthropic\Beta\Messages\BetaBashCodeExecutionToolResultBlock;
use Anthropic\Beta\Messages\BetaCodeExecutionToolResultBlock;
use Anthropic\Beta\Messages\BetaContainerUploadBlock;
use Anthropic\Beta\Messages\BetaMCPToolResultBlock;
use Anthropic\Beta\Messages\BetaMCPToolUseBlock;
use Anthropic\Beta\Messages\BetaRedactedThinkingBlock;
use Anthropic\Beta\Messages\BetaServerToolUseBlock;
use Anthropic\Beta\Messages\BetaTextBlock;
use Anthropic\Beta\Messages\BetaTextEditorCodeExecutionToolResultBlock;
use Anthropic\Beta\Messages\BetaThinkingBlock;
use Anthropic\Beta\Messages\BetaToolUseBlock;
use Anthropic\Beta\Messages\BetaWebFetchToolResultBlock;
use Anthropic\Beta\Messages\BetaWebSearchToolResultBlock;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Response model for a file uploaded to the container.
 */
final class ContentBlock implements ConverterSource
{
    use SdkUnion;

    public static function discriminator(): string
    {
        return 'type';
    }

    /**
     * @return list<string|Converter|ConverterSource>|array<string,
     * string|Converter|ConverterSource,>
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
            'code_execution_tool_result' => BetaCodeExecutionToolResultBlock::class,
            'bash_code_execution_tool_result' => BetaBashCodeExecutionToolResultBlock::class,
            'text_editor_code_execution_tool_result' => BetaTextEditorCodeExecutionToolResultBlock::class,
            'mcp_tool_use' => BetaMCPToolUseBlock::class,
            'mcp_tool_result' => BetaMCPToolResultBlock::class,
            'container_upload' => BetaContainerUploadBlock::class,
        ];
    }
}
