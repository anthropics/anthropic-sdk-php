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
 *   archived_at: \DateTimeInterface|null,
 *   cancel_initiated_at: \DateTimeInterface|null,
 *   created_at: \DateTimeInterface,
 *   ended_at: \DateTimeInterface|null,
 *   expires_at: \DateTimeInterface,
 *   processing_status: value-of<ProcessingStatus>,
 *   request_counts: MessageBatchRequestCounts,
 *   results_url: string|null,
 *   type: 'message_batch',
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
    #[Required]
    public ?\DateTimeInterface $archived_at;

    /**
     * RFC 3339 datetime string representing the time at which cancellation was initiated for the Message Batch. Specified only if cancellation was initiated.
     */
    #[Required]
    public ?\DateTimeInterface $cancel_initiated_at;

    /**
     * RFC 3339 datetime string representing the time at which the Message Batch was created.
     */
    #[Required]
    public \DateTimeInterface $created_at;

    /**
     * RFC 3339 datetime string representing the time at which processing for the Message Batch ended. Specified only once processing ends.
     *
     * Processing ends when every request in a Message Batch has either succeeded, errored, canceled, or expired.
     */
    #[Required]
    public ?\DateTimeInterface $ended_at;

    /**
     * RFC 3339 datetime string representing the time at which the Message Batch will expire and end processing, which is 24 hours after creation.
     */
    #[Required]
    public \DateTimeInterface $expires_at;

    /**
     * Processing status of the Message Batch.
     *
     * @var value-of<ProcessingStatus> $processing_status
     */
    #[Required(enum: ProcessingStatus::class)]
    public string $processing_status;

    /**
     * Tallies requests within the Message Batch, categorized by their status.
     *
     * Requests start as `processing` and move to one of the other statuses only once processing of the entire batch ends. The sum of all values always matches the total number of requests in the batch.
     */
    #[Required]
    public MessageBatchRequestCounts $request_counts;

    /**
     * URL to a `.jsonl` file containing the results of the Message Batch requests. Specified only once processing ends.
     *
     * Results in the file are not guaranteed to be in the same order as requests. Use the `custom_id` field to match results to requests.
     */
    #[Required]
    public ?string $results_url;

    /**
     * `new MessageBatch()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * MessageBatch::with(
     *   id: ...,
     *   archived_at: ...,
     *   cancel_initiated_at: ...,
     *   created_at: ...,
     *   ended_at: ...,
     *   expires_at: ...,
     *   processing_status: ...,
     *   request_counts: ...,
     *   results_url: ...,
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
     * @param ProcessingStatus|value-of<ProcessingStatus> $processing_status
     * @param MessageBatchRequestCounts|array{
     *   canceled: int, errored: int, expired: int, processing: int, succeeded: int
     * } $request_counts
     */
    public static function with(
        string $id,
        ?\DateTimeInterface $archived_at,
        ?\DateTimeInterface $cancel_initiated_at,
        \DateTimeInterface $created_at,
        ?\DateTimeInterface $ended_at,
        \DateTimeInterface $expires_at,
        ProcessingStatus|string $processing_status,
        MessageBatchRequestCounts|array $request_counts,
        ?string $results_url,
    ): self {
        $obj = new self;

        $obj['id'] = $id;
        $obj['archived_at'] = $archived_at;
        $obj['cancel_initiated_at'] = $cancel_initiated_at;
        $obj['created_at'] = $created_at;
        $obj['ended_at'] = $ended_at;
        $obj['expires_at'] = $expires_at;
        $obj['processing_status'] = $processing_status;
        $obj['request_counts'] = $request_counts;
        $obj['results_url'] = $results_url;

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
        $obj['archived_at'] = $archivedAt;

        return $obj;
    }

    /**
     * RFC 3339 datetime string representing the time at which cancellation was initiated for the Message Batch. Specified only if cancellation was initiated.
     */
    public function withCancelInitiatedAt(
        ?\DateTimeInterface $cancelInitiatedAt
    ): self {
        $obj = clone $this;
        $obj['cancel_initiated_at'] = $cancelInitiatedAt;

        return $obj;
    }

    /**
     * RFC 3339 datetime string representing the time at which the Message Batch was created.
     */
    public function withCreatedAt(\DateTimeInterface $createdAt): self
    {
        $obj = clone $this;
        $obj['created_at'] = $createdAt;

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
        $obj['ended_at'] = $endedAt;

        return $obj;
    }

    /**
     * RFC 3339 datetime string representing the time at which the Message Batch will expire and end processing, which is 24 hours after creation.
     */
    public function withExpiresAt(\DateTimeInterface $expiresAt): self
    {
        $obj = clone $this;
        $obj['expires_at'] = $expiresAt;

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
        $obj['processing_status'] = $processingStatus;

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
        $obj['request_counts'] = $requestCounts;

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
        $obj['results_url'] = $resultsURL;

        return $obj;
    }
}
