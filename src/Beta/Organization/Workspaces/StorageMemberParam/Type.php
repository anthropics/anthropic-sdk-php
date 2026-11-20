<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Workspaces\StorageMemberParam;

enum Type: string
{
    case INTERNAL = 'internal';

    case EXTERNAL = 'external';
}
