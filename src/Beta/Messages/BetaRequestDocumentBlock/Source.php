<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaRequestDocumentBlock;

use Anthropic\Beta\Messages\BetaBase64PDFSource;
use Anthropic\Beta\Messages\BetaContentBlockSource;
use Anthropic\Beta\Messages\BetaFileDocumentSource;
use Anthropic\Beta\Messages\BetaPlainTextSource;
use Anthropic\Beta\Messages\BetaURLPDFSource;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-import-type BetaBase64PDFSourceShape from \Anthropic\Beta\Messages\BetaBase64PDFSource
 * @phpstan-import-type BetaPlainTextSourceShape from \Anthropic\Beta\Messages\BetaPlainTextSource
 * @phpstan-import-type BetaContentBlockSourceShape from \Anthropic\Beta\Messages\BetaContentBlockSource
 * @phpstan-import-type BetaURLPDFSourceShape from \Anthropic\Beta\Messages\BetaURLPDFSource
 * @phpstan-import-type BetaFileDocumentSourceShape from \Anthropic\Beta\Messages\BetaFileDocumentSource
 *
 * @phpstan-type SourceShape = BetaBase64PDFSourceShape|BetaPlainTextSourceShape|BetaContentBlockSourceShape|BetaURLPDFSourceShape|BetaFileDocumentSourceShape
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
            'base64' => BetaBase64PDFSource::class,
            'text' => BetaPlainTextSource::class,
            'content' => BetaContentBlockSource::class,
            'url' => BetaURLPDFSource::class,
            'file' => BetaFileDocumentSource::class,
        ];
    }
}
