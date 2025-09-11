<?php

declare(strict_types=1);

namespace Anthropic\Messages\Usage;

/**
 * If the request used the priority, standard, or batch tier.
 */
enum ServiceTier: string
{
    case STANDARD = 'standard';

    case PRIORITY = 'priority';

    case BATCH = 'batch';
}
