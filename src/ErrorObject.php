<?php

declare(strict_types=1);

namespace Anthropic;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-import-type InvalidRequestErrorShape from \Anthropic\InvalidRequestError
 * @phpstan-import-type AuthenticationErrorShape from \Anthropic\AuthenticationError
 * @phpstan-import-type BillingErrorShape from \Anthropic\BillingError
 * @phpstan-import-type PermissionErrorShape from \Anthropic\PermissionError
 * @phpstan-import-type NotFoundErrorShape from \Anthropic\NotFoundError
 * @phpstan-import-type RateLimitErrorShape from \Anthropic\RateLimitError
 * @phpstan-import-type GatewayTimeoutErrorShape from \Anthropic\GatewayTimeoutError
 * @phpstan-import-type APIErrorObjectShape from \Anthropic\APIErrorObject
 * @phpstan-import-type OverloadedErrorShape from \Anthropic\OverloadedError
 *
 * @phpstan-type ErrorObjectVariants = InvalidRequestError|AuthenticationError|BillingError|PermissionError|NotFoundError|RateLimitError|GatewayTimeoutError|APIErrorObject|OverloadedError
 * @phpstan-type ErrorObjectShape = ErrorObjectVariants|InvalidRequestErrorShape|AuthenticationErrorShape|BillingErrorShape|PermissionErrorShape|NotFoundErrorShape|RateLimitErrorShape|GatewayTimeoutErrorShape|APIErrorObjectShape|OverloadedErrorShape
 */
final class ErrorObject implements ConverterSource
{
    use SdkUnion;

    public static function discriminator(): string
    {
        return 'type';
    }

    /**
     * @return list<string|Converter|ConverterSource>|array<string,string|Converter|ConverterSource>
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
