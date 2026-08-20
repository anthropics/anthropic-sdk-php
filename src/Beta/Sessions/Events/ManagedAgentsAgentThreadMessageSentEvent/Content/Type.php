<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events\ManagedAgentsAgentThreadMessageSentEvent\Content;

enum Type: string
{
    case TEXT = 'text';

    case IMAGE = 'image';

    case DOCUMENT = 'document';

    case REDACTED = 'redacted';
}
