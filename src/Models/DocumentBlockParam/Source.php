<?php

declare(strict_types=1);

namespace Anthropic\Models\DocumentBlockParam;

use Anthropic\Core\Concerns\Union;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Models\Base64PDFSource;
use Anthropic\Models\ContentBlockSource;
use Anthropic\Models\PlainTextSource;
use Anthropic\Models\URLPDFSource;

/**
 * @phpstan-type source_alias = Base64PDFSource|PlainTextSource|ContentBlockSource|URLPDFSource
 */
final class Source implements ConverterSource
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
            'base64' => Base64PDFSource::class,
            'text' => PlainTextSource::class,
            'content' => ContentBlockSource::class,
            'url' => URLPDFSource::class,
        ];
    }
}
