<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-import-type TextBlockShape from \Anthropic\Messages\TextBlock
 * @phpstan-import-type ThinkingBlockShape from \Anthropic\Messages\ThinkingBlock
 * @phpstan-import-type RedactedThinkingBlockShape from \Anthropic\Messages\RedactedThinkingBlock
 * @phpstan-import-type ToolUseBlockShape from \Anthropic\Messages\ToolUseBlock
 * @phpstan-import-type ServerToolUseBlockShape from \Anthropic\Messages\ServerToolUseBlock
 * @phpstan-import-type WebSearchToolResultBlockShape from \Anthropic\Messages\WebSearchToolResultBlock
 *
 * @phpstan-type ContentBlockShape = TextBlockShape|ThinkingBlockShape|RedactedThinkingBlockShape|ToolUseBlockShape|ServerToolUseBlockShape|WebSearchToolResultBlockShape
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
        ];
    }
}
