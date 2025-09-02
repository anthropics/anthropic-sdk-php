<?php

declare(strict_types=1);

namespace Anthropic\Beta;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type beta_error_response = array{
 *   error: BetaInvalidRequestError|BetaAuthenticationError|BetaBillingError|BetaPermissionError|BetaNotFoundError|BetaRateLimitError|BetaGatewayTimeoutError|BetaAPIError|BetaOverloadedError,
 *   requestID: string|null,
 *   type: string,
 * }
 */
final class BetaErrorResponse implements BaseModel
{
    /** @use SdkModel<beta_error_response> */
    use SdkModel;

    #[Api]
    public string $type = 'error';

    #[Api(union: BetaError::class)]
    public BetaInvalidRequestError|BetaAuthenticationError|BetaBillingError|BetaPermissionError|BetaNotFoundError|BetaRateLimitError|BetaGatewayTimeoutError|BetaAPIError|BetaOverloadedError $error;

    #[Api('request_id')]
    public ?string $requestID;

    /**
     * `new BetaErrorResponse()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * BetaErrorResponse::with(error: ..., requestID: ...)
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
     */
    public static function with(
        BetaInvalidRequestError|BetaAuthenticationError|BetaBillingError|BetaPermissionError|BetaNotFoundError|BetaRateLimitError|BetaGatewayTimeoutError|BetaAPIError|BetaOverloadedError $error,
        ?string $requestID,
    ): self {
        $obj = new self;

        $obj->error = $error;
        $obj->requestID = $requestID;

        return $obj;
    }

    public function withError(
        BetaInvalidRequestError|BetaAuthenticationError|BetaBillingError|BetaPermissionError|BetaNotFoundError|BetaRateLimitError|BetaGatewayTimeoutError|BetaAPIError|BetaOverloadedError $error,
    ): self {
        $obj = clone $this;
        $obj->error = $error;

        return $obj;
    }

    public function withRequestID(?string $requestID): self
    {
        $obj = clone $this;
        $obj->requestID = $requestID;

        return $obj;
    }
}
