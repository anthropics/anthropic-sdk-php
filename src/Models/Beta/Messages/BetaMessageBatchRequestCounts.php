<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

class BetaMessageBatchRequestCounts implements BaseModel
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
        $canceled,
        $errored,
        $expired,
        $processing,
        $succeeded
    ) {
        $this->constructFromArgs(func_get_args());
    }
}

BetaMessageBatchRequestCounts::_loadMetadata();
