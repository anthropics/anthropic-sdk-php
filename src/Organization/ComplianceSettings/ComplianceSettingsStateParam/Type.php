<?php

declare(strict_types=1);

namespace Anthropic\Organization\ComplianceSettings\ComplianceSettingsStateParam;

enum Type: string
{
    case ENABLED = 'enabled';

    case DISABLED = 'disabled';
}
