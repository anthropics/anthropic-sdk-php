<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Response model for a file uploaded to the container.
 *
 * @phpstan-type beta_content_block_alias = BetaTextBlock|BetaThinkingBlock|BetaRedactedThinkingBlock|BetaToolUseBlock|BetaServerToolUseBlock|BetaWebSearchToolResultBlock|BetaCodeExecutionToolResultBlock|BetaMCPToolUseBlock|BetaMCPToolResultBlock|BetaContainerUploadBlock
 */
final class BetaContentBlock implements ConverterSource
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
            'code_execution_tool_result' => BetaCodeExecutionToolResultBlock::class,
            'mcp_tool_use' => BetaMCPToolUseBlock::class,
            'mcp_tool_result' => BetaMCPToolResultBlock::class,
            'container_upload' => BetaContainerUploadBlock::class,
        ];
    }
}
