<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ComplianceSettings\ComplianceSettingUpdateParams\State;

enum Type: string
{
    case ENABLED = 'enabled';

    case DISABLED = 'disabled';
}
