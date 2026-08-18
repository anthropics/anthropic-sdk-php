<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events\ManagedAgentsAgentMessageEvent\Content;

enum Type: string
{
    case TEXT = 'text';

    case REDACTED = 'redacted';
}
