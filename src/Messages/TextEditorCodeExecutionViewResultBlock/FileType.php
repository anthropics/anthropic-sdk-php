<?php

declare(strict_types=1);

namespace Anthropic\Messages\TextEditorCodeExecutionViewResultBlock;

enum FileType: string
{
    case TEXT = 'text';

    case IMAGE = 'image';

    case PDF = 'pdf';
}
