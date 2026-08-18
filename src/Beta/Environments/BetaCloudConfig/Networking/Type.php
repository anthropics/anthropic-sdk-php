<?php

declare(strict_types=1);

namespace Anthropic\Beta\Environments\BetaCloudConfig\Networking;

enum Type: string
{
    case UNRESTRICTED = 'unrestricted';

    case LIMITED = 'limited';
}
