<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Analytics;

enum AnalyticsClaudeTagCategory: string
{
    case DM = 'dm';

    case ENGAGED = 'engaged';

    case MONITORING = 'monitoring';

    case PROACTIVE = 'proactive';

    case SCHEDULED = 'scheduled';
}
