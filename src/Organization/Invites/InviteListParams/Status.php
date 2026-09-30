<?php

declare(strict_types=1);

namespace Anthropic\Organization\Invites\InviteListParams;

enum Status: string
{
    case ACCEPTED = 'accepted';

    case EXPIRED = 'expired';

    case PENDING = 'pending';
}
