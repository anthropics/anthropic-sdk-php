<?php

declare(strict_types=1);

namespace Anthropic\Messages\Base64ImageSource;

enum MediaType: string
{
    case IMAGE_JPEG = 'image/jpeg';

    case IMAGE_PNG = 'image/png';

    case IMAGE_GIF = 'image/gif';

    case IMAGE_WEBP = 'image/webp';
}
