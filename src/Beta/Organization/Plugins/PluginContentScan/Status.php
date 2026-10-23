<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Plugins\PluginContentScan;

/**
 * `processing` while a scan runs, `completed` when it ran to completion, `errored` when it could not run. Once a scan of the version has completed, `content_scan` describes the newest completed scan, even while a later scan runs. While the scan outcome cannot be read, `status` is `errored` instead.
 */
enum Status: string
{
    case COMPLETED = 'completed';

    case ERRORED = 'errored';

    case PROCESSING = 'processing';
}
