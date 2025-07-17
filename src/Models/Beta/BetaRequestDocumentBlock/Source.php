<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta\BetaRequestDocumentBlock;

use Anthropic\Core\Concerns\Union;
use Anthropic\Core\Contracts\Converter;
use Anthropic\Core\Contracts\StaticConverter;
use Anthropic\Models\Beta\BetaBase64PDFSource;
use Anthropic\Models\Beta\BetaContentBlockSource;
use Anthropic\Models\Beta\BetaFileDocumentSource;
use Anthropic\Models\Beta\BetaPlainTextSource;
use Anthropic\Models\Beta\BetaURLPDFSource;

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
            'base64' => BetaBase64PDFSource::class,
            'text' => BetaPlainTextSource::class,
            'content' => BetaContentBlockSource::class,
            'url' => BetaURLPDFSource::class,
            'file' => BetaFileDocumentSource::class,
        ];
    }
}
