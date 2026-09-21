<?php

declare(strict_types=1);

namespace Anthropic\Beta;

use Anthropic\Beta\BetaError\Type;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-import-type BetaInvalidRequestErrorShape from \Anthropic\Beta\BetaInvalidRequestError
 * @phpstan-import-type BetaAuthenticationErrorShape from \Anthropic\Beta\BetaAuthenticationError
 * @phpstan-import-type BetaBillingErrorShape from \Anthropic\Beta\BetaBillingError
 * @phpstan-import-type BetaPermissionErrorShape from \Anthropic\Beta\BetaPermissionError
 * @phpstan-import-type BetaNotFoundErrorShape from \Anthropic\Beta\BetaNotFoundError
 * @phpstan-import-type BetaRateLimitErrorShape from \Anthropic\Beta\BetaRateLimitError
 * @phpstan-import-type BetaGatewayTimeoutErrorShape from \Anthropic\Beta\BetaGatewayTimeoutError
 * @phpstan-import-type BetaAPIErrorShape from \Anthropic\Beta\BetaAPIError
 * @phpstan-import-type BetaOverloadedErrorShape from \Anthropic\Beta\BetaOverloadedError
 *
 * @phpstan-type BetaErrorVariants = BetaInvalidRequestError|BetaAuthenticationError|BetaBillingError|BetaPermissionError|BetaNotFoundError|BetaRateLimitError|BetaGatewayTimeoutError|BetaAPIError|BetaOverloadedError
 * @phpstan-type BetaErrorShape = BetaErrorVariants|BetaInvalidRequestErrorShape|BetaAuthenticationErrorShape|BetaBillingErrorShape|BetaPermissionErrorShape|BetaNotFoundErrorShape|BetaRateLimitErrorShape|BetaGatewayTimeoutErrorShape|BetaAPIErrorShape|BetaOverloadedErrorShape
 */
final class BetaError implements ConverterSource
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

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @return ($type is Type::INVALID_REQUEST_ERROR|'invalid_request_error' ? BetaInvalidRequestError : ($type is Type::AUTHENTICATION_ERROR|'authentication_error' ? BetaAuthenticationError : ($type is Type::BILLING_ERROR|'billing_error' ? BetaBillingError : ($type is Type::PERMISSION_ERROR|'permission_error' ? BetaPermissionError : ($type is Type::NOT_FOUND_ERROR|'not_found_error' ? BetaNotFoundError : ($type is Type::RATE_LIMIT_ERROR|'rate_limit_error' ? BetaRateLimitError : ($type is Type::TIMEOUT_ERROR|'timeout_error' ? BetaGatewayTimeoutError : ($type is Type::API_ERROR|'api_error' ? BetaAPIError : ($type is Type::OVERLOADED_ERROR|'overloaded_error' ? BetaOverloadedError : BetaInvalidRequestError|BetaAuthenticationError|BetaBillingError|BetaPermissionError|BetaNotFoundError|BetaRateLimitError|BetaGatewayTimeoutError|BetaAPIError|BetaOverloadedError)))))))))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        string $message
    ): BetaInvalidRequestError|BetaAuthenticationError|BetaBillingError|BetaPermissionError|BetaNotFoundError|BetaRateLimitError|BetaGatewayTimeoutError|BetaAPIError|BetaOverloadedError {
        return match ($type) {
            Type::INVALID_REQUEST_ERROR, 'invalid_request_error' => BetaInvalidRequestError::with(
                message: $message
            ),
            Type::AUTHENTICATION_ERROR, 'authentication_error' => BetaAuthenticationError::with(
                message: $message
            ),
            Type::BILLING_ERROR, 'billing_error' => BetaBillingError::with(
                message: $message
            ),
            Type::PERMISSION_ERROR, 'permission_error' => BetaPermissionError::with(
                message: $message
            ),
            Type::NOT_FOUND_ERROR, 'not_found_error' => BetaNotFoundError::with(
                message: $message
            ),
            Type::RATE_LIMIT_ERROR, 'rate_limit_error' => BetaRateLimitError::with(
                message: $message
            ),
            Type::TIMEOUT_ERROR, 'timeout_error' => BetaGatewayTimeoutError::with(
                message: $message
            ),
            Type::API_ERROR, 'api_error' => BetaAPIError::with(message: $message),
            Type::OVERLOADED_ERROR, 'overloaded_error' => BetaOverloadedError::with(
                message: $message
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
