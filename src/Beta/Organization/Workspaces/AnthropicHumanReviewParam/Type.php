<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\Workspaces\AnthropicHumanReviewParam;

enum Type: string
{
    case DISABLED = 'disabled';

    case ENABLED = 'enabled';
}
