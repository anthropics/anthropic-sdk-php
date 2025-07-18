<?php

declare(strict_types=1);

namespace Anthropic\Models\MessageParam;

use Anthropic\Core\Concerns\Union;
use Anthropic\Core\Contracts\Converter;
use Anthropic\Core\Contracts\StaticConverter;
use Anthropic\Core\Conversion\ListOf;
use Anthropic\Core\Conversion\UnionOf;
use Anthropic\Models\DocumentBlockParam;
use Anthropic\Models\ImageBlockParam;
use Anthropic\Models\RedactedThinkingBlockParam;
use Anthropic\Models\ServerToolUseBlockParam;
use Anthropic\Models\TextBlockParam;
use Anthropic\Models\ThinkingBlockParam;
use Anthropic\Models\ToolResultBlockParam;
use Anthropic\Models\ToolUseBlockParam;
use Anthropic\Models\WebSearchToolResultBlockParam;

final class Content implements StaticConverter
{
    use Union;

    /**
     * @return list<string|Converter|StaticConverter>|array<
     *   string, string|Converter|StaticConverter
     * >
     */
    public static function variants(): array
    {
        return [
            'string',
            new ListOf(
                new UnionOf(
                    [
                        TextBlockParam::class,
                        ImageBlockParam::class,
                        DocumentBlockParam::class,
                        ThinkingBlockParam::class,
                        RedactedThinkingBlockParam::class,
                        ToolUseBlockParam::class,
                        ToolResultBlockParam::class,
                        ServerToolUseBlockParam::class,
                        WebSearchToolResultBlockParam::class,
                    ],
                ),
            ),
        ];
    }
}
