<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events\ManagedAgentsSessionErrorEvent\Error;

enum Type: string
{
    case UNKNOWN_ERROR = 'unknown_error';

    case MODEL_OVERLOADED_ERROR = 'model_overloaded_error';

    case MODEL_RATE_LIMITED_ERROR = 'model_rate_limited_error';

    case MODEL_REQUEST_FAILED_ERROR = 'model_request_failed_error';

    case MCP_CONNECTION_FAILED_ERROR = 'mcp_connection_failed_error';

    case MCP_AUTHENTICATION_FAILED_ERROR = 'mcp_authentication_failed_error';

    case BILLING_ERROR = 'billing_error';

    case CREDENTIAL_HOST_UNREACHABLE_ERROR = 'credential_host_unreachable_error';
}
