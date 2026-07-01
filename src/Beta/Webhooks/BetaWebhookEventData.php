<?php

declare(strict_types=1);

namespace Anthropic\Beta\Webhooks;

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
 *
 * @phpstan-type BetaWebhookEventDataVariants = BetaWebhookSessionCreatedEventData|BetaWebhookSessionPendingEventData|BetaWebhookSessionRunningEventData|BetaWebhookSessionIdledEventData|BetaWebhookSessionRequiresActionEventData|BetaWebhookSessionArchivedEventData|BetaWebhookSessionDeletedEventData|BetaWebhookSessionStatusRescheduledEventData|BetaWebhookSessionStatusRunStartedEventData|BetaWebhookSessionStatusIdledEventData|BetaWebhookSessionStatusTerminatedEventData|BetaWebhookSessionThreadCreatedEventData|BetaWebhookSessionThreadIdledEventData|BetaWebhookSessionThreadTerminatedEventData|BetaWebhookSessionOutcomeEvaluationEndedEventData|BetaWebhookVaultCreatedEventData|BetaWebhookVaultArchivedEventData|BetaWebhookVaultDeletedEventData|BetaWebhookVaultCredentialCreatedEventData|BetaWebhookVaultCredentialArchivedEventData|BetaWebhookVaultCredentialDeletedEventData|BetaWebhookVaultCredentialRefreshFailedEventData|BetaWebhookSessionUpdatedEventData|BetaWebhookAgentCreatedEventData|BetaWebhookAgentArchivedEventData|BetaWebhookAgentDeletedEventData|BetaWebhookDeploymentPausedEventData|BetaWebhookDeploymentRunFailedEventData|BetaWebhookDeploymentCreatedEventData|BetaWebhookDeploymentUpdatedEventData|BetaWebhookDeploymentUnpausedEventData|BetaWebhookAgentUpdatedEventData|BetaWebhookDeploymentArchivedEventData|BetaWebhookDeploymentRunStartedEventData|BetaWebhookDeploymentDeletedEventData|BetaWebhookDeploymentRunSucceededEventData
 * @phpstan-type BetaWebhookEventDataShape = BetaWebhookEventDataVariants|BetaWebhookSessionCreatedEventDataShape|BetaWebhookSessionPendingEventDataShape|BetaWebhookSessionRunningEventDataShape|BetaWebhookSessionIdledEventDataShape|BetaWebhookSessionRequiresActionEventDataShape|BetaWebhookSessionArchivedEventDataShape|BetaWebhookSessionDeletedEventDataShape|BetaWebhookSessionStatusRescheduledEventDataShape|BetaWebhookSessionStatusRunStartedEventDataShape|BetaWebhookSessionStatusIdledEventDataShape|BetaWebhookSessionStatusTerminatedEventDataShape|BetaWebhookSessionThreadCreatedEventDataShape|BetaWebhookSessionThreadIdledEventDataShape|BetaWebhookSessionThreadTerminatedEventDataShape|BetaWebhookSessionOutcomeEvaluationEndedEventDataShape|BetaWebhookVaultCreatedEventDataShape|BetaWebhookVaultArchivedEventDataShape|BetaWebhookVaultDeletedEventDataShape|BetaWebhookVaultCredentialCreatedEventDataShape|BetaWebhookVaultCredentialArchivedEventDataShape|BetaWebhookVaultCredentialDeletedEventDataShape|BetaWebhookVaultCredentialRefreshFailedEventDataShape|BetaWebhookSessionUpdatedEventDataShape|BetaWebhookAgentCreatedEventDataShape|BetaWebhookAgentArchivedEventDataShape|BetaWebhookAgentDeletedEventDataShape|BetaWebhookDeploymentPausedEventDataShape|BetaWebhookDeploymentRunFailedEventDataShape|BetaWebhookDeploymentCreatedEventDataShape|BetaWebhookDeploymentUpdatedEventDataShape|BetaWebhookDeploymentUnpausedEventDataShape|BetaWebhookAgentUpdatedEventDataShape|BetaWebhookDeploymentArchivedEventDataShape|BetaWebhookDeploymentRunStartedEventDataShape|BetaWebhookDeploymentDeletedEventDataShape|BetaWebhookDeploymentRunSucceededEventDataShape
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
        ];
    }
}
