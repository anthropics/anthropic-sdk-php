<?php

declare(strict_types=1);

namespace Anthropic\Beta\Webhooks;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type BetaWebhookEventDataVariants from \Anthropic\Beta\Webhooks\BetaWebhookEventData
 * @phpstan-import-type BetaWebhookEventDataShape from \Anthropic\Beta\Webhooks\BetaWebhookEventData
 *
 * @phpstan-type BetaWebhookEventShape = array{
 *   id: string,
 *   createdAt: \DateTimeInterface,
 *   data: BetaWebhookEventDataShape,
 *   type: 'event',
 * }
 */
final class BetaWebhookEvent implements BaseModel
{
    /** @use SdkModel<BetaWebhookEventShape> */
    use SdkModel;

    /**
     * Object type. Always `event` for webhook payloads.
     *
     * @var 'event' $type
     */
    #[Required]
    public string $type = 'event';

    /**
     * Unique event identifier for idempotency.
     */
    #[Required]
    public string $id;

    /**
     * RFC 3339 timestamp when the event occurred.
     */
    #[Required('created_at')]
    public \DateTimeInterface $createdAt;

    /** @var BetaWebhookEventDataVariants $data */
    #[Required(union: BetaWebhookEventData::class)]
    public BetaWebhookSessionCreatedEventData|BetaWebhookSessionPendingEventData|BetaWebhookSessionRunningEventData|BetaWebhookSessionIdledEventData|BetaWebhookSessionRequiresActionEventData|BetaWebhookSessionArchivedEventData|BetaWebhookSessionDeletedEventData|BetaWebhookSessionStatusScheduledEventData|BetaWebhookSessionStatusRunStartedEventData|BetaWebhookSessionStatusIdledEventData|BetaWebhookSessionStatusTerminatedEventData|BetaWebhookSessionThreadCreatedEventData|BetaWebhookSessionThreadIdledEventData|BetaWebhookSessionThreadTerminatedEventData|BetaWebhookSessionOutcomeEvaluationEndedEventData|BetaWebhookVaultCreatedEventData|BetaWebhookVaultArchivedEventData|BetaWebhookVaultDeletedEventData|BetaWebhookVaultCredentialCreatedEventData|BetaWebhookVaultCredentialArchivedEventData|BetaWebhookVaultCredentialDeletedEventData|BetaWebhookVaultCredentialRefreshFailedEventData $data;

    /**
     * `new BetaWebhookEvent()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaWebhookEvent::with(id: ..., createdAt: ..., data: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaWebhookEvent)->withID(...)->withCreatedAt(...)->withData(...)
     * ```
     */
    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param BetaWebhookEventDataShape $data
     */
    public static function with(
        string $id,
        \DateTimeInterface $createdAt,
        BetaWebhookSessionCreatedEventData|array|BetaWebhookSessionPendingEventData|BetaWebhookSessionRunningEventData|BetaWebhookSessionIdledEventData|BetaWebhookSessionRequiresActionEventData|BetaWebhookSessionArchivedEventData|BetaWebhookSessionDeletedEventData|BetaWebhookSessionStatusScheduledEventData|BetaWebhookSessionStatusRunStartedEventData|BetaWebhookSessionStatusIdledEventData|BetaWebhookSessionStatusTerminatedEventData|BetaWebhookSessionThreadCreatedEventData|BetaWebhookSessionThreadIdledEventData|BetaWebhookSessionThreadTerminatedEventData|BetaWebhookSessionOutcomeEvaluationEndedEventData|BetaWebhookVaultCreatedEventData|BetaWebhookVaultArchivedEventData|BetaWebhookVaultDeletedEventData|BetaWebhookVaultCredentialCreatedEventData|BetaWebhookVaultCredentialArchivedEventData|BetaWebhookVaultCredentialDeletedEventData|BetaWebhookVaultCredentialRefreshFailedEventData $data,
    ): self {
        $self = new self;

        $self['id'] = $id;
        $self['createdAt'] = $createdAt;
        $self['data'] = $data;

        return $self;
    }

    /**
     * Unique event identifier for idempotency.
     */
    public function withID(string $id): self
    {
        $self = clone $this;
        $self['id'] = $id;

        return $self;
    }

    /**
     * RFC 3339 timestamp when the event occurred.
     */
    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $self = clone $this;
        $self['createdAt'] = $createdAt;

        return $self;
    }

    /**
     * @param BetaWebhookEventDataShape $data
     */
    public function withData(
        BetaWebhookSessionCreatedEventData|array|BetaWebhookSessionPendingEventData|BetaWebhookSessionRunningEventData|BetaWebhookSessionIdledEventData|BetaWebhookSessionRequiresActionEventData|BetaWebhookSessionArchivedEventData|BetaWebhookSessionDeletedEventData|BetaWebhookSessionStatusScheduledEventData|BetaWebhookSessionStatusRunStartedEventData|BetaWebhookSessionStatusIdledEventData|BetaWebhookSessionStatusTerminatedEventData|BetaWebhookSessionThreadCreatedEventData|BetaWebhookSessionThreadIdledEventData|BetaWebhookSessionThreadTerminatedEventData|BetaWebhookSessionOutcomeEvaluationEndedEventData|BetaWebhookVaultCreatedEventData|BetaWebhookVaultArchivedEventData|BetaWebhookVaultDeletedEventData|BetaWebhookVaultCredentialCreatedEventData|BetaWebhookVaultCredentialArchivedEventData|BetaWebhookVaultCredentialDeletedEventData|BetaWebhookVaultCredentialRefreshFailedEventData $data,
    ): self {
        $self = clone $this;
        $self['data'] = $data;

        return $self;
    }

    /**
     * Object type. Always `event` for webhook payloads.
     *
     * @param 'event' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
