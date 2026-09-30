<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Plugins\Versions\BetaPluginVersion;

/**
 * How far the version reaches: `remote`, `privileged` or `contained`, as on the Plugin; null when not classifiable.
 */
enum Reach: string
{
    case CONTAINED = 'contained';

    case PRIVILEGED = 'privileged';

    case REMOTE = 'remote';
}
