<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta\BetaRawContentBlockStartEvent;

use Anthropic\Core\Concerns\Union;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Models\Beta\BetaCodeExecutionToolResultBlock;
use Anthropic\Models\Beta\BetaContainerUploadBlock;
use Anthropic\Models\Beta\BetaMCPToolResultBlock;
use Anthropic\Models\Beta\BetaMCPToolUseBlock;
use Anthropic\Models\Beta\BetaRedactedThinkingBlock;
use Anthropic\Models\Beta\BetaServerToolUseBlock;
use Anthropic\Models\Beta\BetaTextBlock;
use Anthropic\Models\Beta\BetaThinkingBlock;
use Anthropic\Models\Beta\BetaToolUseBlock;
use Anthropic\Models\Beta\BetaWebSearchToolResultBlock;

/**
 * @phpstan-type content_block_alias = BetaTextBlock|BetaThinkingBlock|BetaRedactedThinkingBlock|BetaToolUseBlock|BetaServerToolUseBlock|BetaWebSearchToolResultBlock|BetaCodeExecutionToolResultBlock|BetaMCPToolUseBlock|BetaMCPToolResultBlock|BetaContainerUploadBlock
 */
final class ContentBlock implements ConverterSource
{
    use Union;

    public static function discriminator(): string
    {
        return 'type';
    }

    /**
     * @return list<string|Converter|ConverterSource>|array<
     *   string, string|Converter|ConverterSource
     * >
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
            'code_execution_tool_result' => BetaCodeExecutionToolResultBlock::class,
            'mcp_tool_use' => BetaMCPToolUseBlock::class,
            'mcp_tool_result' => BetaMCPToolResultBlock::class,
            'container_upload' => BetaContainerUploadBlock::class,
        ];
    }
}
