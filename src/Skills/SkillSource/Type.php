<?php

declare(strict_types=1);

namespace Anthropic\Skills\SkillSource;

/**
 * Where the Skill comes from.
 *
 * Possible values:
 * * `"custom"`: authored by the platform user; private to their workspace
 * * `"anthropic"`: published by Anthropic; shared and read-only
 * * `"anthropic_example"`: Anthropic-published sample Skill
 * * `"plugin"`: resolved from an installed plugin
 */
enum Type: string
{
    case CUSTOM = 'custom';

    case ANTHROPIC = 'anthropic';

    case ANTHROPIC_EXAMPLE = 'anthropic_example';

    case PLUGIN = 'plugin';
}
