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

    #[Api]
    public int $canceled;

    #[Api]
    public int $errored;

    #[Api]
    public int $expired;

    #[Api]
    public int $processing;

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
