<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\Batches;

use Anthropic\Beta\Messages\Batches\MessageBatch\ProcessingStatus;
use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type MessageBatchShape = array{
 *   id: string,
 *   archivedAt: \DateTimeInterface|null,
 *   cancelInitiatedAt: \DateTimeInterface|null,
 *   createdAt: \DateTimeInterface,
 *   endedAt: \DateTimeInterface|null,
 *   expiresAt: \DateTimeInterface,
 *   processingStatus: value-of<ProcessingStatus>,
 *   requestCounts: MessageBatchRequestCounts,
 *   resultsURL: string|null,
 *   type?: 'message_batch',
 * }
 */
final class MessageBatch implements BaseModel
{
    /** @use SdkModel<MessageBatchShape> */
    use SdkModel;

    /**
     * Object type.
     *
     * For Message Batches, this is always `"message_batch"`.
     *
     * @var 'message_batch' $type
     */
    #[Required]
    public string $type = 'message_batch';

    /**
     * Unique object identifier.
     *
     * The format and length of IDs may change over time.
     */
    #[Required]
    public string $id;

    /**
     * RFC 3339 datetime string representing the time at which the Message Batch was archived and its results became unavailable.
     */
    #[Required('archived_at')]
    public ?\DateTimeInterface $archivedAt;

    /**
     * RFC 3339 datetime string representing the time at which cancellation was initiated for the Message Batch. Specified only if cancellation was initiated.
     */
    #[Required('cancel_initiated_at')]
    public ?\DateTimeInterface $cancelInitiatedAt;

    /**
     * RFC 3339 datetime string representing the time at which the Message Batch was created.
     */
    #[Required('created_at')]
    public \DateTimeInterface $createdAt;

    /**
     * RFC 3339 datetime string representing the time at which processing for the Message Batch ended. Specified only once processing ends.
     *
     * Processing ends when every request in a Message Batch has either succeeded, errored, canceled, or expired.
     */
    #[Required('ended_at')]
    public ?\DateTimeInterface $endedAt;

    /**
     * RFC 3339 datetime string representing the time at which the Message Batch will expire and end processing, which is 24 hours after creation.
     */
    #[Required('expires_at')]
    public \DateTimeInterface $expiresAt;

    /**
     * Processing status of the Message Batch.
     *
     * @var value-of<ProcessingStatus> $processingStatus
     */
    #[Required('processing_status', enum: ProcessingStatus::class)]
    public string $processingStatus;

    /**
     * Tallies requests within the Message Batch, categorized by their status.
     *
     * Requests start as `processing` and move to one of the other statuses only once processing of the entire batch ends. The sum of all values always matches the total number of requests in the batch.
     */
    #[Required('request_counts')]
    public MessageBatchRequestCounts $requestCounts;

    /**
     * URL to a `.jsonl` file containing the results of the Message Batch requests. Specified only once processing ends.
     *
     * Results in the file are not guaranteed to be in the same order as requests. Use the `custom_id` field to match results to requests.
     */
    #[Required('results_url')]
    public ?string $resultsURL;

    /**
     * `new MessageBatch()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * MessageBatch::with(
     *   id: ...,
     *   archivedAt: ...,
     *   cancelInitiatedAt: ...,
     *   createdAt: ...,
     *   endedAt: ...,
     *   expiresAt: ...,
     *   processingStatus: ...,
     *   requestCounts: ...,
     *   resultsURL: ...,
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new MessageBatch)
     *   ->withID(...)
     *   ->withArchivedAt(...)
     *   ->withCancelInitiatedAt(...)
     *   ->withCreatedAt(...)
     *   ->withEndedAt(...)
     *   ->withExpiresAt(...)
     *   ->withProcessingStatus(...)
     *   ->withRequestCounts(...)
     *   ->withResultsURL(...)
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
     * @param ProcessingStatus|value-of<ProcessingStatus> $processingStatus
     * @param MessageBatchRequestCounts|array{
     *   canceled: int, errored: int, expired: int, processing: int, succeeded: int
     * } $requestCounts
     */
    public static function with(
        string $id,
        ?\DateTimeInterface $archivedAt,
        ?\DateTimeInterface $cancelInitiatedAt,
        \DateTimeInterface $createdAt,
        ?\DateTimeInterface $endedAt,
        \DateTimeInterface $expiresAt,
        ProcessingStatus|string $processingStatus,
        MessageBatchRequestCounts|array $requestCounts,
        ?string $resultsURL,
    ): self {
        $obj = new self;

        $obj['id'] = $id;
        $obj['archivedAt'] = $archivedAt;
        $obj['cancelInitiatedAt'] = $cancelInitiatedAt;
        $obj['createdAt'] = $createdAt;
        $obj['endedAt'] = $endedAt;
        $obj['expiresAt'] = $expiresAt;
        $obj['processingStatus'] = $processingStatus;
        $obj['requestCounts'] = $requestCounts;
        $obj['resultsURL'] = $resultsURL;

        return $obj;
    }

