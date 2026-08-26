<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ExternalKeys\ExternalKey\Attachment;

enum Type: string
{
    case ATTACHED = 'attached';

    case UNATTACHED = 'unattached';
}
