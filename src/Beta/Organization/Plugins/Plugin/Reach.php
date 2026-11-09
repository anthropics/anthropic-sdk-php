<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Plugins\Plugin;

/**
 * How far the served version reaches, or `null` if it is not classified.
 *
 * `remote` means it declares an MCP server or a CLI, or something that counts as one. `privileged` means it is not `remote`, but declares a hook (of any type, even one that posts to a URL), monitor, language server, Claude Code workflow (any file in a `workflows/` folder at its root counts as one), or settings, or has a skill, command, or other Markdown file whose frontmatter pre-approves tools (`allowed-tools` with any value other than an empty one or one that names only `AskUserQuestion`, `TodoWrite`, and `ToolSearch`). Otherwise it is `contained`.
 *
 * If the frontmatter of a skill, command, or other Markdown file that could change the value could not be read, or was past a size limit, the version is `null` or `privileged` (or `remote`, if something else it declares makes it `remote`), not `contained`. The value is normally worked out when a version is stored, under the rules of that time, so an older version can be `null`, `contained` where the same files stored today would be `privileged`, `remote`, or `null`, or `privileged` where they would be `remote`.
 */
enum Reach: string
{
    case CONTAINED = 'contained';

    case PRIVILEGED = 'privileged';

    case REMOTE = 'remote';
}
