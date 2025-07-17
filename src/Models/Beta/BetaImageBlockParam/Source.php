<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta\BetaImageBlockParam;

use Anthropic\Core\Concerns\Union;
use Anthropic\Core\Contracts\Converter;
use Anthropic\Core\Contracts\StaticConverter;
use Anthropic\Models\Beta\BetaBase64ImageSource;
use Anthropic\Models\Beta\BetaFileImageSource;
use Anthropic\Models\Beta\BetaURLImageSource;

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
            'base64' => BetaBase64ImageSource::class,
            'url' => BetaURLImageSource::class,
            'file' => BetaFileImageSource::class,
        ];
    }
}
