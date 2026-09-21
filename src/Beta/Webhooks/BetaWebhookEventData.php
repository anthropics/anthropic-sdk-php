<?php

declare(strict_types=1);

namespace Anthropic\Beta\Webhooks;

use Anthropic\Beta\Webhooks\BetaWebhookEventData\Type;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-import-type BetaWebhookSessionCreatedEventDataShape from \Anthropic\Beta\Webhooks\BetaWebhookSessionCreatedEventData
 * @phpstan-import-type BetaWebhookSessionPendingEventDataShape from \Anthropic\Beta\Webhooks\BetaWebhookSessionPendingEventData
 * @phpstan-import-type BetaWebhookSessionRunningEventDataShape from \Anthropic\Beta\Webhooks\BetaWebhookSessionRunningEventData
 * @phpstan-import-type BetaWebhookSessionIdledEventDataShape from \Anthropic\Beta\Webhooks\BetaWebhookSessionIdledEventData
 * @phpstan-import-type BetaWebhookSessionRequiresActionEventDataShape from \Anthropic\Beta\Webhooks\BetaWebhookSessionRequiresActionEventData
 * @phpstan-import-type BetaWebhookSessionArchivedEventDataShape from \Anthropic\Beta\Webhooks\BetaWebhookSessionArchivedEventData
 * @phpstan-import-type BetaWebhookSessionDeletedEventDataShape from \Anthropic\Beta\Webhooks\BetaWebhookSessionDeletedEventData
 * @phpstan-import-type BetaWebhookSessionStatusRescheduledEventDataShape from \Anthropic\Beta\Webhooks\BetaWebhookSessionStatusRescheduledEventData
 * @phpstan-import-type BetaWebhookSessionStatusRunStartedEventDataShape from \Anthropic\Beta\Webhooks\BetaWebhookSessionStatusRunStartedEventData
 * @phpstan-import-type BetaWebhookSessionStatusIdledEventDataShape from \Anthropic\Beta\Webhooks\BetaWebhookSessionStatusIdledEventData
 * @phpstan-import-type BetaWebhookSessionStatusTerminatedEventDataShape from \Anthropic\Beta\Webhooks\BetaWebhookSessionStatusTerminatedEventData
 * @phpstan-import-type BetaWebhookSessionThreadCreatedEventDataShape from \Anthropic\Beta\Webhooks\BetaWebhookSessionThreadCreatedEventData
 * @phpstan-import-type BetaWebhookSessionThreadIdledEventDataShape from \Anthropic\Beta\Webhooks\BetaWebhookSessionThreadIdledEventData
 * @phpstan-import-type BetaWebhookSessionThreadTerminatedEventDataShape from \Anthropic\Beta\Webhooks\BetaWebhookSessionThreadTerminatedEventData
 * @phpstan-import-type BetaWebhookSessionOutcomeEvaluationEndedEventDataShape from \Anthropic\Beta\Webhooks\BetaWebhookSessionOutcomeEvaluationEndedEventData
 * @phpstan-import-type BetaWebhookVaultCreatedEventDataShape from \Anthropic\Beta\Webhooks\BetaWebhookVaultCreatedEventData
 * @phpstan-import-type BetaWebhookVaultArchivedEventDataShape from \Anthropic\Beta\Webhooks\BetaWebhookVaultArchivedEventData
 * @phpstan-import-type BetaWebhookVaultDeletedEventDataShape from \Anthropic\Beta\Webhooks\BetaWebhookVaultDeletedEventData
 * @phpstan-import-type BetaWebhookVaultCredentialCreatedEventDataShape from \Anthropic\Beta\Webhooks\BetaWebhookVaultCredentialCreatedEventData
 * @phpstan-import-type BetaWebhookVaultCredentialArchivedEventDataShape from \Anthropic\Beta\Webhooks\BetaWebhookVaultCredentialArchivedEventData
 * @phpstan-import-type BetaWebhookVaultCredentialDeletedEventDataShape from \Anthropic\Beta\Webhooks\BetaWebhookVaultCredentialDeletedEventData
 * @phpstan-import-type BetaWebhookVaultCredentialRefreshFailedEventDataShape from \Anthropic\Beta\Webhooks\BetaWebhookVaultCredentialRefreshFailedEventData
 * @phpstan-import-type BetaWebhookSessionUpdatedEventDataShape from \Anthropic\Beta\Webhooks\BetaWebhookSessionUpdatedEventData
 * @phpstan-import-type BetaWebhookAgentCreatedEventDataShape from \Anthropic\Beta\Webhooks\BetaWebhookAgentCreatedEventData
 * @phpstan-import-type BetaWebhookAgentArchivedEventDataShape from \Anthropic\Beta\Webhooks\BetaWebhookAgentArchivedEventData
 * @phpstan-import-type BetaWebhookAgentDeletedEventDataShape from \Anthropic\Beta\Webhooks\BetaWebhookAgentDeletedEventData
 * @phpstan-import-type BetaWebhookDeploymentPausedEventDataShape from \Anthropic\Beta\Webhooks\BetaWebhookDeploymentPausedEventData
 * @phpstan-import-type BetaWebhookDeploymentRunFailedEventDataShape from \Anthropic\Beta\Webhooks\BetaWebhookDeploymentRunFailedEventData
 * @phpstan-import-type BetaWebhookDeploymentCreatedEventDataShape from \Anthropic\Beta\Webhooks\BetaWebhookDeploymentCreatedEventData
 * @phpstan-import-type BetaWebhookDeploymentUpdatedEventDataShape from \Anthropic\Beta\Webhooks\BetaWebhookDeploymentUpdatedEventData
 * @phpstan-import-type BetaWebhookDeploymentUnpausedEventDataShape from \Anthropic\Beta\Webhooks\BetaWebhookDeploymentUnpausedEventData
 * @phpstan-import-type BetaWebhookAgentUpdatedEventDataShape from \Anthropic\Beta\Webhooks\BetaWebhookAgentUpdatedEventData
 * @phpstan-import-type BetaWebhookDeploymentArchivedEventDataShape from \Anthropic\Beta\Webhooks\BetaWebhookDeploymentArchivedEventData
 * @phpstan-import-type BetaWebhookDeploymentRunStartedEventDataShape from \Anthropic\Beta\Webhooks\BetaWebhookDeploymentRunStartedEventData
 * @phpstan-import-type BetaWebhookDeploymentDeletedEventDataShape from \Anthropic\Beta\Webhooks\BetaWebhookDeploymentDeletedEventData
 * @phpstan-import-type BetaWebhookDeploymentRunSucceededEventDataShape from \Anthropic\Beta\Webhooks\BetaWebhookDeploymentRunSucceededEventData
 * @phpstan-import-type BetaWebhookEnvironmentCreatedEventDataShape from \Anthropic\Beta\Webhooks\BetaWebhookEnvironmentCreatedEventData
 * @phpstan-import-type BetaWebhookEnvironmentUpdatedEventDataShape from \Anthropic\Beta\Webhooks\BetaWebhookEnvironmentUpdatedEventData
 * @phpstan-import-type BetaWebhookEnvironmentArchivedEventDataShape from \Anthropic\Beta\Webhooks\BetaWebhookEnvironmentArchivedEventData
 * @phpstan-import-type BetaWebhookEnvironmentDeletedEventDataShape from \Anthropic\Beta\Webhooks\BetaWebhookEnvironmentDeletedEventData
 * @phpstan-import-type BetaWebhookMemoryStoreCreatedEventDataShape from \Anthropic\Beta\Webhooks\BetaWebhookMemoryStoreCreatedEventData
 * @phpstan-import-type BetaWebhookMemoryStoreArchivedEventDataShape from \Anthropic\Beta\Webhooks\BetaWebhookMemoryStoreArchivedEventData
 * @phpstan-import-type BetaWebhookMemoryStoreDeletedEventDataShape from \Anthropic\Beta\Webhooks\BetaWebhookMemoryStoreDeletedEventData
 * @phpstan-import-type BetaWebhookSessionBudgetReachedEventDataShape from \Anthropic\Beta\Webhooks\BetaWebhookSessionBudgetReachedEventData
 *
 * @phpstan-type BetaWebhookEventDataVariants = BetaWebhookSessionCreatedEventData|BetaWebhookSessionPendingEventData|BetaWebhookSessionRunningEventData|BetaWebhookSessionIdledEventData|BetaWebhookSessionRequiresActionEventData|BetaWebhookSessionArchivedEventData|BetaWebhookSessionDeletedEventData|BetaWebhookSessionStatusRescheduledEventData|BetaWebhookSessionStatusRunStartedEventData|BetaWebhookSessionStatusIdledEventData|BetaWebhookSessionStatusTerminatedEventData|BetaWebhookSessionThreadCreatedEventData|BetaWebhookSessionThreadIdledEventData|BetaWebhookSessionThreadTerminatedEventData|BetaWebhookSessionOutcomeEvaluationEndedEventData|BetaWebhookVaultCreatedEventData|BetaWebhookVaultArchivedEventData|BetaWebhookVaultDeletedEventData|BetaWebhookVaultCredentialCreatedEventData|BetaWebhookVaultCredentialArchivedEventData|BetaWebhookVaultCredentialDeletedEventData|BetaWebhookVaultCredentialRefreshFailedEventData|BetaWebhookSessionUpdatedEventData|BetaWebhookAgentCreatedEventData|BetaWebhookAgentArchivedEventData|BetaWebhookAgentDeletedEventData|BetaWebhookDeploymentPausedEventData|BetaWebhookDeploymentRunFailedEventData|BetaWebhookDeploymentCreatedEventData|BetaWebhookDeploymentUpdatedEventData|BetaWebhookDeploymentUnpausedEventData|BetaWebhookAgentUpdatedEventData|BetaWebhookDeploymentArchivedEventData|BetaWebhookDeploymentRunStartedEventData|BetaWebhookDeploymentDeletedEventData|BetaWebhookDeploymentRunSucceededEventData|BetaWebhookEnvironmentCreatedEventData|BetaWebhookEnvironmentUpdatedEventData|BetaWebhookEnvironmentArchivedEventData|BetaWebhookEnvironmentDeletedEventData|BetaWebhookMemoryStoreCreatedEventData|BetaWebhookMemoryStoreArchivedEventData|BetaWebhookMemoryStoreDeletedEventData|BetaWebhookSessionBudgetReachedEventData
 * @phpstan-type BetaWebhookEventDataShape = BetaWebhookEventDataVariants|BetaWebhookSessionCreatedEventDataShape|BetaWebhookSessionPendingEventDataShape|BetaWebhookSessionRunningEventDataShape|BetaWebhookSessionIdledEventDataShape|BetaWebhookSessionRequiresActionEventDataShape|BetaWebhookSessionArchivedEventDataShape|BetaWebhookSessionDeletedEventDataShape|BetaWebhookSessionStatusRescheduledEventDataShape|BetaWebhookSessionStatusRunStartedEventDataShape|BetaWebhookSessionStatusIdledEventDataShape|BetaWebhookSessionStatusTerminatedEventDataShape|BetaWebhookSessionThreadCreatedEventDataShape|BetaWebhookSessionThreadIdledEventDataShape|BetaWebhookSessionThreadTerminatedEventDataShape|BetaWebhookSessionOutcomeEvaluationEndedEventDataShape|BetaWebhookVaultCreatedEventDataShape|BetaWebhookVaultArchivedEventDataShape|BetaWebhookVaultDeletedEventDataShape|BetaWebhookVaultCredentialCreatedEventDataShape|BetaWebhookVaultCredentialArchivedEventDataShape|BetaWebhookVaultCredentialDeletedEventDataShape|BetaWebhookVaultCredentialRefreshFailedEventDataShape|BetaWebhookSessionUpdatedEventDataShape|BetaWebhookAgentCreatedEventDataShape|BetaWebhookAgentArchivedEventDataShape|BetaWebhookAgentDeletedEventDataShape|BetaWebhookDeploymentPausedEventDataShape|BetaWebhookDeploymentRunFailedEventDataShape|BetaWebhookDeploymentCreatedEventDataShape|BetaWebhookDeploymentUpdatedEventDataShape|BetaWebhookDeploymentUnpausedEventDataShape|BetaWebhookAgentUpdatedEventDataShape|BetaWebhookDeploymentArchivedEventDataShape|BetaWebhookDeploymentRunStartedEventDataShape|BetaWebhookDeploymentDeletedEventDataShape|BetaWebhookDeploymentRunSucceededEventDataShape|BetaWebhookEnvironmentCreatedEventDataShape|BetaWebhookEnvironmentUpdatedEventDataShape|BetaWebhookEnvironmentArchivedEventDataShape|BetaWebhookEnvironmentDeletedEventDataShape|BetaWebhookMemoryStoreCreatedEventDataShape|BetaWebhookMemoryStoreArchivedEventDataShape|BetaWebhookMemoryStoreDeletedEventDataShape|BetaWebhookSessionBudgetReachedEventDataShape
 */
