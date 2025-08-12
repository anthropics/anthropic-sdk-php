<?php

declare(strict_types=1);

namespace Anthropic\Messages\DocumentBlockParam;

use Anthropic\Core\Concerns\Union;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Messages\Base64PDFSource;
use Anthropic\Messages\ContentBlockSource;
use Anthropic\Messages\PlainTextSource;
use Anthropic\Messages\URLPDFSource;

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
