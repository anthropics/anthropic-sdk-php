<?php

declare(strict_types=1);

namespace Anthropic\Beta\Deployments\BetaManagedAgentsDeploymentUserDefineOutcomeEvent\Rubric;

enum Type: string
{
    case FILE = 'file';

    case TEXT = 'text';
}
