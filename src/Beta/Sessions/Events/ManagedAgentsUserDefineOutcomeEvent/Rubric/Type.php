<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events\ManagedAgentsUserDefineOutcomeEvent\Rubric;

enum Type: string
{
    case FILE = 'file';

    case TEXT = 'text';
}
