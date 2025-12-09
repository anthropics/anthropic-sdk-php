<?php

declare(strict_types=1);

namespace Anthropic;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type ErrorResponseShape = array{
 *   error: InvalidRequestError|AuthenticationError|BillingError|PermissionError|NotFoundError|RateLimitError|GatewayTimeoutError|APIErrorObject|OverloadedError,
 *   requestID: string|null,
 *   type?: 'error',
 * }
 */
final class ErrorResponse implements BaseModel
{
    /** @use SdkModel<ErrorResponseShape> */
    use SdkModel;

    /** @var 'error' $type */
    #[Required]
    public string $type = 'error';

    #[Required(union: ErrorObject::class)]
    public InvalidRequestError|AuthenticationError|BillingError|PermissionError|NotFoundError|RateLimitError|GatewayTimeoutError|APIErrorObject|OverloadedError $error;

    #[Required('request_id')]
    public ?string $requestID;

    /**
     * `new ErrorResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * ErrorResponse::with(error: ..., requestID: ...)
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
     *
     * @param InvalidRequestError|array{
     *   message: string, type?: 'invalid_request_error'
     * }|AuthenticationError|array{
     *   message: string, type?: 'authentication_error'
     * }|BillingError|array{
     *   message: string, type?: 'billing_error'
     * }|PermissionError|array{
     *   message: string, type?: 'permission_error'
     * }|NotFoundError|array{
     *   message: string, type?: 'not_found_error'
     * }|RateLimitError|array{
     *   message: string, type?: 'rate_limit_error'
     * }|GatewayTimeoutError|array{
     *   message: string, type?: 'timeout_error'
     * }|APIErrorObject|array{
     *   message: string, type?: 'api_error'
     * }|OverloadedError|array{message: string, type?: 'overloaded_error'} $error
     */
    public static function with(
        InvalidRequestError|array|AuthenticationError|BillingError|PermissionError|NotFoundError|RateLimitError|GatewayTimeoutError|APIErrorObject|OverloadedError $error,
        ?string $requestID,
    ): self {
        $obj = new self;

        $obj['error'] = $error;
        $obj['requestID'] = $requestID;

        return $obj;
    }

    /**
     * @param InvalidRequestError|array{
     *   message: string, type?: 'invalid_request_error'
     * }|AuthenticationError|array{
     *   message: string, type?: 'authentication_error'
     * }|BillingError|array{
     *   message: string, type?: 'billing_error'
     * }|PermissionError|array{
     *   message: string, type?: 'permission_error'
     * }|NotFoundError|array{
     *   message: string, type?: 'not_found_error'
     * }|RateLimitError|array{
     *   message: string, type?: 'rate_limit_error'
     * }|GatewayTimeoutError|array{
     *   message: string, type?: 'timeout_error'
     * }|APIErrorObject|array{
     *   message: string, type?: 'api_error'
     * }|OverloadedError|array{message: string, type?: 'overloaded_error'} $error
     */
    public function withError(
        InvalidRequestError|array|AuthenticationError|BillingError|PermissionError|NotFoundError|RateLimitError|GatewayTimeoutError|APIErrorObject|OverloadedError $error,
    ): self {
        $obj = clone $this;
        $obj['error'] = $error;

        return $obj;
    }

    public function withRequestID(?string $requestID): self
    {
        $obj = clone $this;
        $obj['requestID'] = $requestID;

        return $obj;
    }
}
