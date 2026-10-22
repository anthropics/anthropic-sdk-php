<?php

declare(strict_types=1);

namespace Anthropic\Lib\Threads;

/**
 * What a message thread does when the API answers that a request cannot use a thread.
 */
enum UnsupportedRequestBehavior: string
{
    /** It throws the API's error. This is the default. */
    case ERROR = 'error';

    /** It sends the request again without a thread, and every later turn with the whole history. */
    case CONTINUE_UNTHREADED = 'continue_unthreaded';
}
