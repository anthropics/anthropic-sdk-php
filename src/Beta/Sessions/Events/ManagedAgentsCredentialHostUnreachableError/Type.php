<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events\ManagedAgentsCredentialHostUnreachableError;

enum Type: string
{
    case CREDENTIAL_HOST_UNREACHABLE_ERROR = 'credential_host_unreachable_error';
}
