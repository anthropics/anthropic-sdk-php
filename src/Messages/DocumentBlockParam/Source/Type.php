<?php

declare(strict_types=1);

namespace Anthropic\Messages\DocumentBlockParam\Source;

enum Type: string
{
    case BASE64 = 'base64';

    case TEXT = 'text';

    case CONTENT = 'content';

    case URL = 'url';

    case FILE = 'file';
}
