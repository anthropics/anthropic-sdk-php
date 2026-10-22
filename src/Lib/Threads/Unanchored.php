<?php

declare(strict_types=1);

namespace Anthropic\Lib\Threads;

/**
 * How the next turn is sent when it continues no thread. Either way it carries the whole history.
 *
 * @internal
 */
enum Unanchored
{
    /** It starts a new thread. */
    case CREATE;

    /** It starts a new thread, because the API did not find the one that the turn tried to continue. */
    case CREATE_AFTER_NOT_FOUND;

    /** It is sent without a thread, and so is every later turn. */
    case UNTHREADED;
}
