<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaDocumentBlock;

use Anthropic\Beta\Messages\BetaBase64PDFSource;
use Anthropic\Beta\Messages\BetaPlainTextSource;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

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
        ];
    }
}
