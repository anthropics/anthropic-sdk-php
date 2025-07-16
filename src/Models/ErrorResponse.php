<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Models\ErrorResponse\Type;

final class ErrorResponse implements BaseModel
{
    use Model;

    #[Api]
    public APIErrorObject|AuthenticationError|BillingError|GatewayTimeoutError|InvalidRequestError|NotFoundError|OverloadedError|PermissionError|RateLimitError $error;

    /** @var Type::* $type */
    #[Api]
    public string $type = 'error';

    /**
     * You must use named parameters to construct this object.
     *
     * @param Type::* $type
     */
    final public function __construct(
        APIErrorObject|AuthenticationError|BillingError|GatewayTimeoutError|InvalidRequestError|NotFoundError|OverloadedError|PermissionError|RateLimitError $error,
        string $type = 'error',
    ) {
        $this->error = $error;
        $this->type = $type;
    }
}

ErrorResponse::_loadMetadata();
