<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

/**
 * What happens when a thinking block in `messages` fails the conversation
 * check: it was created in a different conversation, or the messages before
 * it have changed since. `"error"` (the default) fails the request with a
 * 400 error. `"drop_block"` removes the failing blocks and the request
 * proceeds; the model no longer sees the dropped reasoning.
 */
enum BetaThinkingPrefixMismatchBehavior: string
{
    case ERROR = 'error';

    case DROP_BLOCK = 'drop_block';
}
