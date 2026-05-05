<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events\ManagedAgentsUserDefineOutcomeEvent;

enum Type: string
{
    case USER_DEFINE_OUTCOME = 'user.define_outcome';
}
