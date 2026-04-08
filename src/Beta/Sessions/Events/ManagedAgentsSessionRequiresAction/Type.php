<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events\ManagedAgentsSessionRequiresAction;

enum Type: string
{
    case REQUIRES_ACTION = 'requires_action';
}
