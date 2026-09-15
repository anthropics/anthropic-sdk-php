<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Workspaces\DataResidency;

/**
 * Default inference geo applied when requests omit the parameter.
 */
enum DefaultInferenceGeo: string
{
    case GLOBAL = 'global';

    case US = 'us';
}
