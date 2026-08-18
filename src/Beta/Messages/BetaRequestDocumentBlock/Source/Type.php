<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaRequestDocumentBlock\Source;

enum Type: string
{
    case BASE64 = 'base64';

    case TEXT = 'text';

    case CONTENT = 'content';

    case URL = 'url';

    case FILE = 'file';
}
