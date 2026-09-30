<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Analytics\AnalyticsUsageBucketedResult;

/**
 * Inference speed mode of the usage or cost: `fast` or `standard`. Null unless `speed` is in `group_by[]`.
 */
enum Speed: string
{
    case FAST = 'fast';

    case STANDARD = 'standard';
}
