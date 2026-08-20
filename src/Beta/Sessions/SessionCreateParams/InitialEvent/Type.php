<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\SessionCreateParams\InitialEvent;

enum Type: string
{
    case USER_MESSAGE = 'user.message';

    case USER_DEFINE_OUTCOME = 'user.define_outcome';
}
