<?php

declare(strict_types=1);

namespace Anthropic\Models;

/**
 * A Claude model line, such as `opus` or `sonnet`. More lines may be added as new values.
 */
enum ModelLine: string
{
    case HAIKU = 'haiku';

    case SONNET = 'sonnet';

    case OPUS = 'opus';

    case FABLE = 'fable';

    case MYTHOS = 'mythos';
}
