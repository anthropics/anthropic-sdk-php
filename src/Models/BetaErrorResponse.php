<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Attributes\Api;
use Anthropic\Core\Concerns\Model;
use Anthropic\Core\Contracts\BaseModel;

class BetaErrorResponse implements BaseModel
{
    use Model;

    /**
     * @var BetaAPIError|BetaAuthenticationError|BetaBillingError|BetaGatewayTimeoutError|BetaInvalidRequestError|BetaNotFoundError|BetaOverloadedError|BetaPermissionError|BetaRateLimitError $error
     */
    #[Api]
    public mixed $error;

    #[Api]
    public string $type;

    /**
     * @param BetaAPIError|BetaAuthenticationError|BetaBillingError|BetaGatewayTimeoutError|BetaInvalidRequestError|BetaNotFoundError|BetaOverloadedError|BetaPermissionError|BetaRateLimitError $error
     * @param string                                                                                                                                                                             $type
     */
    final public function __construct($error, $type)
    {
        $this->constructFromArgs(func_get_args());
    }
}

BetaErrorResponse::_loadMetadata();
