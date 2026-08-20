<?php

declare(strict_types=1);

namespace Anthropic\Beta\DeploymentRuns\BetaManagedAgentsDeploymentRun\Error;

enum Type: string
{
    case ENVIRONMENT_ARCHIVED_ERROR = 'environment_archived_error';

    case AGENT_ARCHIVED_ERROR = 'agent_archived_error';

    case ENVIRONMENT_NOT_FOUND_ERROR = 'environment_not_found_error';

    case VAULT_NOT_FOUND_ERROR = 'vault_not_found_error';

    case VAULT_ARCHIVED_ERROR = 'vault_archived_error';

    case FILE_NOT_FOUND_ERROR = 'file_not_found_error';

    case MEMORY_STORE_ARCHIVED_ERROR = 'memory_store_archived_error';

    case SKILL_NOT_FOUND_ERROR = 'skill_not_found_error';

    case SESSION_RESOURCE_NOT_FOUND_ERROR = 'session_resource_not_found_error';

    case WORKSPACE_ARCHIVED_ERROR = 'workspace_archived_error';

    case ORGANIZATION_DISABLED_ERROR = 'organization_disabled_error';

    case SESSION_RATE_LIMITED_ERROR = 'session_rate_limited_error';

    case SESSION_CREATION_REJECTED_ERROR = 'session_creation_rejected_error';

    case UNKNOWN_ERROR = 'unknown_error';

    case SELF_HOSTED_RESOURCES_UNSUPPORTED_ERROR = 'self_hosted_resources_unsupported_error';

    case MCP_EGRESS_BLOCKED_ERROR = 'mcp_egress_blocked_error';
}
