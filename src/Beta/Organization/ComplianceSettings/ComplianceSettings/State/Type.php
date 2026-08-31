<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ComplianceSettings\ComplianceSettings\State;

enum Type: string
{
    case ENABLED = 'enabled';

    case DISABLED = 'disabled';
}
