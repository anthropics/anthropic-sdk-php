<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Plugins\PluginContentScan;

/**
 * `processing` while a scan runs, `completed` when it ran to completion, `errored` when it could not run or its outcome cannot be read.
 */
enum Status: string
{
    case COMPLETED = 'completed';

    case ERRORED = 'errored';

    case PROCESSING = 'processing';
}
