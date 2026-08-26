<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Workspaces;

enum AllowedInferenceGeo: string
{
    case GLOBAL = 'global';

    case US = 'us';
}
