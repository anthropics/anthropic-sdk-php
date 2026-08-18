<?php

declare(strict_types=1);

namespace Anthropic\Beta\Vaults\Credentials\ManagedAgentsEnvironmentVariableAuthResponse\Networking;

enum Type: string
{
    case UNRESTRICTED = 'unrestricted';

    case LIMITED = 'limited';
}
