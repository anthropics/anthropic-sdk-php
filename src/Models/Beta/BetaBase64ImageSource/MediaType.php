<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta\BetaBase64ImageSource;

use Anthropic\Core\Concerns\Enum;
use Anthropic\Core\Contracts\StaticConverter;

final class MediaType implements StaticConverter
{
    use Enum;

    final public const IMAGE_JPEG = 'image/jpeg';

    final public const IMAGE_PNG = 'image/png';

    final public const IMAGE_GIF = 'image/gif';

    final public const IMAGE_WEBP = 'image/webp';
}
