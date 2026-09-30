<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Plugins\Plugin;

/**
 * How far the served version reaches: `remote` when it declares an MCP server or a CLI, `privileged` when it declares a hook, monitor, language server or settings but nothing remote, `contained` otherwise; null when not classifiable.
 */
enum Reach: string
{
    case CONTAINED = 'contained';

    case PRIVILEGED = 'privileged';

    case REMOTE = 'remote';
}
