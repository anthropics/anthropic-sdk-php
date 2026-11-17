<?php

declare(strict_types=1);

namespace Anthropic\Beta\MemoryStores\Memories;

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
 * @phpstan-import-type ManagedAgentsMemoryPreconditionFailedErrorObjectShape from \Anthropic\Beta\MemoryStores\Memories\ManagedAgentsMemoryPreconditionFailedErrorObject
 * @phpstan-import-type ManagedAgentsMemoryPathConflictErrorObjectShape from \Anthropic\Beta\MemoryStores\Memories\ManagedAgentsMemoryPathConflictErrorObject
 * @phpstan-import-type ManagedAgentsConflictErrorObjectShape from \Anthropic\Beta\MemoryStores\Memories\ManagedAgentsConflictErrorObject
 *
 * @phpstan-type ManagedAgentsErrorObjectVariants = BetaInvalidRequestErrorObject|BetaAuthenticationErrorObject|BetaBillingErrorObject|BetaPermissionErrorObject|BetaNotFoundErrorObject|BetaRateLimitErrorObject|BetaGatewayTimeoutErrorObject|BetaAPIErrorObject|BetaOverloadedErrorObject|ManagedAgentsMemoryPreconditionFailedErrorObject|ManagedAgentsMemoryPathConflictErrorObject|ManagedAgentsConflictErrorObject
 * @phpstan-type ManagedAgentsErrorObjectShape = ManagedAgentsErrorObjectVariants|BetaInvalidRequestErrorObjectShape|BetaAuthenticationErrorObjectShape|BetaBillingErrorObjectShape|BetaPermissionErrorObjectShape|BetaNotFoundErrorObjectShape|BetaRateLimitErrorObjectShape|BetaGatewayTimeoutErrorObjectShape|BetaAPIErrorObjectShape|BetaOverloadedErrorObjectShape|ManagedAgentsMemoryPreconditionFailedErrorObjectShape|ManagedAgentsMemoryPathConflictErrorObjectShape|ManagedAgentsConflictErrorObjectShape
 */
class ManagedAgentsErrorObject implements ConverterSource
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
            'memory_precondition_failed_error' => ManagedAgentsMemoryPreconditionFailedErrorObject::class,
            'memory_path_conflict_error' => ManagedAgentsMemoryPathConflictErrorObject::class,
            'conflict_error' => ManagedAgentsConflictErrorObject::class,
        ];
    }
}

class_alias(
    ManagedAgentsErrorObject::class,
    'Anthropic\Beta\MemoryStores\Memories\ManagedAgentsError',
);
