<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ClaudeTag\ClaudeTagGuestPolicy;

enum Type: string
{
    case ALLOW = 'allow';

    case RESTRICT = 'restrict';

    case CHANNEL_ONLY = 'channel_only';
}
