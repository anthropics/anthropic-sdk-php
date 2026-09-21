<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaDocumentBlock;

use Anthropic\Beta\Messages\BetaBase64PDFSource;
use Anthropic\Beta\Messages\BetaDocumentBlock\Source\Type;
use Anthropic\Beta\Messages\BetaPlainTextSource;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-import-type BetaBase64PDFSourceShape from \Anthropic\Beta\Messages\BetaBase64PDFSource
 * @phpstan-import-type BetaPlainTextSourceShape from \Anthropic\Beta\Messages\BetaPlainTextSource
 *
 * @phpstan-type SourceVariants = BetaBase64PDFSource|BetaPlainTextSource
 * @phpstan-type SourceShape = SourceVariants|BetaBase64PDFSourceShape|BetaPlainTextSourceShape
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
        ];
    }

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @return ($type is Type::BASE64|'base64' ? BetaBase64PDFSource : ($type is Type::TEXT|'text' ? BetaPlainTextSource : BetaBase64PDFSource|BetaPlainTextSource))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        string $data
    ): BetaBase64PDFSource|BetaPlainTextSource {
        return match ($type) {
            Type::BASE64, 'base64' => BetaBase64PDFSource::with(data: $data),
            Type::TEXT, 'text' => BetaPlainTextSource::with(data: $data),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
