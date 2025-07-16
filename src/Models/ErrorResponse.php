<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

final class ErrorResponse implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'error';

    #[Api]
    public APIErrorObject|AuthenticationError|BillingError|GatewayTimeoutError|InvalidRequestError|NotFoundError|OverloadedError|PermissionError|RateLimitError $error;

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(
        APIErrorObject|AuthenticationError|BillingError|GatewayTimeoutError|InvalidRequestError|NotFoundError|OverloadedError|PermissionError|RateLimitError $error,
    ) {
        $this->error = $error;
    }
}

ErrorResponse::__introspect();
