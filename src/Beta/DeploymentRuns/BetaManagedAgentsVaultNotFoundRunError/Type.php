<?php

declare(strict_types=1);

namespace Anthropic\Beta\DeploymentRuns\BetaManagedAgentsVaultNotFoundRunError;

enum Type: string
{
    case VAULT_NOT_FOUND_ERROR = 'vault_not_found_error';
}