final class BetaWebhookEventData implements ConverterSource
{
    use SdkUnion;

    public static function discriminator(): string
    {
        return 'type';
    }

    /**
     * @return list<string|Converter|ConverterSource>|array<string,string|Converter|ConverterSource>
     */
    public static function variants(): array
    {
        return [
            'session.created' => BetaWebhookSessionCreatedEventData::class,
            'session.pending' => BetaWebhookSessionPendingEventData::class,
            'session.running' => BetaWebhookSessionRunningEventData::class,
            'session.idled' => BetaWebhookSessionIdledEventData::class,
            'session.requires_action' => BetaWebhookSessionRequiresActionEventData::class,
            'session.archived' => BetaWebhookSessionArchivedEventData::class,
            'session.deleted' => BetaWebhookSessionDeletedEventData::class,
            'session.status_rescheduled' => BetaWebhookSessionStatusRescheduledEventData::class,
            'session.status_run_started' => BetaWebhookSessionStatusRunStartedEventData::class,
            'session.status_idled' => BetaWebhookSessionStatusIdledEventData::class,
            'session.status_terminated' => BetaWebhookSessionStatusTerminatedEventData::class,
            'session.thread_created' => BetaWebhookSessionThreadCreatedEventData::class,
            'session.thread_idled' => BetaWebhookSessionThreadIdledEventData::class,
            'session.thread_terminated' => BetaWebhookSessionThreadTerminatedEventData::class,
            'session.outcome_evaluation_ended' => BetaWebhookSessionOutcomeEvaluationEndedEventData::class,
            'vault.created' => BetaWebhookVaultCreatedEventData::class,
            'vault.archived' => BetaWebhookVaultArchivedEventData::class,
            'vault.deleted' => BetaWebhookVaultDeletedEventData::class,
            'vault_credential.created' => BetaWebhookVaultCredentialCreatedEventData::class,
            'vault_credential.archived' => BetaWebhookVaultCredentialArchivedEventData::class,
            'vault_credential.deleted' => BetaWebhookVaultCredentialDeletedEventData::class,
            'vault_credential.refresh_failed' => BetaWebhookVaultCredentialRefreshFailedEventData::class,
            'session.updated' => BetaWebhookSessionUpdatedEventData::class,
            'agent.created' => BetaWebhookAgentCreatedEventData::class,
            'agent.archived' => BetaWebhookAgentArchivedEventData::class,
            'agent.deleted' => BetaWebhookAgentDeletedEventData::class,
            'deployment.paused' => BetaWebhookDeploymentPausedEventData::class,
            'deployment_run.failed' => BetaWebhookDeploymentRunFailedEventData::class,
            'deployment.created' => BetaWebhookDeploymentCreatedEventData::class,
            'deployment.updated' => BetaWebhookDeploymentUpdatedEventData::class,
            'deployment.unpaused' => BetaWebhookDeploymentUnpausedEventData::class,
            'agent.updated' => BetaWebhookAgentUpdatedEventData::class,
            'deployment.archived' => BetaWebhookDeploymentArchivedEventData::class,
            'deployment_run.started' => BetaWebhookDeploymentRunStartedEventData::class,
            'deployment.deleted' => BetaWebhookDeploymentDeletedEventData::class,
            'deployment_run.succeeded' => BetaWebhookDeploymentRunSucceededEventData::class,
            'environment.created' => BetaWebhookEnvironmentCreatedEventData::class,
            'environment.updated' => BetaWebhookEnvironmentUpdatedEventData::class,
            'environment.archived' => BetaWebhookEnvironmentArchivedEventData::class,
            'environment.deleted' => BetaWebhookEnvironmentDeletedEventData::class,
            'memory_store.created' => BetaWebhookMemoryStoreCreatedEventData::class,
            'memory_store.archived' => BetaWebhookMemoryStoreArchivedEventData::class,
            'memory_store.deleted' => BetaWebhookMemoryStoreDeletedEventData::class,
            'session.budget_reached' => BetaWebhookSessionBudgetReachedEventData::class,
        ];
    }

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @return ($type is Type::SESSION_CREATED|'session.created' ? BetaWebhookSessionCreatedEventData : ($type is Type::SESSION_PENDING|'session.pending' ? BetaWebhookSessionPendingEventData : ($type is Type::SESSION_RUNNING|'session.running' ? BetaWebhookSessionRunningEventData : ($type is Type::SESSION_IDLED|'session.idled' ? BetaWebhookSessionIdledEventData : ($type is Type::SESSION_REQUIRES_ACTION|'session.requires_action' ? BetaWebhookSessionRequiresActionEventData : ($type is Type::SESSION_ARCHIVED|'session.archived' ? BetaWebhookSessionArchivedEventData : ($type is Type::SESSION_DELETED|'session.deleted' ? BetaWebhookSessionDeletedEventData : ($type is Type::SESSION_STATUS_RESCHEDULED|'session.status_rescheduled' ? BetaWebhookSessionStatusRescheduledEventData : ($type is Type::SESSION_STATUS_RUN_STARTED|'session.status_run_started' ? BetaWebhookSessionStatusRunStartedEventData : ($type is Type::SESSION_STATUS_IDLED|'session.status_idled' ? BetaWebhookSessionStatusIdledEventData : ($type is Type::SESSION_STATUS_TERMINATED|'session.status_terminated' ? BetaWebhookSessionStatusTerminatedEventData : ($type is Type::SESSION_THREAD_CREATED|'session.thread_created' ? BetaWebhookSessionThreadCreatedEventData : ($type is Type::SESSION_THREAD_IDLED|'session.thread_idled' ? BetaWebhookSessionThreadIdledEventData : ($type is Type::SESSION_THREAD_TERMINATED|'session.thread_terminated' ? BetaWebhookSessionThreadTerminatedEventData : ($type is Type::SESSION_OUTCOME_EVALUATION_ENDED|'session.outcome_evaluation_ended' ? BetaWebhookSessionOutcomeEvaluationEndedEventData : ($type is Type::VAULT_CREATED|'vault.created' ? BetaWebhookVaultCreatedEventData : ($type is Type::VAULT_ARCHIVED|'vault.archived' ? BetaWebhookVaultArchivedEventData : ($type is Type::VAULT_DELETED|'vault.deleted' ? BetaWebhookVaultDeletedEventData : ($type is Type::VAULT_CREDENTIAL_CREATED|'vault_credential.created' ? BetaWebhookVaultCredentialCreatedEventData : ($type is Type::VAULT_CREDENTIAL_ARCHIVED|'vault_credential.archived' ? BetaWebhookVaultCredentialArchivedEventData : ($type is Type::VAULT_CREDENTIAL_DELETED|'vault_credential.deleted' ? BetaWebhookVaultCredentialDeletedEventData : ($type is Type::VAULT_CREDENTIAL_REFRESH_FAILED|'vault_credential.refresh_failed' ? BetaWebhookVaultCredentialRefreshFailedEventData : ($type is Type::SESSION_UPDATED|'session.updated' ? BetaWebhookSessionUpdatedEventData : ($type is Type::AGENT_CREATED|'agent.created' ? BetaWebhookAgentCreatedEventData : ($type is Type::AGENT_ARCHIVED|'agent.archived' ? BetaWebhookAgentArchivedEventData : ($type is Type::AGENT_DELETED|'agent.deleted' ? BetaWebhookAgentDeletedEventData : ($type is Type::DEPLOYMENT_PAUSED|'deployment.paused' ? BetaWebhookDeploymentPausedEventData : ($type is Type::DEPLOYMENT_RUN_FAILED|'deployment_run.failed' ? BetaWebhookDeploymentRunFailedEventData : ($type is Type::DEPLOYMENT_CREATED|'deployment.created' ? BetaWebhookDeploymentCreatedEventData : ($type is Type::DEPLOYMENT_UPDATED|'deployment.updated' ? BetaWebhookDeploymentUpdatedEventData : ($type is Type::DEPLOYMENT_UNPAUSED|'deployment.unpaused' ? BetaWebhookDeploymentUnpausedEventData : ($type is Type::AGENT_UPDATED|'agent.updated' ? BetaWebhookAgentUpdatedEventData : ($type is Type::DEPLOYMENT_ARCHIVED|'deployment.archived' ? BetaWebhookDeploymentArchivedEventData : ($type is Type::DEPLOYMENT_RUN_STARTED|'deployment_run.started' ? BetaWebhookDeploymentRunStartedEventData : ($type is Type::DEPLOYMENT_DELETED|'deployment.deleted' ? BetaWebhookDeploymentDeletedEventData : ($type is Type::DEPLOYMENT_RUN_SUCCEEDED|'deployment_run.succeeded' ? BetaWebhookDeploymentRunSucceededEventData : ($type is Type::ENVIRONMENT_CREATED|'environment.created' ? BetaWebhookEnvironmentCreatedEventData : ($type is Type::ENVIRONMENT_UPDATED|'environment.updated' ? BetaWebhookEnvironmentUpdatedEventData : ($type is Type::ENVIRONMENT_ARCHIVED|'environment.archived' ? BetaWebhookEnvironmentArchivedEventData : ($type is Type::ENVIRONMENT_DELETED|'environment.deleted' ? BetaWebhookEnvironmentDeletedEventData : ($type is Type::MEMORY_STORE_CREATED|'memory_store.created' ? BetaWebhookMemoryStoreCreatedEventData : ($type is Type::MEMORY_STORE_ARCHIVED|'memory_store.archived' ? BetaWebhookMemoryStoreArchivedEventData : ($type is Type::MEMORY_STORE_DELETED|'memory_store.deleted' ? BetaWebhookMemoryStoreDeletedEventData : ($type is Type::SESSION_BUDGET_REACHED|'session.budget_reached' ? BetaWebhookSessionBudgetReachedEventData : BetaWebhookSessionCreatedEventData|BetaWebhookSessionPendingEventData|BetaWebhookSessionRunningEventData|BetaWebhookSessionIdledEventData|BetaWebhookSessionRequiresActionEventData|BetaWebhookSessionArchivedEventData|BetaWebhookSessionDeletedEventData|BetaWebhookSessionStatusRescheduledEventData|BetaWebhookSessionStatusRunStartedEventData|BetaWebhookSessionStatusIdledEventData|BetaWebhookSessionStatusTerminatedEventData|BetaWebhookSessionThreadCreatedEventData|BetaWebhookSessionThreadIdledEventData|BetaWebhookSessionThreadTerminatedEventData|BetaWebhookSessionOutcomeEvaluationEndedEventData|BetaWebhookVaultCreatedEventData|BetaWebhookVaultArchivedEventData|BetaWebhookVaultDeletedEventData|BetaWebhookVaultCredentialCreatedEventData|BetaWebhookVaultCredentialArchivedEventData|BetaWebhookVaultCredentialDeletedEventData|BetaWebhookVaultCredentialRefreshFailedEventData|BetaWebhookSessionUpdatedEventData|BetaWebhookAgentCreatedEventData|BetaWebhookAgentArchivedEventData|BetaWebhookAgentDeletedEventData|BetaWebhookDeploymentPausedEventData|BetaWebhookDeploymentRunFailedEventData|BetaWebhookDeploymentCreatedEventData|BetaWebhookDeploymentUpdatedEventData|BetaWebhookDeploymentUnpausedEventData|BetaWebhookAgentUpdatedEventData|BetaWebhookDeploymentArchivedEventData|BetaWebhookDeploymentRunStartedEventData|BetaWebhookDeploymentDeletedEventData|BetaWebhookDeploymentRunSucceededEventData|BetaWebhookEnvironmentCreatedEventData|BetaWebhookEnvironmentUpdatedEventData|BetaWebhookEnvironmentArchivedEventData|BetaWebhookEnvironmentDeletedEventData|BetaWebhookMemoryStoreCreatedEventData|BetaWebhookMemoryStoreArchivedEventData|BetaWebhookMemoryStoreDeletedEventData|BetaWebhookSessionBudgetReachedEventData))))))))))))))))))))))))))))))))))))))))))))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        string $id,
        string $organizationID,
        string $workspaceID,
        ?string $sessionThreadID = null,
        ?string $vaultID = null,
    ): BetaWebhookSessionCreatedEventData|BetaWebhookSessionPendingEventData|BetaWebhookSessionRunningEventData|BetaWebhookSessionIdledEventData|BetaWebhookSessionRequiresActionEventData|BetaWebhookSessionArchivedEventData|BetaWebhookSessionDeletedEventData|BetaWebhookSessionStatusRescheduledEventData|BetaWebhookSessionStatusRunStartedEventData|BetaWebhookSessionStatusIdledEventData|BetaWebhookSessionStatusTerminatedEventData|BetaWebhookSessionThreadCreatedEventData|BetaWebhookSessionThreadIdledEventData|BetaWebhookSessionThreadTerminatedEventData|BetaWebhookSessionOutcomeEvaluationEndedEventData|BetaWebhookVaultCreatedEventData|BetaWebhookVaultArchivedEventData|BetaWebhookVaultDeletedEventData|BetaWebhookVaultCredentialCreatedEventData|BetaWebhookVaultCredentialArchivedEventData|BetaWebhookVaultCredentialDeletedEventData|BetaWebhookVaultCredentialRefreshFailedEventData|BetaWebhookSessionUpdatedEventData|BetaWebhookAgentCreatedEventData|BetaWebhookAgentArchivedEventData|BetaWebhookAgentDeletedEventData|BetaWebhookDeploymentPausedEventData|BetaWebhookDeploymentRunFailedEventData|BetaWebhookDeploymentCreatedEventData|BetaWebhookDeploymentUpdatedEventData|BetaWebhookDeploymentUnpausedEventData|BetaWebhookAgentUpdatedEventData|BetaWebhookDeploymentArchivedEventData|BetaWebhookDeploymentRunStartedEventData|BetaWebhookDeploymentDeletedEventData|BetaWebhookDeploymentRunSucceededEventData|BetaWebhookEnvironmentCreatedEventData|BetaWebhookEnvironmentUpdatedEventData|BetaWebhookEnvironmentArchivedEventData|BetaWebhookEnvironmentDeletedEventData|BetaWebhookMemoryStoreCreatedEventData|BetaWebhookMemoryStoreArchivedEventData|BetaWebhookMemoryStoreDeletedEventData|BetaWebhookSessionBudgetReachedEventData {
        return match ($type) {
            Type::SESSION_CREATED, 'session.created' => BetaWebhookSessionCreatedEventData::with(
                id: $id,
                organizationID: $organizationID,
                workspaceID: $workspaceID
            ),
            Type::SESSION_PENDING, 'session.pending' => BetaWebhookSessionPendingEventData::with(
                id: $id,
                organizationID: $organizationID,
                workspaceID: $workspaceID
            ),
            Type::SESSION_RUNNING, 'session.running' => BetaWebhookSessionRunningEventData::with(
                id: $id,
                organizationID: $organizationID,
                workspaceID: $workspaceID
            ),
            Type::SESSION_IDLED, 'session.idled' => BetaWebhookSessionIdledEventData::with(
                id: $id,
                organizationID: $organizationID,
                workspaceID: $workspaceID
            ),
            Type::SESSION_REQUIRES_ACTION, 'session.requires_action' => BetaWebhookSessionRequiresActionEventData::with(
                id: $id,
                organizationID: $organizationID,
                workspaceID: $workspaceID
            ),
            Type::SESSION_ARCHIVED, 'session.archived' => BetaWebhookSessionArchivedEventData::with(
                id: $id,
                organizationID: $organizationID,
                workspaceID: $workspaceID
            ),
            Type::SESSION_DELETED, 'session.deleted' => BetaWebhookSessionDeletedEventData::with(
                id: $id,
                organizationID: $organizationID,
                workspaceID: $workspaceID
            ),
            Type::SESSION_STATUS_RESCHEDULED, 'session.status_rescheduled' => BetaWebhookSessionStatusRescheduledEventData::with(
                id: $id,
                organizationID: $organizationID,
                workspaceID: $workspaceID
            ),
            Type::SESSION_STATUS_RUN_STARTED, 'session.status_run_started' => BetaWebhookSessionStatusRunStartedEventData::with(
                id: $id,
                organizationID: $organizationID,
                workspaceID: $workspaceID
            ),
            Type::SESSION_STATUS_IDLED, 'session.status_idled' => BetaWebhookSessionStatusIdledEventData::with(
                id: $id,
                organizationID: $organizationID,
                workspaceID: $workspaceID
            ),
            Type::SESSION_STATUS_TERMINATED, 'session.status_terminated' => BetaWebhookSessionStatusTerminatedEventData::with(
                id: $id,
                organizationID: $organizationID,
                workspaceID: $workspaceID
            ),
            Type::SESSION_THREAD_CREATED, 'session.thread_created' => BetaWebhookSessionThreadCreatedEventData::with(
                id: $id,
                organizationID: $organizationID,
                sessionThreadID: $sessionThreadID ?? throw new \ArgumentCountError('$sessionThreadID is required'),
                workspaceID: $workspaceID,
            ),
            Type::SESSION_THREAD_IDLED, 'session.thread_idled' => BetaWebhookSessionThreadIdledEventData::with(
                id: $id,
                organizationID: $organizationID,
                sessionThreadID: $sessionThreadID ?? throw new \ArgumentCountError('$sessionThreadID is required'),
                workspaceID: $workspaceID,
            ),
            Type::SESSION_THREAD_TERMINATED, 'session.thread_terminated' => BetaWebhookSessionThreadTerminatedEventData::with(
                id: $id,
                organizationID: $organizationID,
                sessionThreadID: $sessionThreadID ?? throw new \ArgumentCountError('$sessionThreadID is required'),
                workspaceID: $workspaceID,
            ),
            Type::SESSION_OUTCOME_EVALUATION_ENDED, 'session.outcome_evaluation_ended' => BetaWebhookSessionOutcomeEvaluationEndedEventData::with(
                id: $id,
                organizationID: $organizationID,
                workspaceID: $workspaceID
            ),
            Type::VAULT_CREATED, 'vault.created' => BetaWebhookVaultCreatedEventData::with(
                id: $id,
                organizationID: $organizationID,
                workspaceID: $workspaceID
            ),
            Type::VAULT_ARCHIVED, 'vault.archived' => BetaWebhookVaultArchivedEventData::with(
                id: $id,
                organizationID: $organizationID,
                workspaceID: $workspaceID
            ),
            Type::VAULT_DELETED, 'vault.deleted' => BetaWebhookVaultDeletedEventData::with(
                id: $id,
                organizationID: $organizationID,
                workspaceID: $workspaceID
            ),
            Type::VAULT_CREDENTIAL_CREATED, 'vault_credential.created' => BetaWebhookVaultCredentialCreatedEventData::with(
                id: $id,
                organizationID: $organizationID,
                vaultID: $vaultID ?? throw new \ArgumentCountError('$vaultID is required'),
                workspaceID: $workspaceID,
            ),
            Type::VAULT_CREDENTIAL_ARCHIVED, 'vault_credential.archived' => BetaWebhookVaultCredentialArchivedEventData::with(
                id: $id,
                organizationID: $organizationID,
                vaultID: $vaultID ?? throw new \ArgumentCountError('$vaultID is required'),
                workspaceID: $workspaceID,
            ),
            Type::VAULT_CREDENTIAL_DELETED, 'vault_credential.deleted' => BetaWebhookVaultCredentialDeletedEventData::with(
                id: $id,
                organizationID: $organizationID,
                vaultID: $vaultID ?? throw new \ArgumentCountError('$vaultID is required'),
                workspaceID: $workspaceID,
            ),
            Type::VAULT_CREDENTIAL_REFRESH_FAILED, 'vault_credential.refresh_failed' => BetaWebhookVaultCredentialRefreshFailedEventData::with(
                id: $id,
                organizationID: $organizationID,
                vaultID: $vaultID ?? throw new \ArgumentCountError('$vaultID is required'),
                workspaceID: $workspaceID,
            ),
            Type::SESSION_UPDATED, 'session.updated' => BetaWebhookSessionUpdatedEventData::with(
                id: $id,
                organizationID: $organizationID,
                workspaceID: $workspaceID
            ),
            Type::AGENT_CREATED, 'agent.created' => BetaWebhookAgentCreatedEventData::with(
                id: $id,
                organizationID: $organizationID,
                workspaceID: $workspaceID
            ),
            Type::AGENT_ARCHIVED, 'agent.archived' => BetaWebhookAgentArchivedEventData::with(
                id: $id,
                organizationID: $organizationID,
                workspaceID: $workspaceID
            ),
            Type::AGENT_DELETED, 'agent.deleted' => BetaWebhookAgentDeletedEventData::with(
                id: $id,
                organizationID: $organizationID,
                workspaceID: $workspaceID
            ),
            Type::DEPLOYMENT_PAUSED, 'deployment.paused' => BetaWebhookDeploymentPausedEventData::with(
                id: $id,
                organizationID: $organizationID,
                workspaceID: $workspaceID
            ),
            Type::DEPLOYMENT_RUN_FAILED, 'deployment_run.failed' => BetaWebhookDeploymentRunFailedEventData::with(
                id: $id,
                organizationID: $organizationID,
                workspaceID: $workspaceID
            ),
            Type::DEPLOYMENT_CREATED, 'deployment.created' => BetaWebhookDeploymentCreatedEventData::with(
                id: $id,
                organizationID: $organizationID,
                workspaceID: $workspaceID
            ),
            Type::DEPLOYMENT_UPDATED, 'deployment.updated' => BetaWebhookDeploymentUpdatedEventData::with(
                id: $id,
                organizationID: $organizationID,
                workspaceID: $workspaceID
            ),
            Type::DEPLOYMENT_UNPAUSED, 'deployment.unpaused' => BetaWebhookDeploymentUnpausedEventData::with(
                id: $id,
                organizationID: $organizationID,
                workspaceID: $workspaceID
            ),
            Type::AGENT_UPDATED, 'agent.updated' => BetaWebhookAgentUpdatedEventData::with(
                id: $id,
                organizationID: $organizationID,
                workspaceID: $workspaceID
            ),
            Type::DEPLOYMENT_ARCHIVED, 'deployment.archived' => BetaWebhookDeploymentArchivedEventData::with(
                id: $id,
                organizationID: $organizationID,
                workspaceID: $workspaceID
            ),
            Type::DEPLOYMENT_RUN_STARTED, 'deployment_run.started' => BetaWebhookDeploymentRunStartedEventData::with(
                id: $id,
                organizationID: $organizationID,
                workspaceID: $workspaceID
            ),
            Type::DEPLOYMENT_DELETED, 'deployment.deleted' => BetaWebhookDeploymentDeletedEventData::with(
                id: $id,
                organizationID: $organizationID,
                workspaceID: $workspaceID
            ),
            Type::DEPLOYMENT_RUN_SUCCEEDED, 'deployment_run.succeeded' => BetaWebhookDeploymentRunSucceededEventData::with(
                id: $id,
                organizationID: $organizationID,
                workspaceID: $workspaceID
            ),
            Type::ENVIRONMENT_CREATED, 'environment.created' => BetaWebhookEnvironmentCreatedEventData::with(
                id: $id,
                organizationID: $organizationID,
                workspaceID: $workspaceID
            ),
            Type::ENVIRONMENT_UPDATED, 'environment.updated' => BetaWebhookEnvironmentUpdatedEventData::with(
                id: $id,
                organizationID: $organizationID,
                workspaceID: $workspaceID
            ),
            Type::ENVIRONMENT_ARCHIVED, 'environment.archived' => BetaWebhookEnvironmentArchivedEventData::with(
                id: $id,
                organizationID: $organizationID,
                workspaceID: $workspaceID
            ),
            Type::ENVIRONMENT_DELETED, 'environment.deleted' => BetaWebhookEnvironmentDeletedEventData::with(
                id: $id,
                organizationID: $organizationID,
                workspaceID: $workspaceID
            ),
            Type::MEMORY_STORE_CREATED, 'memory_store.created' => BetaWebhookMemoryStoreCreatedEventData::with(
                id: $id,
                organizationID: $organizationID,
                workspaceID: $workspaceID
            ),
            Type::MEMORY_STORE_ARCHIVED, 'memory_store.archived' => BetaWebhookMemoryStoreArchivedEventData::with(
                id: $id,
                organizationID: $organizationID,
                workspaceID: $workspaceID
            ),
            Type::MEMORY_STORE_DELETED, 'memory_store.deleted' => BetaWebhookMemoryStoreDeletedEventData::with(
                id: $id,
                organizationID: $organizationID,
                workspaceID: $workspaceID
            ),
            Type::SESSION_BUDGET_REACHED, 'session.budget_reached' => BetaWebhookSessionBudgetReachedEventData::with(
                id: $id,
                organizationID: $organizationID,
                workspaceID: $workspaceID
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
