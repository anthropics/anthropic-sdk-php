<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaDiagnostics\CacheMissReason;

enum Type: string
{
    case MODEL_CHANGED = 'model_changed';

    case SYSTEM_CHANGED = 'system_changed';

    case TOOLS_CHANGED = 'tools_changed';

    case MESSAGES_CHANGED = 'messages_changed';

    case PREVIOUS_MESSAGE_NOT_FOUND = 'previous_message_not_found';

    case UNAVAILABLE = 'unavailable';
}
