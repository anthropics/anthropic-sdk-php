<?php

declare(strict_types=1);

namespace Anthropic;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\ErrorObject\Type;

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

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @return ($type is Type::INVALID_REQUEST_ERROR|'invalid_request_error' ? InvalidRequestError : ($type is Type::AUTHENTICATION_ERROR|'authentication_error' ? AuthenticationError : ($type is Type::BILLING_ERROR|'billing_error' ? BillingError : ($type is Type::PERMISSION_ERROR|'permission_error' ? PermissionError : ($type is Type::NOT_FOUND_ERROR|'not_found_error' ? NotFoundError : ($type is Type::RATE_LIMIT_ERROR|'rate_limit_error' ? RateLimitError : ($type is Type::TIMEOUT_ERROR|'timeout_error' ? GatewayTimeoutError : ($type is Type::API_ERROR|'api_error' ? APIErrorObject : ($type is Type::OVERLOADED_ERROR|'overloaded_error' ? OverloadedError : InvalidRequestError|AuthenticationError|BillingError|PermissionError|NotFoundError|RateLimitError|GatewayTimeoutError|APIErrorObject|OverloadedError)))))))))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        string $message
    ): InvalidRequestError|AuthenticationError|BillingError|PermissionError|NotFoundError|RateLimitError|GatewayTimeoutError|APIErrorObject|OverloadedError {
        return match ($type) {
            Type::INVALID_REQUEST_ERROR, 'invalid_request_error' => InvalidRequestError::with(
                message: $message
            ),
            Type::AUTHENTICATION_ERROR, 'authentication_error' => AuthenticationError::with(
                message: $message
            ),
            Type::BILLING_ERROR, 'billing_error' => BillingError::with(
                message: $message
            ),
            Type::PERMISSION_ERROR, 'permission_error' => PermissionError::with(
                message: $message
            ),
            Type::NOT_FOUND_ERROR, 'not_found_error' => NotFoundError::with(
                message: $message
            ),
            Type::RATE_LIMIT_ERROR, 'rate_limit_error' => RateLimitError::with(
                message: $message
            ),
            Type::TIMEOUT_ERROR, 'timeout_error' => GatewayTimeoutError::with(
                message: $message
            ),
            Type::API_ERROR, 'api_error' => APIErrorObject::with(message: $message),
            Type::OVERLOADED_ERROR, 'overloaded_error' => OverloadedError::with(
                message: $message
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
