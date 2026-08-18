<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaImageBlockParam\Source;

enum Type: string
{
    case BASE64 = 'base64';

    case URL = 'url';

    case FILE = 'file';
}
