<?php

declare(strict_types=1);

namespace Anthropic\Models\RawContentBlockStartEvent;

use Anthropic\Core\Concerns\Union;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Models\RedactedThinkingBlock;
use Anthropic\Models\ServerToolUseBlock;
use Anthropic\Models\TextBlock;
use Anthropic\Models\ThinkingBlock;
use Anthropic\Models\ToolUseBlock;
use Anthropic\Models\WebSearchToolResultBlock;

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
            'text' => TextBlock::class,
            'thinking' => ThinkingBlock::class,
            'redacted_thinking' => RedactedThinkingBlock::class,
            'tool_use' => ToolUseBlock::class,
            'server_tool_use' => ServerToolUseBlock::class,
            'web_search_tool_result' => WebSearchToolResultBlock::class,
        ];
    }
}
