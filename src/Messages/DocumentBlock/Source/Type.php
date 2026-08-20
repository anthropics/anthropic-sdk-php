<?php

declare(strict_types=1);

namespace Anthropic\Messages\DocumentBlock\Source;

enum Type: string
{
    case BASE64 = 'base64';

    case TEXT = 'text';
}
