<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Concerns\Union;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Models\MessageCountTokensTool\TextEditor20250429;

/**
 * @phpstan-type message_count_tokens_tool_alias = Tool|ToolBash20250124|ToolTextEditor20250124|TextEditor20250429|WebSearchTool20250305
 */
final class MessageCountTokensTool implements ConverterSource
{
    use Union;

    /**
     * @return list<string|Converter|ConverterSource>|array<string,
     * string|Converter|ConverterSource,>
     */
    public static function variants(): array
    {
        return [
            Tool::class,
            ToolBash20250124::class,
            ToolTextEditor20250124::class,
            TextEditor20250429::class,
            WebSearchTool20250305::class,
        ];
    }
}
