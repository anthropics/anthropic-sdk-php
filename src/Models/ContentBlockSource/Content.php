<?php

declare(strict_types=1);

namespace Anthropic\Models\ContentBlockSource;

use Anthropic\Core\Concerns\Union;
use Anthropic\Core\Contracts\Converter;
use Anthropic\Core\Contracts\StaticConverter;
use Anthropic\Core\Conversion\ListOf;
use Anthropic\Core\Conversion\UnionOf;
use Anthropic\Models\ImageBlockParam;
use Anthropic\Models\TextBlockParam;

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
            new ListOf(new UnionOf([TextBlockParam::class, ImageBlockParam::class])),
        ];
    }
}
