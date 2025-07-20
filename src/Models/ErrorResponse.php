<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type error_response_alias = array{
 *   error: InvalidRequestError|AuthenticationError|BillingError|PermissionError|NotFoundError|RateLimitError|GatewayTimeoutError|APIErrorObject|OverloadedError,
 *   type: string,
 * }
 */
final class ErrorResponse implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'error';

    #[Api(union: ErrorObject::class)]
    public APIErrorObject|AuthenticationError|BillingError|GatewayTimeoutError|InvalidRequestError|NotFoundError|OverloadedError|PermissionError|RateLimitError $error;

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(
        APIErrorObject|AuthenticationError|BillingError|GatewayTimeoutError|InvalidRequestError|NotFoundError|OverloadedError|PermissionError|RateLimitError $error,
    ) {
        self::introspect();

        $this->error = $error;
    }
}
