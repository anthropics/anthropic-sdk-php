<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events\ManagedAgentsUserDefineOutcomeEventParams;

enum Type: string
{
    case USER_DEFINE_OUTCOME = 'user.define_outcome';
}
