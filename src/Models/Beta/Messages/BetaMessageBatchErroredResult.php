<?php

declare(strict_types=1);

namespace Anthropic\Models\Beta\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Models\BetaErrorResponse;

class BetaMessageBatchErroredResult implements BaseModel
{
    use Model;

    #[Api]
    public BetaErrorResponse $error;

    #[Api]
    public string $type;

    /**
     * @param BetaErrorResponse $error
     * @param string            $type
     */
    final public function __construct($error, $type)
    {
        $this->constructFromArgs(func_get_args());
    }
}

BetaMessageBatchErroredResult::_loadMetadata();
