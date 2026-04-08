<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents\BetaManagedAgentsAgentToolConfigParams;

/**
 * Built-in agent tool identifier.
 */
enum Name: string
{
    case BASH = 'bash';

    case EDIT = 'edit';

    case READ = 'read';

    case WRITE = 'write';

    case GLOB = 'glob';

    case GREP = 'grep';

    case WEB_FETCH = 'web_fetch';

    case WEB_SEARCH = 'web_search';
}
