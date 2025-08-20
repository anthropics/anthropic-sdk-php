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
 * @phpstan-type source_alias = BetaBase64PDFSource|BetaPlainTextSource|BetaContentBlockSource|BetaURLPDFSource|BetaFileDocumentSource
 */
final class Source implements ConverterSource
{
    use SdkUnion;

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
            'base64' => BetaBase64PDFSource::class,
            'text' => BetaPlainTextSource::class,
            'content' => BetaContentBlockSource::class,
            'url' => BetaURLPDFSource::class,
            'file' => BetaFileDocumentSource::class,
        ];
    }
}
