<?php

declare(strict_types=1);

namespace Anthropic\Models\Messages;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Models\ErrorResponse;

final class MessageBatchErroredResult implements BaseModel
{
    use Model;

    #[Api]
    public ErrorResponse $error;

    #[Api]
    public string $type = 'errored';

    /**
     * You must use named parameters to construct this object. If an named argument is not
     * given, it will not be included during JSON serialization. The arguments are untyped
     * so you can pass any JSON serializable value, but the API expects the types to match
     * the PHPDoc types.
     *
     * @param ErrorResponse $error `required`
     * @param string        $type  `required`
     */
    final public function __construct($error, $type = 'errored')
    {
        $this->constructFromArgs(func_get_args());
    }
}

MessageBatchErroredResult::_loadMetadata();
