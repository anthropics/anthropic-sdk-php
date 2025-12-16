<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Regular text content.
 *
 * @phpstan-import-type TextBlockParamShape from \Anthropic\Messages\TextBlockParam
 * @phpstan-import-type ImageBlockParamShape from \Anthropic\Messages\ImageBlockParam
 * @phpstan-import-type DocumentBlockParamShape from \Anthropic\Messages\DocumentBlockParam
 * @phpstan-import-type SearchResultBlockParamShape from \Anthropic\Messages\SearchResultBlockParam
 * @phpstan-import-type ThinkingBlockParamShape from \Anthropic\Messages\ThinkingBlockParam
 * @phpstan-import-type RedactedThinkingBlockParamShape from \Anthropic\Messages\RedactedThinkingBlockParam
 * @phpstan-import-type ToolUseBlockParamShape from \Anthropic\Messages\ToolUseBlockParam
 * @phpstan-import-type ToolResultBlockParamShape from \Anthropic\Messages\ToolResultBlockParam
 * @phpstan-import-type ServerToolUseBlockParamShape from \Anthropic\Messages\ServerToolUseBlockParam
 * @phpstan-import-type WebSearchToolResultBlockParamShape from \Anthropic\Messages\WebSearchToolResultBlockParam
 *
 * @phpstan-type ContentBlockParamShape = TextBlockParamShape|ImageBlockParamShape|DocumentBlockParamShape|SearchResultBlockParamShape|ThinkingBlockParamShape|RedactedThinkingBlockParamShape|ToolUseBlockParamShape|ToolResultBlockParamShape|ServerToolUseBlockParamShape|WebSearchToolResultBlockParamShape
 */
final class ContentBlockParam implements ConverterSource
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
            'text' => TextBlockParam::class,
            'image' => ImageBlockParam::class,
            'document' => DocumentBlockParam::class,
            'search_result' => SearchResultBlockParam::class,
            'thinking' => ThinkingBlockParam::class,
            'redacted_thinking' => RedactedThinkingBlockParam::class,
            'tool_use' => ToolUseBlockParam::class,
            'tool_result' => ToolResultBlockParam::class,
            'server_tool_use' => ServerToolUseBlockParam::class,
            'web_search_tool_result' => WebSearchToolResultBlockParam::class,
        ];
    }
}
