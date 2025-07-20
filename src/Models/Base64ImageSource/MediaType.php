<?php

declare(strict_types=1);

namespace Anthropic\Models\Base64ImageSource;

use Anthropic\Core\Concerns\Enum;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-type media_type_alias = MediaType::*
 */
final class MediaType implements ConverterSource
{
    use Enum;

    final public const IMAGE_JPEG = 'image/jpeg';

    final public const IMAGE_PNG = 'image/png';

    final public const IMAGE_GIF = 'image/gif';

    final public const IMAGE_WEBP = 'image/webp';
}
