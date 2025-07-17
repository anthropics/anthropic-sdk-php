<?php

declare(strict_types=1);

namespace Anthropic\Models\ToolResultBlockParam\Content;

use Anthropic\Core\Concerns\Union;
use Anthropic\Core\Contracts\Converter;
use Anthropic\Core\Contracts\StaticConverter;
use Anthropic\Models\ImageBlockParam;
use Anthropic\Models\TextBlockParam;

final class UnionMember1 implements StaticConverter
{
    use Union;

    public static function discriminator(): string
    {
        return 'type';
    }

    /**
     * @return list<string|Converter|StaticConverter>|array<
     *   string, string|Converter|StaticConverter
     * >
     */
    public static function variants(): array
    {
        return ['text' => TextBlockParam::class, 'image' => ImageBlockParam::class];
    }
}
