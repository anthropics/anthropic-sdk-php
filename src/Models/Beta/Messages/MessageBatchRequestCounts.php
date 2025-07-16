<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

final class MessageBatchRequestCounts implements BaseModel
{
    use Model;

    #[Api]
    public int $canceled = 0;

    #[Api]
    public int $errored = 0;

    #[Api]
    public int $expired = 0;

    #[Api]
    public int $processing = 0;

    #[Api]
    public int $succeeded = 0;

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
        $this->canceled = $canceled;
        $this->errored = $errored;
        $this->expired = $expired;
        $this->processing = $processing;
        $this->succeeded = $succeeded;
    }
}

MessageBatchRequestCounts::__introspect();
