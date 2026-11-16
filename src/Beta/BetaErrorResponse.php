<?php

declare(strict_types=1);

namespace Anthropic\Beta;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * @phpstan-import-type BetaErrorObjectShape from \Anthropic\Beta\BetaErrorObject
 * @phpstan-import-type BetaErrorObjectVariants from \Anthropic\Beta\BetaErrorObject
 *
 * @phpstan-type BetaErrorResponseShape = array{
 *   error: BetaErrorObjectShape, requestID: string|null, type: 'error'
 * }
 */
final class BetaErrorResponse implements BaseModel
{
    /** @use SdkModel<BetaErrorResponseShape> */
    use SdkModel;

    /** @var 'error' $type */
    #[Required(type: new ConstantOf('error'))]
    public string $type = 'error';

    /** @var BetaErrorObjectVariants $error */
    #[Required(union: BetaErrorObject::class)]
    public BetaInvalidRequestErrorObject|BetaAuthenticationErrorObject|BetaBillingErrorObject|BetaPermissionErrorObject|BetaNotFoundErrorObject|BetaRateLimitErrorObject|BetaGatewayTimeoutErrorObject|BetaAPIErrorObject|BetaOverloadedErrorObject $error;

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
     * (new BetaErrorResponse())->withError(...)->withRequestID(...)
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
     * @param BetaErrorObjectShape $error
     */
    public static function with(
        BetaInvalidRequestErrorObject|array|BetaAuthenticationErrorObject|BetaBillingErrorObject|BetaPermissionErrorObject|BetaNotFoundErrorObject|BetaRateLimitErrorObject|BetaGatewayTimeoutErrorObject|BetaAPIErrorObject|BetaOverloadedErrorObject $error,
        ?string $requestID,
    ): self {
        $self = new self;

        $self['error'] = $error;
        $self['requestID'] = $requestID;

        return $self;
    }

    /**
     * @param BetaErrorObjectShape $error
     */
    public function withError(
        BetaInvalidRequestErrorObject|array|BetaAuthenticationErrorObject|BetaBillingErrorObject|BetaPermissionErrorObject|BetaNotFoundErrorObject|BetaRateLimitErrorObject|BetaGatewayTimeoutErrorObject|BetaAPIErrorObject|BetaOverloadedErrorObject $error,
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

    /**
     * @param 'error' $type
     */
    public function withType(string $type): self
    {
        $self = clone $this;
        $self['type'] = $type;

        return $self;
    }
}
