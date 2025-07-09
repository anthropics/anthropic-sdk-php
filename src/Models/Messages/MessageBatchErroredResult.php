<?php

declare(strict_types=1);

namespace Anthropic\Models\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Models\ErrorResponse;

class MessageBatchErroredResult implements BaseModel
{
    use Model;

    #[Api]
    public ErrorResponse $error;

    #[Api]
    public string $type;

    /**
     * @param ErrorResponse $error
     * @param string        $type
     */
    final public function __construct($error, $type)
    {
        $this->constructFromArgs(func_get_args());
    }
}

MessageBatchErroredResult::_loadMetadata();
