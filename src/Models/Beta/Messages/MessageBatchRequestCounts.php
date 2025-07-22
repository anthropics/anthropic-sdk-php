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

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(
        int $canceled = 0,
        int $errored = 0,
        int $expired = 0,
        int $processing = 0,
        int $succeeded = 0,
    ) {
        self::introspect();

        $this->canceled = $canceled;
        $this->errored = $errored;
        $this->expired = $expired;
        $this->processing = $processing;
        $this->succeeded = $succeeded;
    }
}
