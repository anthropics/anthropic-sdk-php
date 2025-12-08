<?php

declare(strict_types=1);

namespace Anthropic\Beta;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type BetaErrorResponseShape = array{
 *   error: BetaInvalidRequestError|BetaAuthenticationError|BetaBillingError|BetaPermissionError|BetaNotFoundError|BetaRateLimitError|BetaGatewayTimeoutError|BetaAPIError|BetaOverloadedError,
 *   request_id: string|null,
 *   type: 'error',
 * }
 */
final class BetaErrorResponse implements BaseModel
{
    /** @use SdkModel<BetaErrorResponseShape> */
    use SdkModel;

    /** @var 'error' $type */
    #[Required]
    public string $type = 'error';

    #[Required(union: BetaError::class)]
    public BetaInvalidRequestError|BetaAuthenticationError|BetaBillingError|BetaPermissionError|BetaNotFoundError|BetaRateLimitError|BetaGatewayTimeoutError|BetaAPIError|BetaOverloadedError $error;

    #[Required]
    public ?string $request_id;

    /**
     * `new BetaErrorResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaErrorResponse::with(error: ..., request_id: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new BetaErrorResponse)->withError(...)->withRequestID(...)
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
     * @param BetaInvalidRequestError|array{
     *   message: string, type: 'invalid_request_error'
     * }|BetaAuthenticationError|array{
     *   message: string, type: 'authentication_error'
     * }|BetaBillingError|array{
     *   message: string, type: 'billing_error'
     * }|BetaPermissionError|array{
     *   message: string, type: 'permission_error'
     * }|BetaNotFoundError|array{
     *   message: string, type: 'not_found_error'
     * }|BetaRateLimitError|array{
     *   message: string, type: 'rate_limit_error'
     * }|BetaGatewayTimeoutError|array{
     *   message: string, type: 'timeout_error'
     * }|BetaAPIError|array{
     *   message: string, type: 'api_error'
     * }|BetaOverloadedError|array{message: string, type: 'overloaded_error'} $error
     */
    public static function with(
        BetaInvalidRequestError|array|BetaAuthenticationError|BetaBillingError|BetaPermissionError|BetaNotFoundError|BetaRateLimitError|BetaGatewayTimeoutError|BetaAPIError|BetaOverloadedError $error,
        ?string $request_id,
    ): self {
        $obj = new self;

        $obj['error'] = $error;
        $obj['request_id'] = $request_id;

        return $obj;
    }

    /**
     * @param BetaInvalidRequestError|array{
     *   message: string, type: 'invalid_request_error'
     * }|BetaAuthenticationError|array{
     *   message: string, type: 'authentication_error'
     * }|BetaBillingError|array{
     *   message: string, type: 'billing_error'
     * }|BetaPermissionError|array{
     *   message: string, type: 'permission_error'
     * }|BetaNotFoundError|array{
     *   message: string, type: 'not_found_error'
     * }|BetaRateLimitError|array{
     *   message: string, type: 'rate_limit_error'
     * }|BetaGatewayTimeoutError|array{
     *   message: string, type: 'timeout_error'
     * }|BetaAPIError|array{
     *   message: string, type: 'api_error'
     * }|BetaOverloadedError|array{message: string, type: 'overloaded_error'} $error
     */
    public function withError(
        BetaInvalidRequestError|array|BetaAuthenticationError|BetaBillingError|BetaPermissionError|BetaNotFoundError|BetaRateLimitError|BetaGatewayTimeoutError|BetaAPIError|BetaOverloadedError $error,
    ): self {
        $obj = clone $this;
        $obj['error'] = $error;

        return $obj;
    }

    public function withRequestID(?string $requestID): self
    {
        $obj = clone $this;
        $obj['request_id'] = $requestID;

        return $obj;
    }
}
