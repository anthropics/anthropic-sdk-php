<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Analytics\AnalyticsSkillActivity;

/**
 * Skill share status (claude.ai only): one of `private`, `organization`, or `public`. Null for skills used only in Claude Code or Office (no per-skill share-status concept) and when share-status reporting is not yet available for the organization. Filterable via `filter[]=share_status:{value}`.
 */
enum ShareStatus: string
{
    case ORGANIZATION = 'organization';

    case PRIVATE = 'private';

    case PUBLIC = 'public';
}
