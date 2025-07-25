<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model as ModelTrait;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type error_response_alias = array{
 *   error: InvalidRequestError|AuthenticationError|BillingError|PermissionError|NotFoundError|RateLimitError|GatewayTimeoutError|APIErrorObject|OverloadedError,
 *   type: string,
 * }
 */
final class ErrorResponse implements BaseModel
{
    use ModelTrait;

    #[Api]
    public string $type = 'error';

    #[Api(union: ErrorObject::class)]
    public APIErrorObject|AuthenticationError|BillingError|GatewayTimeoutError|InvalidRequestError|NotFoundError|OverloadedError|PermissionError|RateLimitError $error;

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
    public static function new(
        APIErrorObject|AuthenticationError|BillingError|GatewayTimeoutError|InvalidRequestError|NotFoundError|OverloadedError|PermissionError|RateLimitError $error,
    ): self {
        $obj = new self;

        $obj->error = $error;

        return $obj;
    }

    public function setError(
        APIErrorObject|AuthenticationError|BillingError|GatewayTimeoutError|InvalidRequestError|NotFoundError|OverloadedError|PermissionError|RateLimitError $error,
    ): self {
        $this->error = $error;

        return $this;
    }
}
