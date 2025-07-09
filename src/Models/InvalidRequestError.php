<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

class InvalidRequestError implements BaseModel
{
    use Model;

    #[Api]
    public string $message;

    #[Api]
    public string $type;

    /**
     * @param string $message
     * @param string $type
     */
    final public function __construct($message, $type)
    {
        $this->constructFromArgs(func_get_args());
    }
}

InvalidRequestError::_loadMetadata();
