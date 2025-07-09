<?php

declare(strict_types=1);

namespace Anthropic\Models\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

class MessageBatchRequestCounts implements BaseModel
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
     * @param int $canceled
     * @param int $errored
     * @param int $expired
     * @param int $processing
     * @param int $succeeded
     */
    final public function __construct(
        $canceled,
        $errored,
        $expired,
        $processing,
        $succeeded
    ) {
        $this->constructFromArgs(func_get_args());
    }
}

MessageBatchRequestCounts::_loadMetadata();
