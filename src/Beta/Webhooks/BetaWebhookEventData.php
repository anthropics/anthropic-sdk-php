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
 * @phpstan-import-type BetaWebhookSessionStatusScheduledEventDataShape from \Anthropic\Beta\Webhooks\BetaWebhookSessionStatusScheduledEventData
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
 *
 * @phpstan-type BetaWebhookEventDataVariants = BetaWebhookSessionCreatedEventData|BetaWebhookSessionPendingEventData|BetaWebhookSessionRunningEventData|BetaWebhookSessionIdledEventData|BetaWebhookSessionRequiresActionEventData|BetaWebhookSessionArchivedEventData|BetaWebhookSessionDeletedEventData|BetaWebhookSessionStatusScheduledEventData|BetaWebhookSessionStatusRunStartedEventData|BetaWebhookSessionStatusIdledEventData|BetaWebhookSessionStatusTerminatedEventData|BetaWebhookSessionThreadCreatedEventData|BetaWebhookSessionThreadIdledEventData|BetaWebhookSessionThreadTerminatedEventData|BetaWebhookSessionOutcomeEvaluationEndedEventData|BetaWebhookVaultCreatedEventData|BetaWebhookVaultArchivedEventData|BetaWebhookVaultDeletedEventData|BetaWebhookVaultCredentialCreatedEventData|BetaWebhookVaultCredentialArchivedEventData|BetaWebhookVaultCredentialDeletedEventData|BetaWebhookVaultCredentialRefreshFailedEventData
 * @phpstan-type BetaWebhookEventDataShape = BetaWebhookEventDataVariants|BetaWebhookSessionCreatedEventDataShape|BetaWebhookSessionPendingEventDataShape|BetaWebhookSessionRunningEventDataShape|BetaWebhookSessionIdledEventDataShape|BetaWebhookSessionRequiresActionEventDataShape|BetaWebhookSessionArchivedEventDataShape|BetaWebhookSessionDeletedEventDataShape|BetaWebhookSessionStatusScheduledEventDataShape|BetaWebhookSessionStatusRunStartedEventDataShape|BetaWebhookSessionStatusIdledEventDataShape|BetaWebhookSessionStatusTerminatedEventDataShape|BetaWebhookSessionThreadCreatedEventDataShape|BetaWebhookSessionThreadIdledEventDataShape|BetaWebhookSessionThreadTerminatedEventDataShape|BetaWebhookSessionOutcomeEvaluationEndedEventDataShape|BetaWebhookVaultCreatedEventDataShape|BetaWebhookVaultArchivedEventDataShape|BetaWebhookVaultDeletedEventDataShape|BetaWebhookVaultCredentialCreatedEventDataShape|BetaWebhookVaultCredentialArchivedEventDataShape|BetaWebhookVaultCredentialDeletedEventDataShape|BetaWebhookVaultCredentialRefreshFailedEventDataShape
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
            'session.status_scheduled' => BetaWebhookSessionStatusScheduledEventData::class,
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
        ];
    }
}
