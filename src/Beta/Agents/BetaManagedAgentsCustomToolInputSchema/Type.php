<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents\BetaManagedAgentsCustomToolInputSchema;

/**
 * Must be 'object' for tool input schemas.
 */
enum Type: string
{
    case OBJECT = 'object';
}
