<?php

declare(strict_types=1);

namespace Anthropic\Messages\DocumentBlockParam;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Messages\Base64PDFSource;
use Anthropic\Messages\ContentBlockSource;
use Anthropic\Messages\PlainTextSource;
use Anthropic\Messages\URLPDFSource;

/**
 * @phpstan-import-type Base64PDFSourceShape from \Anthropic\Messages\Base64PDFSource
 * @phpstan-import-type PlainTextSourceShape from \Anthropic\Messages\PlainTextSource
 * @phpstan-import-type ContentBlockSourceShape from \Anthropic\Messages\ContentBlockSource
 * @phpstan-import-type URLPDFSourceShape from \Anthropic\Messages\URLPDFSource
 *
 * @phpstan-type SourceShape = Base64PDFSourceShape|PlainTextSourceShape|ContentBlockSourceShape|URLPDFSourceShape
 */
final class Source implements ConverterSource
{
    use SdkUnion;

    public static function discriminator(): string
    {
        return 'type';
    }

    /**
     * @return list<string|Converter|ConverterSource>|array<string,string|Converter|ConverterSource>
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
