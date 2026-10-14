<?php

declare(strict_types=1);

namespace Anthropic\Core\Implementation;

/**
 * How many requests one API call has sent, for its call span. The client creates one for each API call and passes it to every attempt of that call, so the count lives exactly as long as the call does.
 *
 * @internal
 */
final class SentRequests
{
    /** The requests sent so far. The first of them gave the call span its `url.*` attributes. */
    public int $count = 0;
}
