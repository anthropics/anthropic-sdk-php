<?php

declare(strict_types=1);

namespace Anthropic\Beta;

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
 * @phpstan-type BetaErrorShape = BetaInvalidRequestErrorShape|BetaAuthenticationErrorShape|BetaBillingErrorShape|BetaPermissionErrorShape|BetaNotFoundErrorShape|BetaRateLimitErrorShape|BetaGatewayTimeoutErrorShape|BetaAPIErrorShape|BetaOverloadedErrorShape
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
}
