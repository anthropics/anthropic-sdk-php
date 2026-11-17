<?php

declare(strict_types=1);

namespace Anthropic;

use Anthropic\Core\Attributes\Required;
use Anthropic\Core\Concerns\SdkModel;
use Anthropic\Core\Contracts\BaseModel;
use Anthropic\Core\Conversion\ConstantOf;

/**
 * @phpstan-import-type ErrorObjectShape from \Anthropic\ErrorObject
 * @phpstan-import-type ErrorObjectVariants from \Anthropic\ErrorObject
 *
 * @phpstan-type ErrorResponseShape = array{
 *   error: ErrorObjectShape, requestID: string|null, type: 'error'
 * }
 */
final class ErrorResponse implements BaseModel
{
    /** @use SdkModel<ErrorResponseShape> */
    use SdkModel;

    /** @var 'error' $type */
    #[Required(type: new ConstantOf('error'))]
    public string $type = 'error';

    /** @var ErrorObjectVariants $error */
    #[Required(union: ErrorObject::class)]
    public InvalidRequestErrorObject|AuthenticationErrorObject|BillingErrorObject|PermissionErrorObject|NotFoundErrorObject|RateLimitErrorObject|GatewayTimeoutErrorObject|APIErrorObject|OverloadedErrorObject $error;

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
     * (new ErrorResponse())->withError(...)->withRequestID(...)
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
     * @param ErrorObjectShape $error
     */
    public static function with(
        InvalidRequestErrorObject|array|AuthenticationErrorObject|BillingErrorObject|PermissionErrorObject|NotFoundErrorObject|RateLimitErrorObject|GatewayTimeoutErrorObject|APIErrorObject|OverloadedErrorObject $error,
        ?string $requestID,
    ): self {
        $self = new self;

        $self['error'] = $error;
        $self['requestID'] = $requestID;

        return $self;
    }

    /**
     * @param ErrorObjectShape $error
     */
    public function withError(
        InvalidRequestErrorObject|array|AuthenticationErrorObject|BillingErrorObject|PermissionErrorObject|NotFoundErrorObject|RateLimitErrorObject|GatewayTimeoutErrorObject|APIErrorObject|OverloadedErrorObject $error,
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
