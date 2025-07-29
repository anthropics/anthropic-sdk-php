<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Concerns\Union;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Regular text content.
 *
 * @phpstan-type content_block_param_alias = TextBlockParam|ImageBlockParam|DocumentBlockParam|ThinkingBlockParam|RedactedThinkingBlockParam|ToolUseBlockParam|ToolResultBlockParam|ServerToolUseBlockParam|WebSearchToolResultBlockParam
 */
final class ContentBlockParam implements ConverterSource
{
    use Union;

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
            'text' => TextBlockParam::class,
            'image' => ImageBlockParam::class,
            'document' => DocumentBlockParam::class,
            'thinking' => ThinkingBlockParam::class,
            'redacted_thinking' => RedactedThinkingBlockParam::class,
            'tool_use' => ToolUseBlockParam::class,
            'tool_result' => ToolResultBlockParam::class,
            'server_tool_use' => ServerToolUseBlockParam::class,
            'web_search_tool_result' => WebSearchToolResultBlockParam::class,
        ];
    }
}
