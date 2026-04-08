<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events\ManagedAgentsImageBlock;

use Anthropic\Beta\Sessions\Events\ManagedAgentsBase64ImageSource;
use Anthropic\Beta\Sessions\Events\ManagedAgentsFileImageSource;
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
}
