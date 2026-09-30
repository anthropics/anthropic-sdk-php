<?php

declare(strict_types=1);

namespace Anthropic\Organization\ExternalKeys\ExternalKey\Attachment;

enum Type: string
{
    case ATTACHED = 'attached';

    case UNATTACHED = 'unattached';
}