    /**
     * Unique object identifier.
     *
     * The format and length of IDs may change over time.
     */
    public function withID(string $id): self
    {
        $obj = clone $this;
        $obj['id'] = $id;

        return $obj;
    }

    /**
     * RFC 3339 datetime string representing the time at which the Message Batch was archived and its results became unavailable.
     */
    public function withArchivedAt(?\DateTimeInterface $archivedAt): self
    {
        $obj = clone $this;
        $obj['archivedAt'] = $archivedAt;

        return $obj;
    }

    /**
     * RFC 3339 datetime string representing the time at which cancellation was initiated for the Message Batch. Specified only if cancellation was initiated.
     */
    public function withCancelInitiatedAt(
        ?\DateTimeInterface $cancelInitiatedAt
    ): self {
        $obj = clone $this;
        $obj['cancelInitiatedAt'] = $cancelInitiatedAt;

        return $obj;
    }

    /**
     * RFC 3339 datetime string representing the time at which the Message Batch was created.
     */
    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $obj = clone $this;
        $obj['createdAt'] = $createdAt;

        return $obj;
    }

    /**
     * RFC 3339 datetime string representing the time at which processing for the Message Batch ended. Specified only once processing ends.
     *
     * Processing ends when every request in a Message Batch has either succeeded, errored, canceled, or expired.
     */
    public function withEndedAt(?\DateTimeInterface $endedAt): self
    {
        $obj = clone $this;
        $obj['endedAt'] = $endedAt;

        return $obj;
    }

    /**
     * RFC 3339 datetime string representing the time at which the Message Batch will expire and end processing, which is 24 hours after creation.
     */
    public function withExpiresAt(\DateTimeInterface $expiresAt): self
    {
        $obj = clone $this;
        $obj['expiresAt'] = $expiresAt;

        return $obj;
    }

    /**
     * Processing status of the Message Batch.
     *
     * @param ProcessingStatus|value-of<ProcessingStatus> $processingStatus
     */
    public function withProcessingStatus(
        ProcessingStatus|string $processingStatus
    ): self {
        $obj = clone $this;
        $obj['processingStatus'] = $processingStatus;

        return $obj;
    }

    /**
     * Tallies requests within the Message Batch, categorized by their status.
     *
     * Requests start as `processing` and move to one of the other statuses only once processing of the entire batch ends. The sum of all values always matches the total number of requests in the batch.
     *
     * @param MessageBatchRequestCounts|array{
     *   canceled: int, errored: int, expired: int, processing: int, succeeded: int
     * } $requestCounts
     */
    public function withRequestCounts(
        MessageBatchRequestCounts|array $requestCounts
    ): self {
        $obj = clone $this;
        $obj['requestCounts'] = $requestCounts;

        return $obj;
    }

    /**
     * URL to a `.jsonl` file containing the results of the Message Batch requests. Specified only once processing ends.
     *
     * Results in the file are not guaranteed to be in the same order as requests. Use the `custom_id` field to match results to requests.
     */
    public function withResultsURL(?string $resultsURL): self
    {
        $obj = clone $this;
        $obj['resultsURL'] = $resultsURL;

        return $obj;
    }
}
