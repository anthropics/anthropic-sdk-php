<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

final class BetaErrorResponse implements BaseModel
{
    use Model;

    #[Api]
    public string $type = 'error';

    #[Api(union: BetaError::class)]
    public BetaAPIError|BetaAuthenticationError|BetaBillingError|BetaGatewayTimeoutError|BetaInvalidRequestError|BetaNotFoundError|BetaOverloadedError|BetaPermissionError|BetaRateLimitError $error;

    /**
     * You must use named parameters to construct this object.
     */
    final public function __construct(
        BetaAPIError|BetaAuthenticationError|BetaBillingError|BetaGatewayTimeoutError|BetaInvalidRequestError|BetaNotFoundError|BetaOverloadedError|BetaPermissionError|BetaRateLimitError $error,
    ) {
        self::introspect();

        $this->error = $error;
    }
}
