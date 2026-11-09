<?php

declare(strict_types=1);

namespace Anthropic\Organization\Workspaces;

enum WorkspacePolicyField: string
{
    case EXTERNAL_KEY_ID = 'external_key_id';
}
