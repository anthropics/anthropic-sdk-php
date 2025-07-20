<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta\BetaRequestDocumentBlock;

use Anthropic\Core\Concerns\Union;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Models\Beta\BetaBase64PDFSource;
use Anthropic\Models\Beta\BetaContentBlockSource;
use Anthropic\Models\Beta\BetaFileDocumentSource;
use Anthropic\Models\Beta\BetaPlainTextSource;
use Anthropic\Models\Beta\BetaURLPDFSource;

/**
 * @phpstan-type source_alias = BetaBase64PDFSource|BetaPlainTextSource|BetaContentBlockSource|BetaURLPDFSource|BetaFileDocumentSource
 */
final class Source implements ConverterSource
{
    use Union;

    public static function discriminator(): string
    {
        return 'type';
    }

    /**
     * @return list<string|Converter|ConverterSource>|array<
     *   string, string|Converter|ConverterSource
     * >
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
