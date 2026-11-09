<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ClaudeTag\ClaudeTagReplyMode;

enum Type: string
{
    case AUTOMATIC = 'automatic';

    case MENTION_ONLY = 'mention_only';

    case ALWAYS_AWAKE = 'always_awake';

    case THREAD = 'thread';
}
