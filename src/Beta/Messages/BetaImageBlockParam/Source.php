<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaImageBlockParam;

use Anthropic\Beta\Messages\BetaBase64ImageSource;
use Anthropic\Beta\Messages\BetaBase64ImageSource\MediaType;
use Anthropic\Beta\Messages\BetaFileImageSource;
use Anthropic\Beta\Messages\BetaImageBlockParam\Source\Type;
use Anthropic\Beta\Messages\BetaURLImageSource;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-import-type BetaBase64ImageSourceShape from \Anthropic\Beta\Messages\BetaBase64ImageSource
 * @phpstan-import-type BetaURLImageSourceShape from \Anthropic\Beta\Messages\BetaURLImageSource
 * @phpstan-import-type BetaFileImageSourceShape from \Anthropic\Beta\Messages\BetaFileImageSource
 *
 * @phpstan-type SourceVariants = BetaBase64ImageSource|BetaURLImageSource|BetaFileImageSource
 * @phpstan-type SourceShape = SourceVariants|BetaBase64ImageSourceShape|BetaURLImageSourceShape|BetaFileImageSourceShape
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
            'base64' => BetaBase64ImageSource::class,
            'url' => BetaURLImageSource::class,
            'file' => BetaFileImageSource::class,
        ];
    }

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @param MediaType|value-of<MediaType>|null $mediaType
     *
     * @return ($type is Type::BASE64|'base64' ? BetaBase64ImageSource : ($type is Type::URL|'url' ? BetaURLImageSource : ($type is Type::FILE|'file' ? BetaFileImageSource : BetaBase64ImageSource|BetaURLImageSource|BetaFileImageSource)))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        ?string $data = null,
        MediaType|string|null $mediaType = null,
        ?string $url = null,
        ?string $fileID = null,
    ): BetaBase64ImageSource|BetaURLImageSource|BetaFileImageSource {
        return match ($type) {
            Type::BASE64, 'base64' => BetaBase64ImageSource::with(
                data: $data ?? throw new \ArgumentCountError('$data is required'),
                mediaType: $mediaType ?? throw new \ArgumentCountError('$mediaType is required'),
            ),
            Type::URL, 'url' => BetaURLImageSource::with(
                url: $url ?? throw new \ArgumentCountError('$url is required')
            ),
            Type::FILE, 'file' => BetaFileImageSource::with(
                fileID: $fileID ?? throw new \ArgumentCountError('$fileID is required'),
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
