<?php

declare(strict_types=1);

namespace Anthropic\Messages;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

final class ToolUnion implements ConverterSource
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
