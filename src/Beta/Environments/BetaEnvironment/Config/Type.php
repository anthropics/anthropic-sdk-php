<?php

declare(strict_types=1);

namespace Anthropic\Beta\Environments\BetaEnvironment\Config;

enum Type: string
{
    case CLOUD = 'cloud';

    case SELF_HOSTED = 'self_hosted';
}
