<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Response model for a file uploaded to the container.
 *
 * @phpstan-import-type BetaTextBlockShape from \Anthropic\Beta\Messages\BetaTextBlock
 * @phpstan-import-type BetaThinkingBlockShape from \Anthropic\Beta\Messages\BetaThinkingBlock
 * @phpstan-import-type BetaRedactedThinkingBlockShape from \Anthropic\Beta\Messages\BetaRedactedThinkingBlock
 * @phpstan-import-type BetaToolUseBlockShape from \Anthropic\Beta\Messages\BetaToolUseBlock
 * @phpstan-import-type BetaServerToolUseBlockShape from \Anthropic\Beta\Messages\BetaServerToolUseBlock
 * @phpstan-import-type BetaWebSearchToolResultBlockShape from \Anthropic\Beta\Messages\BetaWebSearchToolResultBlock
 * @phpstan-import-type BetaWebFetchToolResultBlockShape from \Anthropic\Beta\Messages\BetaWebFetchToolResultBlock
 * @phpstan-import-type BetaCodeExecutionToolResultBlockShape from \Anthropic\Beta\Messages\BetaCodeExecutionToolResultBlock
 * @phpstan-import-type BetaBashCodeExecutionToolResultBlockShape from \Anthropic\Beta\Messages\BetaBashCodeExecutionToolResultBlock
 * @phpstan-import-type BetaTextEditorCodeExecutionToolResultBlockShape from \Anthropic\Beta\Messages\BetaTextEditorCodeExecutionToolResultBlock
 * @phpstan-import-type BetaToolSearchToolResultBlockShape from \Anthropic\Beta\Messages\BetaToolSearchToolResultBlock
 * @phpstan-import-type BetaMCPToolUseBlockShape from \Anthropic\Beta\Messages\BetaMCPToolUseBlock
 * @phpstan-import-type BetaMCPToolResultBlockShape from \Anthropic\Beta\Messages\BetaMCPToolResultBlock
 * @phpstan-import-type BetaContainerUploadBlockShape from \Anthropic\Beta\Messages\BetaContainerUploadBlock
 * @phpstan-import-type BetaCompactionBlockShape from \Anthropic\Beta\Messages\BetaCompactionBlock
 *
 * @phpstan-type BetaContentBlockVariants = BetaTextBlock|BetaThinkingBlock|BetaRedactedThinkingBlock|BetaToolUseBlock|BetaServerToolUseBlock|BetaWebSearchToolResultBlock|BetaWebFetchToolResultBlock|BetaCodeExecutionToolResultBlock|BetaBashCodeExecutionToolResultBlock|BetaTextEditorCodeExecutionToolResultBlock|BetaToolSearchToolResultBlock|BetaMCPToolUseBlock|BetaMCPToolResultBlock|BetaContainerUploadBlock|BetaCompactionBlock
 * @phpstan-type BetaContentBlockShape = BetaContentBlockVariants|BetaTextBlockShape|BetaThinkingBlockShape|BetaRedactedThinkingBlockShape|BetaToolUseBlockShape|BetaServerToolUseBlockShape|BetaWebSearchToolResultBlockShape|BetaWebFetchToolResultBlockShape|BetaCodeExecutionToolResultBlockShape|BetaBashCodeExecutionToolResultBlockShape|BetaTextEditorCodeExecutionToolResultBlockShape|BetaToolSearchToolResultBlockShape|BetaMCPToolUseBlockShape|BetaMCPToolResultBlockShape|BetaContainerUploadBlockShape|BetaCompactionBlockShape
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
            'code_execution_tool_result' => BetaCodeExecutionToolResultBlock::class,
            'bash_code_execution_tool_result' => BetaBashCodeExecutionToolResultBlock::class,
            'text_editor_code_execution_tool_result' => BetaTextEditorCodeExecutionToolResultBlock::class,
            'tool_search_tool_result' => BetaToolSearchToolResultBlock::class,
            'mcp_tool_use' => BetaMCPToolUseBlock::class,
            'mcp_tool_result' => BetaMCPToolResultBlock::class,
            'container_upload' => BetaContainerUploadBlock::class,
            'compaction' => BetaCompactionBlock::class,
        ];
    }
}
