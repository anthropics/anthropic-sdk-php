<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\PluginMarketplaces\PluginMarketplace;

/**
 * Where the plugin marketplace's Plugins come from: `manual` when they are uploaded; `github`, `gitlab` or `public_git` when they are synchronized from the Git repository the owner connected, into which nothing can be uploaded; `directory` is Anthropic's own catalog, which this API does not list. A value this API does not yet name is returned as stored.
 */
enum Source: string
{
    case DIRECTORY = 'directory';

    case GITHUB = 'github';

    case GITLAB = 'gitlab';

    case MANUAL = 'manual';

    case PUBLIC_GIT = 'public_git';
}
