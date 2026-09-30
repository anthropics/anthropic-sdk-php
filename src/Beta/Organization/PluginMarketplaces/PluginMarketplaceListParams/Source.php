<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\PluginMarketplaces\PluginMarketplaceListParams;

/**
 * Only plugin marketplaces with this `source`: `manual` for those whose Plugins are uploaded; `github`, `gitlab` or `public_git` for those synchronized from a Git repository. `directory` (Anthropic's catalog) is never listed here.
 */
enum Source: string
{
    case DIRECTORY = 'directory';

    case GITHUB = 'github';

    case GITLAB = 'gitlab';

    case MANUAL = 'manual';

    case PUBLIC_GIT = 'public_git';
}
