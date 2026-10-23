<?php

declare(strict_types=1);

namespace Anthropic\Beta\Organization\ClaudeTag\Bundles\Targets\BetaClaudeTagBundleTarget;

enum Type: string
{
    case SLACK_CHANNEL = 'slack_channel';

    case SLACK_WORKSPACE = 'slack_workspace';
}
