<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Plugins\Plugin;

/**
 * How far the served version reaches, or `null` if it is not classified.
 *
 * `remote` means it declares an MCP server or a CLI. `privileged` means it declares no MCP server or CLI, but declares a hook, monitor, language server, or settings, or has a skill, command, or other Markdown file whose frontmatter pre-approves tools (`allowed-tools` with any value other than an empty one or one that names only `AskUserQuestion`, `TodoWrite`, and `ToolSearch`). Otherwise it is `contained`.
 *
 * If the frontmatter of a skill, command, or other Markdown file that could change the value could not be read, or was past a size limit, the version is `null` or `privileged` (or `remote`, if it declares an MCP server or a CLI), not `contained`. The value is normally worked out when a version is stored, under the rules of that time, so an older version can be `null`, or `contained` where the same files stored today would be `privileged` or `null`.
 */
enum Reach: string
{
    case CONTAINED = 'contained';

    case PRIVILEGED = 'privileged';

    case REMOTE = 'remote';
}
