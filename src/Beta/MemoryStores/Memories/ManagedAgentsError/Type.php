<?php

declare(strict_types=1);

namespace Anthropic\Beta\MemoryStores\Memories\ManagedAgentsError;

enum Type: string
{
    case INVALID_REQUEST_ERROR = 'invalid_request_error';

    case AUTHENTICATION_ERROR = 'authentication_error';

    case BILLING_ERROR = 'billing_error';

    case PERMISSION_ERROR = 'permission_error';

    case NOT_FOUND_ERROR = 'not_found_error';

    case RATE_LIMIT_ERROR = 'rate_limit_error';

    case TIMEOUT_ERROR = 'timeout_error';

    case API_ERROR = 'api_error';

    case OVERLOADED_ERROR = 'overloaded_error';

    case MEMORY_PRECONDITION_FAILED_ERROR = 'memory_precondition_failed_error';

    case MEMORY_PATH_CONFLICT_ERROR = 'memory_path_conflict_error';

    case CONFLICT_ERROR = 'conflict_error';
}
