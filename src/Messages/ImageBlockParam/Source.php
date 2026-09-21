<?php

declare(strict_types=1);

namespace Anthropic\Messages\ImageBlockParam;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Messages\Base64ImageSource;
use Anthropic\Messages\Base64ImageSource\MediaType;
use Anthropic\Messages\FileImageSource;
use Anthropic\Messages\ImageBlockParam\Source\Type;
use Anthropic\Messages\URLImageSource;

/**
 * @phpstan-import-type Base64ImageSourceShape from \Anthropic\Messages\Base64ImageSource
 * @phpstan-import-type URLImageSourceShape from \Anthropic\Messages\URLImageSource
 * @phpstan-import-type FileImageSourceShape from \Anthropic\Messages\FileImageSource
 *
 * @phpstan-type SourceVariants = Base64ImageSource|URLImageSource|FileImageSource
 * @phpstan-type SourceShape = SourceVariants|Base64ImageSourceShape|URLImageSourceShape|FileImageSourceShape
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
            'base64' => Base64ImageSource::class,
            'url' => URLImageSource::class,
            'file' => FileImageSource::class,
        ];
    }

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @param MediaType|value-of<MediaType>|null $mediaType
     *
     * @return ($type is Type::BASE64|'base64' ? Base64ImageSource : ($type is Type::URL|'url' ? URLImageSource : ($type is Type::FILE|'file' ? FileImageSource : Base64ImageSource|URLImageSource|FileImageSource)))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        ?string $data = null,
        MediaType|string|null $mediaType = null,
        ?string $url = null,
        ?string $fileID = null,
    ): Base64ImageSource|URLImageSource|FileImageSource {
        return match ($type) {
            Type::BASE64, 'base64' => Base64ImageSource::with(
                data: $data ?? throw new \ArgumentCountError('$data is required'),
                mediaType: $mediaType ?? throw new \ArgumentCountError('$mediaType is required'),
            ),
            Type::URL, 'url' => URLImageSource::with(
                url: $url ?? throw new \ArgumentCountError('$url is required')
            ),
            Type::FILE, 'file' => FileImageSource::with(
                fileID: $fileID ?? throw new \ArgumentCountError('$fileID is required'),
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
