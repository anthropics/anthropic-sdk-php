<?php

declare(strict_types=1);

namespace Anthropic\Messages\BrowserStateChange;

enum Type: string
{
    case TAB_OPENED = 'tab_opened';

    case DOWNLOAD_STARTED = 'download_started';

    case DOWNLOAD_COMPLETED = 'download_completed';

    case DOWNLOAD_FAILED = 'download_failed';
}
