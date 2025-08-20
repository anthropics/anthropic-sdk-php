<?php

declare(strict_types=1);

namespace Anthropic\Messages\Base64ImageSource;

use Anthropic\Core\Concerns\SdkEnum;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-type media_type_alias = MediaType::*
 */
final class MediaType implements ConverterSource
{
    use SdkEnum;

    public const IMAGE_JPEG = 'image/jpeg';

    public const IMAGE_PNG = 'image/png';

    public const IMAGE_GIF = 'image/gif';

    public const IMAGE_WEBP = 'image/webp';
}
