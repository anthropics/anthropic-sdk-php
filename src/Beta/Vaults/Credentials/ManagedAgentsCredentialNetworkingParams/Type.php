<?php

declare(strict_types=1);

namespace Anthropic\Beta\Vaults\Credentials\ManagedAgentsCredentialNetworkingParams;

enum Type: string
{
    case UNRESTRICTED = 'unrestricted';

    case LIMITED = 'limited';
}
