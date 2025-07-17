<?php

declare(strict_types=1);

namespace Anthropic\Models\ImageBlockParam;

use Anthropic\Core\Concerns\Union;
use Anthropic\Core\Contracts\Converter;
use Anthropic\Core\Contracts\StaticConverter;
use Anthropic\Models\Base64ImageSource;
use Anthropic\Models\URLImageSource;

final class Source implements StaticConverter
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
        return [
            'base64' => Base64ImageSource::class, 'url' => URLImageSource::class,
        ];
    }
}
