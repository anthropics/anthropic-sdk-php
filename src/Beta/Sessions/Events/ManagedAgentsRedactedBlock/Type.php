<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events\ManagedAgentsRedactedBlock;

enum Type: string
{
    case REDACTED = 'redacted';
}
