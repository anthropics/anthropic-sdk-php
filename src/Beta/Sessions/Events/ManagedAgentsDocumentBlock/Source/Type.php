<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events\ManagedAgentsDocumentBlock\Source;

enum Type: string
{
    case BASE64 = 'base64';

    case TEXT = 'text';

    case URL = 'url';

    case FILE = 'file';
}
