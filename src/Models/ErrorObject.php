<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Concerns\Union;
use Anthropic\Core\Contracts\Converter;
use Anthropic\Core\Contracts\StaticConverter;

final class ErrorObject implements StaticConverter
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
            'invalid_request_error' => InvalidRequestError::class,
            'authentication_error' => AuthenticationError::class,
            'billing_error' => BillingError::class,
            'permission_error' => PermissionError::class,
            'not_found_error' => NotFoundError::class,
            'rate_limit_error' => RateLimitError::class,
            'timeout_error' => GatewayTimeoutError::class,
            'api_error' => APIErrorObject::class,
            'overloaded_error' => OverloadedError::class,
        ];
    }
}
