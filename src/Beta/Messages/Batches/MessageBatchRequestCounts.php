<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\Batches;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type MessageBatchRequestCountsShape = array{
 *   canceled: int, errored: int, expired: int, processing: int, succeeded: int
 * }
 */
final class MessageBatchRequestCounts implements BaseModel
{
    /** @use SdkModel<MessageBatchRequestCountsShape> */
    use SdkModel;

    /**
     * Number of requests in the Message Batch that have been canceled.
     *
     * This is zero until processing of the entire Message Batch has ended.
     */
    #[Required]
    public int $canceled;

    /**
     * Number of requests in the Message Batch that encountered an error.
     *
     * This is zero until processing of the entire Message Batch has ended.
     */
    #[Required]
    public int $errored;

    /**
     * Number of requests in the Message Batch that have expired.
     *
     * This is zero until processing of the entire Message Batch has ended.
     */
    #[Required]
    public int $expired;

    /**
     * Number of requests in the Message Batch that are processing.
     */
    #[Required]
    public int $processing;

    /**
     * Number of requests in the Message Batch that have completed successfully.
     *
     * This is zero until processing of the entire Message Batch has ended.
     */
    #[Required]
    public int $succeeded;

    /**
     * `new MessageBatchRequestCounts()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * MessageBatchRequestCounts::with(
     *   canceled: ..., errored: ..., expired: ..., processing: ..., succeeded: ...
     * )
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new MessageBatchRequestCounts)
     *   ->withCanceled(...)
     *   ->withErrored(...)
     *   ->withExpired(...)
     *   ->withProcessing(...)
     *   ->withSucceeded(...)
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
     */
    public static function with(
        int $canceled = 0,
        int $errored = 0,
        int $expired = 0,
        int $processing = 0,
        int $succeeded = 0,
    ): self {
        $self = new self;

        $self['canceled'] = $canceled;
        $self['errored'] = $errored;
        $self['expired'] = $expired;
        $self['processing'] = $processing;
        $self['succeeded'] = $succeeded;

        return $self;
    }

    /**
     * Number of requests in the Message Batch that have been canceled.
     *
     * This is zero until processing of the entire Message Batch has ended.
     */
    public function withCanceled(int $canceled): self
    {
        $self = clone $this;
        $self['canceled'] = $canceled;

        return $self;
    }

    /**
     * Number of requests in the Message Batch that encountered an error.
     *
     * This is zero until processing of the entire Message Batch has ended.
     */
    public function withErrored(int $errored): self
    {
        $self = clone $this;
        $self['errored'] = $errored;

        return $self;
    }

    /**
     * Number of requests in the Message Batch that have expired.
     *
     * This is zero until processing of the entire Message Batch has ended.
     */
    public function withExpired(int $expired): self
    {
        $self = clone $this;
        $self['expired'] = $expired;

        return $self;
    }

    /**
     * Number of requests in the Message Batch that are processing.
     */
    public function withProcessing(int $processing): self
    {
        $self = clone $this;
        $self['processing'] = $processing;

        return $self;
    }

    /**
     * Number of requests in the Message Batch that have completed successfully.
     *
     * This is zero until processing of the entire Message Batch has ended.
     */
    public function withSucceeded(int $succeeded): self
    {
        $self = clone $this;
        $self['succeeded'] = $succeeded;

        return $self;
    }
}
