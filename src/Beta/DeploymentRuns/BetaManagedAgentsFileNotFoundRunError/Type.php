<?php

declare(strict_types=1);

namespace Anthropic\Beta\DeploymentRuns\BetaManagedAgentsFileNotFoundRunError;

enum Type: string
{
    case FILE_NOT_FOUND_ERROR = 'file_not_found_error';
}
