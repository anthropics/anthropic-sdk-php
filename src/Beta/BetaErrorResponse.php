<?php

declare(strict_types=1);

namespace Anthropic\Beta;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-import-type BetaErrorShape from \Anthropic\Beta\BetaError
 *
 * @phpstan-type BetaErrorResponseShape = array{
 *   error: BetaInvalidRequestError|BetaAuthenticationError|BetaBillingError|BetaPermissionError|BetaNotFoundError|BetaRateLimitError|BetaGatewayTimeoutError|BetaAPIError|BetaOverloadedError|BetaErrorShape,
 *   requestID: string|null,
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

    #[Required('request_id')]
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
     *
     * @param BetaErrorShape $error
     */
    public static function with(
        BetaInvalidRequestError|array|BetaAuthenticationError|BetaBillingError|BetaPermissionError|BetaNotFoundError|BetaRateLimitError|BetaGatewayTimeoutError|BetaAPIError|BetaOverloadedError $error,
        ?string $requestID,
    ): self {
        $self = new self;

        $self['error'] = $error;
        $self['requestID'] = $requestID;

        return $self;
    }

    /**
     * @param BetaErrorShape $error
     */
    public function withError(
        BetaInvalidRequestError|array|BetaAuthenticationError|BetaBillingError|BetaPermissionError|BetaNotFoundError|BetaRateLimitError|BetaGatewayTimeoutError|BetaAPIError|BetaOverloadedError $error,
    ): self {
        $self = clone $this;
        $self['error'] = $error;

        return $self;
    }

    public function withRequestID(?string $requestID): self
    {
        $self = clone $this;
        $self['requestID'] = $requestID;

        return $self;
    }
}
