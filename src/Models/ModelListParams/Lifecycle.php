<?php

declare(strict_types=1);

namespace Anthropic\Models\ModelListParams;

enum Lifecycle: string
{
    case ACTIVE = 'active';

    case DEPRECATED = 'deprecated';

    case RETIRED = 'retired';
}
