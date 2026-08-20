<?php

declare(strict_types=1);

namespace Anthropic\Messages\RawMessageStreamEvent;

enum Type: string
{
    case MESSAGE_START = 'message_start';

    case MESSAGE_DELTA = 'message_delta';

    case MESSAGE_STOP = 'message_stop';

    case CONTENT_BLOCK_START = 'content_block_start';

    case CONTENT_BLOCK_DELTA = 'content_block_delta';

    case CONTENT_BLOCK_STOP = 'content_block_stop';
}
