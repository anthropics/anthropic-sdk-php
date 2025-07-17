<?php

declare(strict_types=1);

namespace Anthropic\Models\DocumentBlockParam;

use Anthropic\Core\Concerns\Union;
use Anthropic\Core\Contracts\Converter;
use Anthropic\Core\Contracts\StaticConverter;
use Anthropic\Models\Base64PDFSource;
use Anthropic\Models\ContentBlockSource;
use Anthropic\Models\PlainTextSource;
use Anthropic\Models\URLPDFSource;

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
            'base64' => Base64PDFSource::class,
            'text' => PlainTextSource::class,
            'content' => ContentBlockSource::class,
            'url' => URLPDFSource::class,
        ];
    }
}
