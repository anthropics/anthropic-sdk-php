<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Plugins\Versions\BetaPluginVersion;

/**
 * How far the version reaches: `remote`, `privileged`, `contained`, or `null`, as defined on the Plugin's `reach`.
 */
enum Reach: string
{
    case CONTAINED = 'contained';

    case PRIVILEGED = 'privileged';

    case REMOTE = 'remote';
}
