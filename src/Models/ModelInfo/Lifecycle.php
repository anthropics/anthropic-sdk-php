<?php

declare(strict_types=1);

namespace Anthropic\Models\ModelInfo;

/**
 * The model's current lifecycle stage.
 *
 * - `active`: The model is available for use, open to new adopters, and not scheduled for retirement.
 * - `deprecated`: The model remains callable for organizations with existing access, but is headed for retirement and closed to new adopters.
 * - `retired`: The model is no longer available for use; inference requests naming it fail. It remains in the catalogue as the historical record of its retirement.
 */
enum Lifecycle: string
{
    case ACTIVE = 'active';

    case DEPRECATED = 'deprecated';

    case RETIRED = 'retired';
}
