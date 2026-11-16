<?php

declare(strict_types=1);

namespace Anthropic;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-import-type InvalidRequestErrorObjectShape from \Anthropic\InvalidRequestErrorObject
 * @phpstan-import-type AuthenticationErrorObjectShape from \Anthropic\AuthenticationErrorObject
 * @phpstan-import-type BillingErrorObjectShape from \Anthropic\BillingErrorObject
 * @phpstan-import-type PermissionErrorObjectShape from \Anthropic\PermissionErrorObject
 * @phpstan-import-type NotFoundErrorObjectShape from \Anthropic\NotFoundErrorObject
 * @phpstan-import-type RateLimitErrorObjectShape from \Anthropic\RateLimitErrorObject
 * @phpstan-import-type GatewayTimeoutErrorObjectShape from \Anthropic\GatewayTimeoutErrorObject
 * @phpstan-import-type APIErrorObjectShape from \Anthropic\APIErrorObject
 * @phpstan-import-type OverloadedErrorObjectShape from \Anthropic\OverloadedErrorObject
 *
 * @phpstan-type ErrorObjectVariants = InvalidRequestErrorObject|AuthenticationErrorObject|BillingErrorObject|PermissionErrorObject|NotFoundErrorObject|RateLimitErrorObject|GatewayTimeoutErrorObject|APIErrorObject|OverloadedErrorObject
 * @phpstan-type ErrorObjectShape = ErrorObjectVariants|InvalidRequestErrorObjectShape|AuthenticationErrorObjectShape|BillingErrorObjectShape|PermissionErrorObjectShape|NotFoundErrorObjectShape|RateLimitErrorObjectShape|GatewayTimeoutErrorObjectShape|APIErrorObjectShape|OverloadedErrorObjectShape
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
            'invalid_request_error' => InvalidRequestErrorObject::class,
            'authentication_error' => AuthenticationErrorObject::class,
            'billing_error' => BillingErrorObject::class,
            'permission_error' => PermissionErrorObject::class,
            'not_found_error' => NotFoundErrorObject::class,
            'rate_limit_error' => RateLimitErrorObject::class,
            'timeout_error' => GatewayTimeoutErrorObject::class,
            'api_error' => APIErrorObject::class,
            'overloaded_error' => OverloadedErrorObject::class,
        ];
    }
}
