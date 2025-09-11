<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaTextEditorCodeExecutionViewResultBlockParam;

enum FileType: string
{
    case TEXT = 'text';

    case IMAGE = 'image';

    case PDF = 'pdf';
}
