<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaIterationsUsageItem;

enum Type: string
{
    case MESSAGE = 'message';

    case COMPACTION = 'compaction';

    case ADVISOR_MESSAGE = 'advisor_message';

    case FALLBACK_MESSAGE = 'fallback_message';
}
