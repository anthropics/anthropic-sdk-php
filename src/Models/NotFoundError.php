<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

class NotFoundError implements BaseModel
{
    use Model;

    #[Api]
    public string $message;

    #[Api]
    public string $type;

    /**
     * You must use named parameters to construct this object. If an named argument is not
     * given, it will not be included during JSON serialization. The arguments are untyped
     * so you can pass any JSON serializable value, but the API expects the types to match
     * the PHPDoc types.
     *
     * @param string $message `required`
     * @param string $type    `required`
     */
    final public function __construct($message, $type)
    {
        $this->constructFromArgs(func_get_args());
    }
}

NotFoundError::_loadMetadata();
