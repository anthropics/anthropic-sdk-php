<?php

declare(strict_types=1);

namespace Anthropic\Beta\Webhooks\BetaWebhookEventData;

enum Type: string
{
    case SESSION_CREATED = 'session.created';

    case SESSION_PENDING = 'session.pending';

    case SESSION_RUNNING = 'session.running';

    case SESSION_IDLED = 'session.idled';

    case SESSION_REQUIRES_ACTION = 'session.requires_action';

    case SESSION_ARCHIVED = 'session.archived';

    case SESSION_DELETED = 'session.deleted';

    case SESSION_STATUS_RESCHEDULED = 'session.status_rescheduled';

    case SESSION_STATUS_RUN_STARTED = 'session.status_run_started';

    case SESSION_STATUS_IDLED = 'session.status_idled';

    case SESSION_STATUS_TERMINATED = 'session.status_terminated';

    case SESSION_THREAD_CREATED = 'session.thread_created';

    case SESSION_THREAD_IDLED = 'session.thread_idled';

    case SESSION_THREAD_TERMINATED = 'session.thread_terminated';

    case SESSION_OUTCOME_EVALUATION_ENDED = 'session.outcome_evaluation_ended';

    case VAULT_CREATED = 'vault.created';

    case VAULT_ARCHIVED = 'vault.archived';

    case VAULT_DELETED = 'vault.deleted';

    case VAULT_CREDENTIAL_CREATED = 'vault_credential.created';

    case VAULT_CREDENTIAL_ARCHIVED = 'vault_credential.archived';

    case VAULT_CREDENTIAL_DELETED = 'vault_credential.deleted';

    case VAULT_CREDENTIAL_REFRESH_FAILED = 'vault_credential.refresh_failed';

    case SESSION_UPDATED = 'session.updated';

    case AGENT_CREATED = 'agent.created';

    case AGENT_ARCHIVED = 'agent.archived';

    case AGENT_DELETED = 'agent.deleted';

    case DEPLOYMENT_PAUSED = 'deployment.paused';

    case DEPLOYMENT_RUN_FAILED = 'deployment_run.failed';

    case DEPLOYMENT_CREATED = 'deployment.created';

    case DEPLOYMENT_UPDATED = 'deployment.updated';

    case DEPLOYMENT_UNPAUSED = 'deployment.unpaused';

    case AGENT_UPDATED = 'agent.updated';

    case DEPLOYMENT_ARCHIVED = 'deployment.archived';

    case DEPLOYMENT_RUN_STARTED = 'deployment_run.started';

    case DEPLOYMENT_DELETED = 'deployment.deleted';

    case DEPLOYMENT_RUN_SUCCEEDED = 'deployment_run.succeeded';

    case ENVIRONMENT_CREATED = 'environment.created';

    case ENVIRONMENT_UPDATED = 'environment.updated';

    case ENVIRONMENT_ARCHIVED = 'environment.archived';

    case ENVIRONMENT_DELETED = 'environment.deleted';

    case MEMORY_STORE_CREATED = 'memory_store.created';

    case MEMORY_STORE_ARCHIVED = 'memory_store.archived';

    case MEMORY_STORE_DELETED = 'memory_store.deleted';

    case SESSION_BUDGET_REACHED = 'session.budget_reached';
}
