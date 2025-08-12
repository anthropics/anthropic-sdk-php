<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Concerns\Union;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-type message_count_tokens_tool_alias = Tool|ToolBash20250124|ToolTextEditor20250124|ToolTextEditor20250429|ToolTextEditor20250728|WebSearchTool20250305
 */
final class MessageCountTokensTool implements ConverterSource
{
    use Union;

    /**
     * @return array<string,
     * Converter|ConverterSource|string,>|list<Converter|ConverterSource|string>
     */
    public static function variants(): array
    {
        return [
            Tool::class,
            ToolBash20250124::class,
            ToolTextEditor20250124::class,
            ToolTextEditor20250429::class,
            ToolTextEditor20250728::class,
            WebSearchTool20250305::class,
        ];
    }
}
