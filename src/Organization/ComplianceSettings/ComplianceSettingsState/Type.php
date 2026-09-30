<?php

declare(strict_types=1);

namespace Anthropic\Organization\ComplianceSettings\ComplianceSettingsState;

enum Type: string
{
    case ENABLED = 'enabled';

    case DISABLED = 'disabled';
}
