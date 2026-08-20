<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaContentBlockSourceContent;

enum Type: string
{
    case TEXT = 'text';

    case IMAGE = 'image';
}
