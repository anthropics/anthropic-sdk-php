<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Code execution tool with REPL state persistence (daemon mode + gVisor checkpoint).
 *
 * @phpstan-import-type ToolShape from \Anthropic\Messages\Tool
 * @phpstan-import-type ToolBash20250124Shape from \Anthropic\Messages\ToolBash20250124
 * @phpstan-import-type CodeExecutionTool20250522Shape from \Anthropic\Messages\CodeExecutionTool20250522
 * @phpstan-import-type CodeExecutionTool20250825Shape from \Anthropic\Messages\CodeExecutionTool20250825
 * @phpstan-import-type CodeExecutionTool20260120Shape from \Anthropic\Messages\CodeExecutionTool20260120
 * @phpstan-import-type MemoryTool20250818Shape from \Anthropic\Messages\MemoryTool20250818
 * @phpstan-import-type ToolTextEditor20250124Shape from \Anthropic\Messages\ToolTextEditor20250124
 * @phpstan-import-type ToolTextEditor20250429Shape from \Anthropic\Messages\ToolTextEditor20250429
 * @phpstan-import-type ToolTextEditor20250728Shape from \Anthropic\Messages\ToolTextEditor20250728
 * @phpstan-import-type WebSearchTool20250305Shape from \Anthropic\Messages\WebSearchTool20250305
 * @phpstan-import-type WebFetchTool20250910Shape from \Anthropic\Messages\WebFetchTool20250910
 * @phpstan-import-type WebSearchTool20260209Shape from \Anthropic\Messages\WebSearchTool20260209
 * @phpstan-import-type WebFetchTool20260209Shape from \Anthropic\Messages\WebFetchTool20260209
 * @phpstan-import-type ToolSearchToolBm25_20251119Shape from \Anthropic\Messages\ToolSearchToolBm25_20251119
 * @phpstan-import-type ToolSearchToolRegex20251119Shape from \Anthropic\Messages\ToolSearchToolRegex20251119
 *
 * @phpstan-type MessageCountTokensToolVariants = Tool|ToolBash20250124|CodeExecutionTool20250522|CodeExecutionTool20250825|CodeExecutionTool20260120|MemoryTool20250818|ToolTextEditor20250124|ToolTextEditor20250429|ToolTextEditor20250728|WebSearchTool20250305|WebFetchTool20250910|WebSearchTool20260209|WebFetchTool20260209|ToolSearchToolBm25_20251119|ToolSearchToolRegex20251119
 * @phpstan-type MessageCountTokensToolShape = MessageCountTokensToolVariants|ToolShape|ToolBash20250124Shape|CodeExecutionTool20250522Shape|CodeExecutionTool20250825Shape|CodeExecutionTool20260120Shape|MemoryTool20250818Shape|ToolTextEditor20250124Shape|ToolTextEditor20250429Shape|ToolTextEditor20250728Shape|WebSearchTool20250305Shape|WebFetchTool20250910Shape|WebSearchTool20260209Shape|WebFetchTool20260209Shape|ToolSearchToolBm25_20251119Shape|ToolSearchToolRegex20251119Shape
 */
final class MessageCountTokensTool implements ConverterSource
{
    use SdkUnion;

    /**
     * @return list<string|Converter|ConverterSource>|array<string,string|Converter|ConverterSource>
     */
    public static function variants(): array
    {
        return [
            Tool::class,
            ToolBash20250124::class,
            CodeExecutionTool20250522::class,
            CodeExecutionTool20250825::class,
            CodeExecutionTool20260120::class,
            MemoryTool20250818::class,
            ToolTextEditor20250124::class,
            ToolTextEditor20250429::class,
            ToolTextEditor20250728::class,
            WebSearchTool20250305::class,
            WebFetchTool20250910::class,
            WebSearchTool20260209::class,
            WebFetchTool20260209::class,
            ToolSearchToolBm25_20251119::class,
            ToolSearchToolRegex20251119::class,
        ];
    }
}
