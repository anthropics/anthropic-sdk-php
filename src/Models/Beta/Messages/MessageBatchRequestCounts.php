<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type message_batch_request_counts_alias = array{
 *   canceled: int, errored: int, expired: int, processing: int, succeeded: int
 * }
 */
final class MessageBatchRequestCounts implements BaseModel
{
    use Model;

    /**
     * Number of requests in the Message Batch that have been canceled.
     *
     * This is zero until processing of the entire Message Batch has ended.
     */
    #[Api]
    public int $canceled;

    /**
     * Number of requests in the Message Batch that encountered an error.
     *
     * This is zero until processing of the entire Message Batch has ended.
     */
    #[Api]
    public int $errored;

    /**
     * Number of requests in the Message Batch that have expired.
     *
     * This is zero until processing of the entire Message Batch has ended.
     */
    #[Api]
    public int $expired;

    /**
     * Number of requests in the Message Batch that are processing.
     */
    #[Api]
    public int $processing;

    /**
     * Number of requests in the Message Batch that have completed successfully.
     *
     * This is zero until processing of the entire Message Batch has ended.
     */
    #[Api]
    public int $succeeded;

    public function __construct()
    {
        self::introspect();
        $this->unsetOptionalProperties();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function new(
        int $canceled = 0,
        int $errored = 0,
        int $expired = 0,
        int $processing = 0,
        int $succeeded = 0,
    ): self {
        $obj = new self;

        $obj->canceled = $canceled;
        $obj->errored = $errored;
        $obj->expired = $expired;
        $obj->processing = $processing;
        $obj->succeeded = $succeeded;

        return $obj;
    }

    /**
     * Number of requests in the Message Batch that have been canceled.
     *
     * This is zero until processing of the entire Message Batch has ended.
     */
    public function setCanceled(int $canceled): self
    {
        $this->canceled = $canceled;

        return $this;
    }

    /**
     * Number of requests in the Message Batch that encountered an error.
     *
     * This is zero until processing of the entire Message Batch has ended.
     */
    public function setErrored(int $errored): self
    {
        $this->errored = $errored;

        return $this;
    }

    /**
     * Number of requests in the Message Batch that have expired.
     *
     * This is zero until processing of the entire Message Batch has ended.
     */
    public function setExpired(int $expired): self
    {
        $this->expired = $expired;

        return $this;
    }

    /**
     * Number of requests in the Message Batch that are processing.
     */
    public function setProcessing(int $processing): self
    {
        $this->processing = $processing;

        return $this;
    }

    /**
     * Number of requests in the Message Batch that have completed successfully.
     *
     * This is zero until processing of the entire Message Batch has ended.
     */
    public function setSucceeded(int $succeeded): self
    {
        $this->succeeded = $succeeded;

        return $this;
    }
}
