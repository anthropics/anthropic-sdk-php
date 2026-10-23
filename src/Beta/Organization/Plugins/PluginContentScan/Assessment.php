<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Plugins\PluginContentScan;

/**
 * The scan's verdict; set only when `status` is `completed`. A `warn` can mean a `fail` that was allowed in claude.ai.
 */
enum Assessment: string
{
    case FAIL = 'fail';

    case PASS = 'pass';

    case UNKNOWN = 'unknown';

    case WARN = 'warn';
}
