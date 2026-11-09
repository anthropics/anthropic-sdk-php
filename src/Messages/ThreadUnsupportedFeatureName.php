<?php

declare(strict_types=1);

namespace Anthropic\Messages;

enum ThreadUnsupportedFeatureName: string
{
    case CACHE_CONTROL = 'cache_control';

    case CONTEXT_MANAGEMENT = 'context_management';

    case FALLBACKS = 'fallbacks';

    case HIPAA = 'hipaa';

    case INFERENCE_HOOKS = 'inference_hooks';

    case THINKING = 'thinking';

    case ZDR = 'zdr';
}
