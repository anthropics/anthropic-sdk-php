<?php

declare(strict_types=1);

namespace Anthropic\Messages\DocumentBlockParam;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Messages\Base64PDFSource;
use Anthropic\Messages\ContentBlockSource;
use Anthropic\Messages\DocumentBlockParam\Source\Type;
use Anthropic\Messages\FileDocumentSource;
use Anthropic\Messages\PlainTextSource;
use Anthropic\Messages\URLPDFSource;

/**
 * @phpstan-import-type Base64PDFSourceShape from \Anthropic\Messages\Base64PDFSource
 * @phpstan-import-type PlainTextSourceShape from \Anthropic\Messages\PlainTextSource
 * @phpstan-import-type ContentBlockSourceShape from \Anthropic\Messages\ContentBlockSource
 * @phpstan-import-type URLPDFSourceShape from \Anthropic\Messages\URLPDFSource
 * @phpstan-import-type FileDocumentSourceShape from \Anthropic\Messages\FileDocumentSource
 * @phpstan-import-type ContentShape from \Anthropic\Messages\ContentBlockSource\Content
 *
 * @phpstan-type SourceVariants = Base64PDFSource|PlainTextSource|ContentBlockSource|URLPDFSource|FileDocumentSource
 * @phpstan-type SourceShape = SourceVariants|Base64PDFSourceShape|PlainTextSourceShape|ContentBlockSourceShape|URLPDFSourceShape|FileDocumentSourceShape
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
            'file' => FileDocumentSource::class,
        ];
    }

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @param ContentShape|null $content
     *
     * @return ($type is Type::BASE64|'base64' ? Base64PDFSource : ($type is Type::TEXT|'text' ? PlainTextSource : ($type is Type::CONTENT|'content' ? ContentBlockSource : ($type is Type::URL|'url' ? URLPDFSource : ($type is Type::FILE|'file' ? FileDocumentSource : Base64PDFSource|PlainTextSource|ContentBlockSource|URLPDFSource|FileDocumentSource)))))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        ?string $data = null,
        string|array|null $content = null,
        ?string $url = null,
        ?string $fileID = null,
    ): Base64PDFSource|PlainTextSource|ContentBlockSource|URLPDFSource|FileDocumentSource {
        return match ($type) {
            Type::BASE64, 'base64' => Base64PDFSource::with(
                data: $data ?? throw new \ArgumentCountError('$data is required')
            ),
            Type::TEXT, 'text' => PlainTextSource::with(
                data: $data ?? throw new \ArgumentCountError('$data is required')
            ),
            Type::CONTENT, 'content' => ContentBlockSource::with(
                content: $content ?? throw new \ArgumentCountError('$content is required'),
            ),
            Type::URL, 'url' => URLPDFSource::with(
                url: $url ?? throw new \ArgumentCountError('$url is required')
            ),
            Type::FILE, 'file' => FileDocumentSource::with(
                fileID: $fileID ?? throw new \ArgumentCountError('$fileID is required'),
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
