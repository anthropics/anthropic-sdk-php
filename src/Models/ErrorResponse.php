<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

class ErrorResponse implements BaseModel
{
    use Model;

    /**
     * @var APIErrorObject|AuthenticationError|BillingError|GatewayTimeoutError|InvalidRequestError|NotFoundError|OverloadedError|PermissionError|RateLimitError $error
     */
    #[Api]
    public mixed $error;

    #[Api]
    public string $type;

    /**
     * @param APIErrorObject|AuthenticationError|BillingError|GatewayTimeoutError|InvalidRequestError|NotFoundError|OverloadedError|PermissionError|RateLimitError $error
     * @param string                                                                                                                                               $type
     */
    final public function __construct($error, $type)
    {
        $this->constructFromArgs(func_get_args());
    }
}

ErrorResponse::_loadMetadata();
