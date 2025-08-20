<?php

declare(strict_types=1);

namespace Anthropic\Shared;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type error_response_alias = array{
 *   error: InvalidRequestError|AuthenticationError|BillingError|PermissionError|NotFoundError|RateLimitError|GatewayTimeoutError|APIErrorObject|OverloadedError,
 *   type: string,
 * }
 */
final class ErrorResponse implements BaseModel
{
    use SdkModel;

    #[Api]
    public string $type = 'error';

    #[Api(union: ErrorObject::class)]
    public InvalidRequestError|AuthenticationError|BillingError|PermissionError|NotFoundError|RateLimitError|GatewayTimeoutError|APIErrorObject|OverloadedError $error;

    /**
     * `new ErrorResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ErrorResponse::with(error: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ErrorResponse)->withError(...)
     * ```
     */
    public function __construct()
    {
        self::introspect();
        $this->unsetOptionalProperties();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(
        InvalidRequestError|AuthenticationError|BillingError|PermissionError|NotFoundError|RateLimitError|GatewayTimeoutError|APIErrorObject|OverloadedError $error,
    ): self {
        $obj = new self;

        $obj->error = $error;

        return $obj;
    }

    public function withError(
        InvalidRequestError|AuthenticationError|BillingError|PermissionError|NotFoundError|RateLimitError|GatewayTimeoutError|APIErrorObject|OverloadedError $error,
    ): self {
        $obj = clone $this;
        $obj->error = $error;

        return $obj;
    }
}
