<?php

declare(strict_types=1);

namespace Anthropic\Models\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Models\Messages\MessageBatch\ProcessingStatus;

/**
 * @phpstan-type message_batch_alias = array{
 *   id: string,
 *   archivedAt: \DateTimeInterface|null,
 *   cancelInitiatedAt: \DateTimeInterface|null,
 *   createdAt: \DateTimeInterface,
 *   endedAt: \DateTimeInterface|null,
 *   expiresAt: \DateTimeInterface,
 *   processingStatus: ProcessingStatus::*,
 *   requestCounts: MessageBatchRequestCounts,
 *   resultsURL: string|null,
 *   type: string,
 * }
 */
final class MessageBatch implements BaseModel
{
    use Model;

    /**
     * Object type.
     *
     * For Message Batches, this is always `"message_batch"`.
     */
    #[Api]
    public string $type = 'message_batch';

    /**
     * Unique object identifier.
     *
     * The format and length of IDs may change over time.
     */
    #[Api]
    public string $id;

    /**
     * RFC 3339 datetime string representing the time at which the Message Batch was archived and its results became unavailable.
     */
    #[Api('archived_at')]
    public ?\DateTimeInterface $archivedAt;

    /**
     * RFC 3339 datetime string representing the time at which cancellation was initiated for the Message Batch. Specified only if cancellation was initiated.
     */
    #[Api('cancel_initiated_at')]
    public ?\DateTimeInterface $cancelInitiatedAt;

    /**
     * RFC 3339 datetime string representing the time at which the Message Batch was created.
     */
    #[Api('created_at')]
    public \DateTimeInterface $createdAt;

    /**
     * RFC 3339 datetime string representing the time at which processing for the Message Batch ended. Specified only once processing ends.
     *
     * Processing ends when every request in a Message Batch has either succeeded, errored, canceled, or expired.
     */
    #[Api('ended_at')]
    public ?\DateTimeInterface $endedAt;

    /**
     * RFC 3339 datetime string representing the time at which the Message Batch will expire and end processing, which is 24 hours after creation.
     */
    #[Api('expires_at')]
    public \DateTimeInterface $expiresAt;

    /**
     * Processing status of the Message Batch.
     *
     * @var ProcessingStatus::* $processingStatus
     */
    #[Api('processing_status')]
    public string $processingStatus;

    /**
     * Tallies requests within the Message Batch, categorized by their status.
     *
     * Requests start as `processing` and move to one of the other statuses only once processing of the entire batch ends. The sum of all values always matches the total number of requests in the batch.
     */
    #[Api('request_counts')]
    public MessageBatchRequestCounts $requestCounts;

    /**
     * URL to a `.jsonl` file containing the results of the Message Batch requests. Specified only once processing ends.
     *
     * Results in the file are not guaranteed to be in the same order as requests. Use the `custom_id` field to match results to requests.
     */
    #[Api('results_url')]
    public ?string $resultsURL;

    /**
     * You must use named parameters to construct this object.
     *
     * @param ProcessingStatus::* $processingStatus
     */
    final public function __construct(
        string $id,
        ?\DateTimeInterface $archivedAt,
        ?\DateTimeInterface $cancelInitiatedAt,
        \DateTimeInterface $createdAt,
        ?\DateTimeInterface $endedAt,
        \DateTimeInterface $expiresAt,
        string $processingStatus,
        MessageBatchRequestCounts $requestCounts,
        ?string $resultsURL,
    ) {
        self::introspect();

        $this->id = $id;
        $this->archivedAt = $archivedAt;
        $this->cancelInitiatedAt = $cancelInitiatedAt;
        $this->createdAt = $createdAt;
        $this->endedAt = $endedAt;
        $this->expiresAt = $expiresAt;
        $this->processingStatus = $processingStatus;
        $this->requestCounts = $requestCounts;
        $this->resultsURL = $resultsURL;
    }
}
