<?php

declare(strict_types=1);

namespace Anthropic\Beta\DeploymentRuns\BetaManagedAgentsSkillNotFoundRunError;

enum Type: string
{
    case SKILL_NOT_FOUND_ERROR = 'skill_not_found_error';
}
