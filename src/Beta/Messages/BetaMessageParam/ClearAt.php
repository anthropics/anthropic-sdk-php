<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaMessageParam;

/**
 * How long this system message's text stays in front of the model. `"never"` (the default) renders it on every request that includes it. `"next_user_message"` renders it only for the user turn it follows: once a later `role: "user"` message exists in `messages` the message stays in the array (send it unchanged) but is no longer shown to the model. Only permitted on `role: "system"` messages.
 */
enum ClearAt: string
{
    case NEXT_USER_MESSAGE = 'next_user_message';

    case NEVER = 'never';
}
