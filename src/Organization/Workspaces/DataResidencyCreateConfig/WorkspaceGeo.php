<?php

declare(strict_types=1);

namespace Anthropic\Organization\Workspaces\DataResidencyCreateConfig;

/**
 * Geographic region for workspace data storage. Immutable after creation. Defaults to 'us' if omitted.
 */
enum WorkspaceGeo: string
{
    case US = 'us';
}
