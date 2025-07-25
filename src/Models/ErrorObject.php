<?php

declare(strict_types=1);

namespace Anthropic\Models;

use Anthropic\Core\Concerns\Union;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-type error_object_alias = InvalidRequestError|AuthenticationError|BillingError|PermissionError|NotFoundError|RateLimitError|GatewayTimeoutError|APIErrorObject|OverloadedError
 */
final class ErrorObject implements ConverterSource
{
    use Union;

    public static function discriminator(): string
    {
        return 'type';
    }

    /**
     * @return list<string|Converter|ConverterSource>|array<string,
     * string|Converter|ConverterSource,>
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
