<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaRequestDocumentBlock;

use Anthropic\Beta\Messages\BetaBase64PDFSource;
use Anthropic\Beta\Messages\BetaContentBlockSource;
use Anthropic\Beta\Messages\BetaFileDocumentSource;
use Anthropic\Beta\Messages\BetaPlainTextSource;
use Anthropic\Beta\Messages\BetaRequestDocumentBlock\Source\Type;
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
 * @phpstan-import-type ContentShape from \Anthropic\Beta\Messages\BetaContentBlockSource\Content
 *
 * @phpstan-type SourceVariants = BetaBase64PDFSource|BetaPlainTextSource|BetaContentBlockSource|BetaURLPDFSource|BetaFileDocumentSource
 * @phpstan-type SourceShape = SourceVariants|BetaBase64PDFSourceShape|BetaPlainTextSourceShape|BetaContentBlockSourceShape|BetaURLPDFSourceShape|BetaFileDocumentSourceShape
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

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @param ContentShape|null $content
     *
     * @return ($type is Type::BASE64|'base64' ? BetaBase64PDFSource : ($type is Type::TEXT|'text' ? BetaPlainTextSource : ($type is Type::CONTENT|'content' ? BetaContentBlockSource : ($type is Type::URL|'url' ? BetaURLPDFSource : ($type is Type::FILE|'file' ? BetaFileDocumentSource : BetaBase64PDFSource|BetaPlainTextSource|BetaContentBlockSource|BetaURLPDFSource|BetaFileDocumentSource)))))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        ?string $data = null,
        string|array|null $content = null,
        ?string $url = null,
        ?string $fileID = null,
    ): BetaBase64PDFSource|BetaPlainTextSource|BetaContentBlockSource|BetaURLPDFSource|BetaFileDocumentSource {
        return match ($type) {
            Type::BASE64, 'base64' => BetaBase64PDFSource::with(
                data: $data ?? throw new \ArgumentCountError('$data is required')
            ),
            Type::TEXT, 'text' => BetaPlainTextSource::with(
                data: $data ?? throw new \ArgumentCountError('$data is required')
            ),
            Type::CONTENT, 'content' => BetaContentBlockSource::with(
                content: $content ?? throw new \ArgumentCountError('$content is required'),
            ),
            Type::URL, 'url' => BetaURLPDFSource::with(
                url: $url ?? throw new \ArgumentCountError('$url is required')
            ),
            Type::FILE, 'file' => BetaFileDocumentSource::with(
                fileID: $fileID ?? throw new \ArgumentCountError('$fileID is required'),
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
