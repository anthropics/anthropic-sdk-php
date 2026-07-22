<?php

declare(strict_types=1);

namespace Anthropic\Beta\Environments\BetaEnvironmentDeleteResponse;

/**
 * The type of response.
 */
enum Type: string
{
    case ENVIRONMENT_DELETED = 'environment_deleted';
}
