<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-type content_block_alias = TextBlock|ThinkingBlock|RedactedThinkingBlock|ToolUseBlock|ServerToolUseBlock|WebSearchToolResultBlock
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
            'text' => TextBlock::class,
            'thinking' => ThinkingBlock::class,
            'redacted_thinking' => RedactedThinkingBlock::class,
            'tool_use' => ToolUseBlock::class,
            'server_tool_use' => ServerToolUseBlock::class,
            'web_search_tool_result' => WebSearchToolResultBlock::class,
        ];
    }
}
