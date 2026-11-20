<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ComplianceSettings\AccessTransparency;

enum Type: string
{
    case DISABLED = 'disabled';

    case ENABLED = 'enabled';
}
