<?php

declare(strict_types=1);

namespace Anthropic\Beta\Dreams;

use Anthropic\Beta\BetaAPIError;
use Anthropic\Beta\BetaAuthenticationError;
use Anthropic\Beta\BetaBillingError;
use Anthropic\Beta\BetaGatewayTimeoutError;
use Anthropic\Beta\BetaInvalidRequestError;
use Anthropic\Beta\BetaNotFoundError;
use Anthropic\Beta\BetaOverloadedError;
use Anthropic\Beta\BetaPermissionError;
use Anthropic\Beta\BetaRateLimitError;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * The `output_behavior.memory_store_id` target is still held by a prior `{type: "update_existing"}` dream — one that is `pending` or `running`, or was canceled with its final writes still landing. Rarely the named dream has just finished (`completed`/`failed`) and its execution is still closing; an immediate retry then almost always succeeds. The message names the holding dream when the server can identify it (rarely omitted); poll it to a terminal state or cancel it, then retry. Carried with `x-should-retry: false`.
 *
 * @phpstan-import-type BetaInvalidRequestErrorShape from \Anthropic\Beta\BetaInvalidRequestError
 * @phpstan-import-type BetaAuthenticationErrorShape from \Anthropic\Beta\BetaAuthenticationError
 * @phpstan-import-type BetaBillingErrorShape from \Anthropic\Beta\BetaBillingError
 * @phpstan-import-type BetaPermissionErrorShape from \Anthropic\Beta\BetaPermissionError
 * @phpstan-import-type BetaNotFoundErrorShape from \Anthropic\Beta\BetaNotFoundError
 * @phpstan-import-type BetaRateLimitErrorShape from \Anthropic\Beta\BetaRateLimitError
 * @phpstan-import-type BetaGatewayTimeoutErrorShape from \Anthropic\Beta\BetaGatewayTimeoutError
 * @phpstan-import-type BetaAPIErrorShape from \Anthropic\Beta\BetaAPIError
 * @phpstan-import-type BetaOverloadedErrorShape from \Anthropic\Beta\BetaOverloadedError
 * @phpstan-import-type BetaTargetStoreHeldErrorShape from \Anthropic\Beta\Dreams\BetaTargetStoreHeldError
 *
 * @phpstan-type BetaDreamingErrorVariants = BetaInvalidRequestError|BetaAuthenticationError|BetaBillingError|BetaPermissionError|BetaNotFoundError|BetaRateLimitError|BetaGatewayTimeoutError|BetaAPIError|BetaOverloadedError|BetaTargetStoreHeldError
 * @phpstan-type BetaDreamingErrorShape = BetaDreamingErrorVariants|BetaInvalidRequestErrorShape|BetaAuthenticationErrorShape|BetaBillingErrorShape|BetaPermissionErrorShape|BetaNotFoundErrorShape|BetaRateLimitErrorShape|BetaGatewayTimeoutErrorShape|BetaAPIErrorShape|BetaOverloadedErrorShape|BetaTargetStoreHeldErrorShape
 */
final class BetaDreamingError implements ConverterSource
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
            'conflict_error' => BetaTargetStoreHeldError::class,
        ];
    }
}
