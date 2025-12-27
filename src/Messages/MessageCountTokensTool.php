<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-import-type ToolShape from \Anthropic\Messages\Tool
 * @phpstan-import-type ToolBash20250124Shape from \Anthropic\Messages\ToolBash20250124
 * @phpstan-import-type ToolTextEditor20250124Shape from \Anthropic\Messages\ToolTextEditor20250124
 * @phpstan-import-type ToolTextEditor20250429Shape from \Anthropic\Messages\ToolTextEditor20250429
 * @phpstan-import-type ToolTextEditor20250728Shape from \Anthropic\Messages\ToolTextEditor20250728
 * @phpstan-import-type WebSearchTool20250305Shape from \Anthropic\Messages\WebSearchTool20250305
 *
 * @phpstan-type MessageCountTokensToolShape = ToolShape|ToolBash20250124Shape|ToolTextEditor20250124Shape|ToolTextEditor20250429Shape|ToolTextEditor20250728Shape|WebSearchTool20250305Shape
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
            ToolTextEditor20250124::class,
            ToolTextEditor20250429::class,
            ToolTextEditor20250728::class,
            WebSearchTool20250305::class,
        ];
    }
}
