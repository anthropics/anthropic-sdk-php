<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaRefusalStopDetails;

/**
 * The policy category that triggered the refusal.
 *
 * `null` when the refusal doesn't map to a named category.
 */
enum Category: string
{
    case CYBER = 'cyber';

    case BIO = 'bio';
}
