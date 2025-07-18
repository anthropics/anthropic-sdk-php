<?php

declare(strict_types=1);

namespace Anthropic\Models\ToolResultBlockParam;

use Anthropic\Core\Concerns\Union;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Core\Conversion\ListOf;
use Anthropic\Core\Conversion\UnionOf;
use Anthropic\Models\ImageBlockParam;
use Anthropic\Models\TextBlockParam;

final class Content implements ConverterSource
{
    use Union;

    /**
     * @return list<string|Converter|ConverterSource>|array<
     *   string, string|Converter|ConverterSource
     * >
     */
    public static function variants(): array
    {
        return [
            'string',
            new ListOf(new UnionOf([TextBlockParam::class, ImageBlockParam::class])),
        ];
    }
}
