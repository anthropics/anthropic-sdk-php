<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Concerns\Union;
use Anthropic\Core\Contracts\Converter;
use Anthropic\Core\Contracts\StaticConverter;

final class BetaError implements StaticConverter
{
    use Union;

    public static function discriminator(): string
    {
        return 'type';
    }

    /**
     * @return list<string|Converter|StaticConverter>|array<
     *   string, string|Converter|StaticConverter
     * >
     */
    public static function variants(): array
    {
        return [
            'invalid_request_error' => BetaInvalidRequestError::class,
            'authentication_error' => BetaAuthenticationError::class,
            'billing_error' => BetaBillingError::class,
            'permission_error' => BetaPermissionError::class,
            'not_found_error' => BetaNotFoundError::class,
            'rate_limit_error' => BetaRateLimitError::class,
            'timeout_error' => BetaGatewayTimeoutError::class,
            'api_error' => BetaAPIError::class,
            'overloaded_error' => BetaOverloadedError::class,
        ];
    }
}
