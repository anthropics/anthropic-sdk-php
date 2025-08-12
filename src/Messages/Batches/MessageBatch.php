<?php

declare(strict_types=1);

namespace Anthropic\Messages\Batches;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Messages\Batches\MessageBatch\ProcessingStatus;

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
    #[Api('processing_status', enum: ProcessingStatus::class)]
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

    public function __construct()
    {
        self::introspect();
        $this->unsetOptionalProperties();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param ProcessingStatus::* $processingStatus
     */
    public static function new(
        string $id,
        ?\DateTimeInterface $archivedAt,
        ?\DateTimeInterface $cancelInitiatedAt,
        \DateTimeInterface $createdAt,
        ?\DateTimeInterface $endedAt,
        \DateTimeInterface $expiresAt,
        string $processingStatus,
        MessageBatchRequestCounts $requestCounts,
        ?string $resultsURL,
    ): self {
        $obj = new self;

        $obj->id = $id;
        $obj->archivedAt = $archivedAt;
        $obj->cancelInitiatedAt = $cancelInitiatedAt;
        $obj->createdAt = $createdAt;
        $obj->endedAt = $endedAt;
        $obj->expiresAt = $expiresAt;
        $obj->processingStatus = $processingStatus;
        $obj->requestCounts = $requestCounts;
        $obj->resultsURL = $resultsURL;

        return $obj;
    }

    /**
     * Unique object identifier.
     *
     * The format and length of IDs may change over time.
     */
    public function setID(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * RFC 3339 datetime string representing the time at which the Message Batch was archived and its results became unavailable.
     */
    public function setArchivedAt(?\DateTimeInterface $archivedAt): self
    {
        $this->archivedAt = $archivedAt;

        return $this;
    }

    /**
     * RFC 3339 datetime string representing the time at which cancellation was initiated for the Message Batch. Specified only if cancellation was initiated.
     */
    public function setCancelInitiatedAt(
        ?\DateTimeInterface $cancelInitiatedAt
    ): self {
        $this->cancelInitiatedAt = $cancelInitiatedAt;

        return $this;
    }

    /**
     * RFC 3339 datetime string representing the time at which the Message Batch was created.
     */
    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * RFC 3339 datetime string representing the time at which processing for the Message Batch ended. Specified only once processing ends.
     *
     * Processing ends when every request in a Message Batch has either succeeded, errored, canceled, or expired.
     */
    public function setEndedAt(?\DateTimeInterface $endedAt): self
    {
        $this->endedAt = $endedAt;

        return $this;
    }

    /**
     * RFC 3339 datetime string representing the time at which the Message Batch will expire and end processing, which is 24 hours after creation.
     */
    public function setExpiresAt(\DateTimeInterface $expiresAt): self
    {
        $this->expiresAt = $expiresAt;

        return $this;
    }

    /**
     * Processing status of the Message Batch.
     *
     * @param ProcessingStatus::* $processingStatus
     */
    public function setProcessingStatus(string $processingStatus): self
    {
        $this->processingStatus = $processingStatus;

        return $this;
    }

    /**
     * Tallies requests within the Message Batch, categorized by their status.
     *
     * Requests start as `processing` and move to one of the other statuses only once processing of the entire batch ends. The sum of all values always matches the total number of requests in the batch.
     */
    public function setRequestCounts(
        MessageBatchRequestCounts $requestCounts
    ): self {
        $this->requestCounts = $requestCounts;

        return $this;
    }

    /**
     * URL to a `.jsonl` file containing the results of the Message Batch requests. Specified only once processing ends.
     *
     * Results in the file are not guaranteed to be in the same order as requests. Use the `custom_id` field to match results to requests.
     */
    public function setResultsURL(?string $resultsURL): self
    {
        $this->resultsURL = $resultsURL;

        return $this;
    }
}
