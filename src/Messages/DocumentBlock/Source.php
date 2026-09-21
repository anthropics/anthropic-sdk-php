<?php

declare(strict_types=1);

namespace Anthropic\Messages\DocumentBlock;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Messages\Base64PDFSource;
use Anthropic\Messages\DocumentBlock\Source\Type;
use Anthropic\Messages\PlainTextSource;

/**
 * @phpstan-import-type Base64PDFSourceShape from \Anthropic\Messages\Base64PDFSource
 * @phpstan-import-type PlainTextSourceShape from \Anthropic\Messages\PlainTextSource
 *
 * @phpstan-type SourceVariants = Base64PDFSource|PlainTextSource
 * @phpstan-type SourceShape = SourceVariants|Base64PDFSourceShape|PlainTextSourceShape
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
            'base64' => Base64PDFSource::class, 'text' => PlainTextSource::class,
        ];
    }

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @return ($type is Type::BASE64|'base64' ? Base64PDFSource : ($type is Type::TEXT|'text' ? PlainTextSource : Base64PDFSource|PlainTextSource))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        string $data
    ): Base64PDFSource|PlainTextSource {
        return match ($type) {
            Type::BASE64, 'base64' => Base64PDFSource::with(data: $data),
            Type::TEXT, 'text' => PlainTextSource::with(data: $data),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
