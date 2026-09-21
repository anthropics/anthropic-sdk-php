<?php

declare(strict_types=1);

namespace Anthropic\Beta\MemoryStores\Memories;

use Anthropic\Beta\BetaAPIError;
use Anthropic\Beta\BetaAuthenticationError;
use Anthropic\Beta\BetaBillingError;
use Anthropic\Beta\BetaGatewayTimeoutError;
use Anthropic\Beta\BetaInvalidRequestError;
use Anthropic\Beta\BetaNotFoundError;
use Anthropic\Beta\BetaOverloadedError;
use Anthropic\Beta\BetaPermissionError;
use Anthropic\Beta\BetaRateLimitError;
use Anthropic\Beta\MemoryStores\Memories\ManagedAgentsError\Type;
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
 * @phpstan-import-type ManagedAgentsMemoryPreconditionFailedErrorShape from \Anthropic\Beta\MemoryStores\Memories\ManagedAgentsMemoryPreconditionFailedError
 * @phpstan-import-type ManagedAgentsMemoryPathConflictErrorShape from \Anthropic\Beta\MemoryStores\Memories\ManagedAgentsMemoryPathConflictError
 * @phpstan-import-type ManagedAgentsConflictErrorShape from \Anthropic\Beta\MemoryStores\Memories\ManagedAgentsConflictError
 *
 * @phpstan-type ManagedAgentsErrorVariants = BetaInvalidRequestError|BetaAuthenticationError|BetaBillingError|BetaPermissionError|BetaNotFoundError|BetaRateLimitError|BetaGatewayTimeoutError|BetaAPIError|BetaOverloadedError|ManagedAgentsMemoryPreconditionFailedError|ManagedAgentsMemoryPathConflictError|ManagedAgentsConflictError
 * @phpstan-type ManagedAgentsErrorShape = ManagedAgentsErrorVariants|BetaInvalidRequestErrorShape|BetaAuthenticationErrorShape|BetaBillingErrorShape|BetaPermissionErrorShape|BetaNotFoundErrorShape|BetaRateLimitErrorShape|BetaGatewayTimeoutErrorShape|BetaAPIErrorShape|BetaOverloadedErrorShape|ManagedAgentsMemoryPreconditionFailedErrorShape|ManagedAgentsMemoryPathConflictErrorShape|ManagedAgentsConflictErrorShape
 */
final class ManagedAgentsError implements ConverterSource
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
            'memory_precondition_failed_error' => ManagedAgentsMemoryPreconditionFailedError::class,
            'memory_path_conflict_error' => ManagedAgentsMemoryPathConflictError::class,
            'conflict_error' => ManagedAgentsConflictError::class,
        ];
    }

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @return ($type is Type::INVALID_REQUEST_ERROR|'invalid_request_error' ? BetaInvalidRequestError : ($type is Type::AUTHENTICATION_ERROR|'authentication_error' ? BetaAuthenticationError : ($type is Type::BILLING_ERROR|'billing_error' ? BetaBillingError : ($type is Type::PERMISSION_ERROR|'permission_error' ? BetaPermissionError : ($type is Type::NOT_FOUND_ERROR|'not_found_error' ? BetaNotFoundError : ($type is Type::RATE_LIMIT_ERROR|'rate_limit_error' ? BetaRateLimitError : ($type is Type::TIMEOUT_ERROR|'timeout_error' ? BetaGatewayTimeoutError : ($type is Type::API_ERROR|'api_error' ? BetaAPIError : ($type is Type::OVERLOADED_ERROR|'overloaded_error' ? BetaOverloadedError : ($type is Type::MEMORY_PRECONDITION_FAILED_ERROR|'memory_precondition_failed_error' ? ManagedAgentsMemoryPreconditionFailedError : ($type is Type::MEMORY_PATH_CONFLICT_ERROR|'memory_path_conflict_error' ? ManagedAgentsMemoryPathConflictError : ($type is Type::CONFLICT_ERROR|'conflict_error' ? ManagedAgentsConflictError : BetaInvalidRequestError|BetaAuthenticationError|BetaBillingError|BetaPermissionError|BetaNotFoundError|BetaRateLimitError|BetaGatewayTimeoutError|BetaAPIError|BetaOverloadedError|ManagedAgentsMemoryPreconditionFailedError|ManagedAgentsMemoryPathConflictError|ManagedAgentsConflictError))))))))))))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        ?string $message = null,
        ?string $conflictingMemoryID = null,
        ?string $conflictingPath = null,
    ): BetaInvalidRequestError|BetaAuthenticationError|BetaBillingError|BetaPermissionError|BetaNotFoundError|BetaRateLimitError|BetaGatewayTimeoutError|BetaAPIError|BetaOverloadedError|ManagedAgentsMemoryPreconditionFailedError|ManagedAgentsMemoryPathConflictError|ManagedAgentsConflictError {
        return match ($type) {
            Type::INVALID_REQUEST_ERROR, 'invalid_request_error' => BetaInvalidRequestError::with(
                message: $message ?? 'Invalid request'
            ),
            Type::AUTHENTICATION_ERROR, 'authentication_error' => BetaAuthenticationError::with(
                message: $message ?? 'Authentication error'
            ),
            Type::BILLING_ERROR, 'billing_error' => BetaBillingError::with(
                message: $message ?? 'Billing error'
            ),
            Type::PERMISSION_ERROR, 'permission_error' => BetaPermissionError::with(
                message: $message ?? 'Permission denied'
            ),
            Type::NOT_FOUND_ERROR, 'not_found_error' => BetaNotFoundError::with(
                message: $message ?? 'Not found'
            ),
            Type::RATE_LIMIT_ERROR, 'rate_limit_error' => BetaRateLimitError::with(
                message: $message ?? 'Rate limited'
            ),
            Type::TIMEOUT_ERROR, 'timeout_error' => BetaGatewayTimeoutError::with(
                message: $message ?? 'Request timeout'
            ),
            Type::API_ERROR, 'api_error' => BetaAPIError::with(
                message: $message ?? 'Internal server error'
            ),
            Type::OVERLOADED_ERROR, 'overloaded_error' => BetaOverloadedError::with(
                message: $message ?? 'Overloaded'
            ),
            Type::MEMORY_PRECONDITION_FAILED_ERROR, 'memory_precondition_failed_error' => ManagedAgentsMemoryPreconditionFailedError::with(
                type: 'memory_precondition_failed_error',
                message: $message
            ),
            Type::MEMORY_PATH_CONFLICT_ERROR, 'memory_path_conflict_error' => ManagedAgentsMemoryPathConflictError::with(
                type: 'memory_path_conflict_error',
                conflictingMemoryID: $conflictingMemoryID,
                conflictingPath: $conflictingPath,
                message: $message,
            ),
            Type::CONFLICT_ERROR, 'conflict_error' => ManagedAgentsConflictError::with(
                type: 'conflict_error',
                message: $message
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
