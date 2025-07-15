<?php

declare(strict_types=1);

namespace Anthropic\Models\Messages;

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
     * You must use named parameters to construct this object. If an named argument is not
     * given, it will not be included during JSON serialization. The arguments are untyped
     * so you can pass any JSON serializable value, but the API expects the types to match
     * the PHPDoc types.
     *
     * @param int $canceled   `required`
     * @param int $errored    `required`
     * @param int $expired    `required`
     * @param int $processing `required`
     * @param int $succeeded  `required`
     */
    final public function __construct(
        $canceled = 0,
        $errored = 0,
        $expired = 0,
        $processing = 0,
        $succeeded = 0
    ) {
        $this->constructFromArgs(func_get_args());
    }
}

MessageBatchRequestCounts::_loadMetadata();
