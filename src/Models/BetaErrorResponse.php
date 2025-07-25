<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model as ModelTrait;
use Anthropic\Core\Contracts\BaseModel;

/**
 * @phpstan-type beta_error_response_alias = array{
 *   error: BetaInvalidRequestError|BetaAuthenticationError|BetaBillingError|BetaPermissionError|BetaNotFoundError|BetaRateLimitError|BetaGatewayTimeoutError|BetaAPIError|BetaOverloadedError,
 *   type: string,
 * }
 */
final class BetaErrorResponse implements BaseModel
{
    use ModelTrait;

    #[Api]
    public string $type = 'error';

    #[Api(union: BetaError::class)]
    public BetaAPIError|BetaAuthenticationError|BetaBillingError|BetaGatewayTimeoutError|BetaInvalidRequestError|BetaNotFoundError|BetaOverloadedError|BetaPermissionError|BetaRateLimitError $error;

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
        BetaAPIError|BetaAuthenticationError|BetaBillingError|BetaGatewayTimeoutError|BetaInvalidRequestError|BetaNotFoundError|BetaOverloadedError|BetaPermissionError|BetaRateLimitError $error,
    ): self {
        $obj = new self;

        $obj->error = $error;

        return $obj;
    }

    public function setError(
        BetaAPIError|BetaAuthenticationError|BetaBillingError|BetaGatewayTimeoutError|BetaInvalidRequestError|BetaNotFoundError|BetaOverloadedError|BetaPermissionError|BetaRateLimitError $error,
    ): self {
        $this->error = $error;

        return $this;
    }
}
