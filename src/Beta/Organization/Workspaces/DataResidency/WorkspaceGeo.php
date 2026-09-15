<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Workspaces\DataResidency;

/**
 * Geographic region for workspace data storage. Immutable after creation.
 */
enum WorkspaceGeo: string
{
    case US = 'us';
}
