<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaRawContentBlockStartEvent;

use Anthropic\Beta\Messages\BetaCodeExecutionToolResultBlock;
use Anthropic\Beta\Messages\BetaContainerUploadBlock;
use Anthropic\Beta\Messages\BetaMCPToolResultBlock;
use Anthropic\Beta\Messages\BetaMCPToolUseBlock;
use Anthropic\Beta\Messages\BetaRedactedThinkingBlock;
use Anthropic\Beta\Messages\BetaServerToolUseBlock;
use Anthropic\Beta\Messages\BetaTextBlock;
use Anthropic\Beta\Messages\BetaThinkingBlock;
use Anthropic\Beta\Messages\BetaToolUseBlock;
use Anthropic\Beta\Messages\BetaWebSearchToolResultBlock;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Response model for a file uploaded to the container.
 *
 * @phpstan-type content_block_alias = BetaTextBlock|BetaThinkingBlock|BetaRedactedThinkingBlock|BetaToolUseBlock|BetaServerToolUseBlock|BetaWebSearchToolResultBlock|BetaCodeExecutionToolResultBlock|BetaMCPToolUseBlock|BetaMCPToolResultBlock|BetaContainerUploadBlock
 */
final class ContentBlock implements ConverterSource
{
    use SdkUnion;

    public static function discriminator(): string
    {
        return 'type';
    }

    /**
     * @return array<string,
     * Converter|ConverterSource|string,>|list<Converter|ConverterSource|string>
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
