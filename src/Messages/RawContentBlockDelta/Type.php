<?php

declare(strict_types=1);

namespace Anthropic\Messages\RawContentBlockDelta;

enum Type: string
{
    case TEXT_DELTA = 'text_delta';

    case INPUT_JSON_DELTA = 'input_json_delta';

    case CITATIONS_DELTA = 'citations_delta';

    case THINKING_DELTA = 'thinking_delta';

    case SIGNATURE_DELTA = 'signature_delta';
}
