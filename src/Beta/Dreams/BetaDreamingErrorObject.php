<?php

declare(strict_types=1);

namespace Anthropic\Beta\Dreams;

use Anthropic\Beta\BetaAPIErrorObject;
use Anthropic\Beta\BetaAuthenticationErrorObject;
use Anthropic\Beta\BetaBillingErrorObject;
use Anthropic\Beta\BetaGatewayTimeoutErrorObject;
use Anthropic\Beta\BetaInvalidRequestErrorObject;
use Anthropic\Beta\BetaNotFoundErrorObject;
use Anthropic\Beta\BetaOverloadedErrorObject;
use Anthropic\Beta\BetaPermissionErrorObject;
use Anthropic\Beta\BetaRateLimitErrorObject;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-import-type BetaInvalidRequestErrorObjectShape from \Anthropic\Beta\BetaInvalidRequestErrorObject
 * @phpstan-import-type BetaAuthenticationErrorObjectShape from \Anthropic\Beta\BetaAuthenticationErrorObject
 * @phpstan-import-type BetaBillingErrorObjectShape from \Anthropic\Beta\BetaBillingErrorObject
 * @phpstan-import-type BetaPermissionErrorObjectShape from \Anthropic\Beta\BetaPermissionErrorObject
 * @phpstan-import-type BetaNotFoundErrorObjectShape from \Anthropic\Beta\BetaNotFoundErrorObject
 * @phpstan-import-type BetaRateLimitErrorObjectShape from \Anthropic\Beta\BetaRateLimitErrorObject
 * @phpstan-import-type BetaGatewayTimeoutErrorObjectShape from \Anthropic\Beta\BetaGatewayTimeoutErrorObject
 * @phpstan-import-type BetaAPIErrorObjectShape from \Anthropic\Beta\BetaAPIErrorObject
 * @phpstan-import-type BetaOverloadedErrorObjectShape from \Anthropic\Beta\BetaOverloadedErrorObject
 * @phpstan-import-type BetaTargetStoreHeldErrorObjectShape from \Anthropic\Beta\Dreams\BetaTargetStoreHeldErrorObject
 *
 * @phpstan-type BetaDreamingErrorObjectVariants = BetaInvalidRequestErrorObject|BetaAuthenticationErrorObject|BetaBillingErrorObject|BetaPermissionErrorObject|BetaNotFoundErrorObject|BetaRateLimitErrorObject|BetaGatewayTimeoutErrorObject|BetaAPIErrorObject|BetaOverloadedErrorObject|BetaTargetStoreHeldErrorObject
 * @phpstan-type BetaDreamingErrorObjectShape = BetaDreamingErrorObjectVariants|BetaInvalidRequestErrorObjectShape|BetaAuthenticationErrorObjectShape|BetaBillingErrorObjectShape|BetaPermissionErrorObjectShape|BetaNotFoundErrorObjectShape|BetaRateLimitErrorObjectShape|BetaGatewayTimeoutErrorObjectShape|BetaAPIErrorObjectShape|BetaOverloadedErrorObjectShape|BetaTargetStoreHeldErrorObjectShape
 */
class BetaDreamingErrorObject implements ConverterSource
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
            'invalid_request_error' => BetaInvalidRequestErrorObject::class,
            'authentication_error' => BetaAuthenticationErrorObject::class,
            'billing_error' => BetaBillingErrorObject::class,
            'permission_error' => BetaPermissionErrorObject::class,
            'not_found_error' => BetaNotFoundErrorObject::class,
            'rate_limit_error' => BetaRateLimitErrorObject::class,
            'timeout_error' => BetaGatewayTimeoutErrorObject::class,
            'api_error' => BetaAPIErrorObject::class,
            'overloaded_error' => BetaOverloadedErrorObject::class,
            'conflict_error' => BetaTargetStoreHeldErrorObject::class,
        ];
    }
}

class_alias(
    BetaDreamingErrorObject::class,
    'Anthropic\Beta\Dreams\BetaDreamingError'
);
