<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events\ManagedAgentsImageBlock;

use Anthropic\Beta\Sessions\Events\ManagedAgentsBase64ImageSource;
use Anthropic\Beta\Sessions\Events\ManagedAgentsFileImageSource;
use Anthropic\Beta\Sessions\Events\ManagedAgentsImageBlock\Source\Type;
use Anthropic\Beta\Sessions\Events\ManagedAgentsURLImageSource;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Union type for image source variants.
 *
 * @phpstan-import-type ManagedAgentsBase64ImageSourceShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsBase64ImageSource
 * @phpstan-import-type ManagedAgentsURLImageSourceShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsURLImageSource
 * @phpstan-import-type ManagedAgentsFileImageSourceShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsFileImageSource
 *
 * @phpstan-type SourceVariants = ManagedAgentsBase64ImageSource|ManagedAgentsURLImageSource|ManagedAgentsFileImageSource
 * @phpstan-type SourceShape = SourceVariants|ManagedAgentsBase64ImageSourceShape|ManagedAgentsURLImageSourceShape|ManagedAgentsFileImageSourceShape
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
            'base64' => ManagedAgentsBase64ImageSource::class,
            'url' => ManagedAgentsURLImageSource::class,
            'file' => ManagedAgentsFileImageSource::class,
        ];
    }

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @return ($type is Type::BASE64|'base64' ? ManagedAgentsBase64ImageSource : ($type is Type::URL|'url' ? ManagedAgentsURLImageSource : ($type is Type::FILE|'file' ? ManagedAgentsFileImageSource : ManagedAgentsBase64ImageSource|ManagedAgentsURLImageSource|ManagedAgentsFileImageSource)))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        ?string $data = null,
        ?string $mediaType = null,
        ?string $url = null,
        ?string $fileID = null,
    ): ManagedAgentsBase64ImageSource|ManagedAgentsURLImageSource|ManagedAgentsFileImageSource {
        return match ($type) {
            Type::BASE64, 'base64' => ManagedAgentsBase64ImageSource::with(
                type: 'base64',
                data: $data ?? throw new \ArgumentCountError('$data is required'),
                mediaType: $mediaType ?? throw new \ArgumentCountError('$mediaType is required'),
            ),
            Type::URL, 'url' => ManagedAgentsURLImageSource::with(
                type: 'url',
                url: $url ?? throw new \ArgumentCountError('$url is required'),
            ),
            Type::FILE, 'file' => ManagedAgentsFileImageSource::with(
                type: 'file',
                fileID: $fileID ?? throw new \ArgumentCountError('$fileID is required'),
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
