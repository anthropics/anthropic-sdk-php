<?php

declare(strict_types=1);

namespace Anthropic;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type ErrorResponseShape = array{
 *   error: InvalidRequestError|AuthenticationError|BillingError|PermissionError|NotFoundError|RateLimitError|GatewayTimeoutError|APIErrorObject|OverloadedError,
 *   request_id: string|null,
 *   type: 'error',
 * }
 */
final class ErrorResponse implements BaseModel
{
    /** @use SdkModel<ErrorResponseShape> */
    use SdkModel;

    /** @var 'error' $type */
    #[Api]
    public string $type = 'error';

    #[Api(union: ErrorObject::class)]
    public InvalidRequestError|AuthenticationError|BillingError|PermissionError|NotFoundError|RateLimitError|GatewayTimeoutError|APIErrorObject|OverloadedError $error;

    #[Api]
    public ?string $request_id;

    /**
     * `new ErrorResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ErrorResponse::with(error: ..., request_id: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new ErrorResponse)->withError(...)->withRequestID(...)
     * ```
     */
    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     */
    public static function with(
        InvalidRequestError|AuthenticationError|BillingError|PermissionError|NotFoundError|RateLimitError|GatewayTimeoutError|APIErrorObject|OverloadedError $error,
        ?string $request_id,
    ): self {
        $obj = new self;

        $obj->error = $error;
        $obj->request_id = $request_id;

        return $obj;
    }

    public function withError(
        InvalidRequestError|AuthenticationError|BillingError|PermissionError|NotFoundError|RateLimitError|GatewayTimeoutError|APIErrorObject|OverloadedError $error,
    ): self {
        $obj = clone $this;
        $obj->error = $error;

        return $obj;
    }

    public function withRequestID(?string $requestID): self
    {
        $obj = clone $this;
        $obj->request_id = $requestID;

        return $obj;
    }
}
