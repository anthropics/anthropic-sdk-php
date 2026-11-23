<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ExternalStorage\ExternalStorage\Status;

enum Type: string
{
    case PENDING_CONFIGURATION = 'pending_configuration';

    case AVAILABLE = 'available';

    case ACTIVE = 'active';

    case DRAINING = 'draining';
}
