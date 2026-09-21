<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events\ManagedAgentsSessionErrorEvent;

use Anthropic\Beta\Sessions\Events\ManagedAgentsBillingError;
use Anthropic\Beta\Sessions\Events\ManagedAgentsCredentialHostUnreachableError;
use Anthropic\Beta\Sessions\Events\ManagedAgentsMCPAuthenticationFailedError;
use Anthropic\Beta\Sessions\Events\ManagedAgentsMCPConnectionFailedError;
use Anthropic\Beta\Sessions\Events\ManagedAgentsModelOverloadedError;
use Anthropic\Beta\Sessions\Events\ManagedAgentsModelRateLimitedError;
use Anthropic\Beta\Sessions\Events\ManagedAgentsModelRequestFailedError;
use Anthropic\Beta\Sessions\Events\ManagedAgentsRetryStatusExhausted;
use Anthropic\Beta\Sessions\Events\ManagedAgentsRetryStatusRetrying;
use Anthropic\Beta\Sessions\Events\ManagedAgentsRetryStatusTerminal;
use Anthropic\Beta\Sessions\Events\ManagedAgentsSessionErrorEvent\Error\Type;
use Anthropic\Beta\Sessions\Events\ManagedAgentsUnknownError;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-import-type ManagedAgentsUnknownErrorShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsUnknownError
 * @phpstan-import-type ManagedAgentsModelOverloadedErrorShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsModelOverloadedError
 * @phpstan-import-type ManagedAgentsModelRateLimitedErrorShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsModelRateLimitedError
 * @phpstan-import-type ManagedAgentsModelRequestFailedErrorShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsModelRequestFailedError
 * @phpstan-import-type ManagedAgentsMCPConnectionFailedErrorShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsMCPConnectionFailedError
 * @phpstan-import-type ManagedAgentsMCPAuthenticationFailedErrorShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsMCPAuthenticationFailedError
 * @phpstan-import-type ManagedAgentsBillingErrorShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsBillingError
 * @phpstan-import-type ManagedAgentsCredentialHostUnreachableErrorShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsCredentialHostUnreachableError
 * @phpstan-import-type RetryStatusShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsUnknownError\RetryStatus
 * @phpstan-import-type RetryStatusShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsModelOverloadedError\RetryStatus as RetryStatusShape1
 * @phpstan-import-type RetryStatusShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsModelRateLimitedError\RetryStatus as RetryStatusShape2
 * @phpstan-import-type RetryStatusShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsModelRequestFailedError\RetryStatus as RetryStatusShape3
 * @phpstan-import-type RetryStatusShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsMCPConnectionFailedError\RetryStatus as RetryStatusShape4
 * @phpstan-import-type RetryStatusShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsMCPAuthenticationFailedError\RetryStatus as RetryStatusShape5
 * @phpstan-import-type RetryStatusShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsBillingError\RetryStatus as RetryStatusShape6
 * @phpstan-import-type RetryStatusShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsCredentialHostUnreachableError\RetryStatus as RetryStatusShape7
 *
 * @phpstan-type ErrorVariants = ManagedAgentsUnknownError|ManagedAgentsModelOverloadedError|ManagedAgentsModelRateLimitedError|ManagedAgentsModelRequestFailedError|ManagedAgentsMCPConnectionFailedError|ManagedAgentsMCPAuthenticationFailedError|ManagedAgentsBillingError|ManagedAgentsCredentialHostUnreachableError
 * @phpstan-type ErrorShape = ErrorVariants|ManagedAgentsUnknownErrorShape|ManagedAgentsModelOverloadedErrorShape|ManagedAgentsModelRateLimitedErrorShape|ManagedAgentsModelRequestFailedErrorShape|ManagedAgentsMCPConnectionFailedErrorShape|ManagedAgentsMCPAuthenticationFailedErrorShape|ManagedAgentsBillingErrorShape|ManagedAgentsCredentialHostUnreachableErrorShape
 */
final class Error implements ConverterSource
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
            'unknown_error' => ManagedAgentsUnknownError::class,
            'model_overloaded_error' => ManagedAgentsModelOverloadedError::class,
            'model_rate_limited_error' => ManagedAgentsModelRateLimitedError::class,
            'model_request_failed_error' => ManagedAgentsModelRequestFailedError::class,
            'mcp_connection_failed_error' => ManagedAgentsMCPConnectionFailedError::class,
            'mcp_authentication_failed_error' => ManagedAgentsMCPAuthenticationFailedError::class,
            'billing_error' => ManagedAgentsBillingError::class,
            'credential_host_unreachable_error' => ManagedAgentsCredentialHostUnreachableError::class,
        ];
    }

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @param ($type is Type::UNKNOWN_ERROR|'unknown_error' ? RetryStatusShape : ($type is Type::MODEL_OVERLOADED_ERROR|'model_overloaded_error' ? RetryStatusShape1 : ($type is Type::MODEL_RATE_LIMITED_ERROR|'model_rate_limited_error' ? RetryStatusShape2 : ($type is Type::MODEL_REQUEST_FAILED_ERROR|'model_request_failed_error' ? RetryStatusShape3 : ($type is Type::MCP_CONNECTION_FAILED_ERROR|'mcp_connection_failed_error' ? RetryStatusShape4 : ($type is Type::MCP_AUTHENTICATION_FAILED_ERROR|'mcp_authentication_failed_error' ? RetryStatusShape5 : ($type is Type::BILLING_ERROR|'billing_error' ? RetryStatusShape6 : RetryStatusShape7))))))) $retryStatus
     *
     * @return ($type is Type::UNKNOWN_ERROR|'unknown_error' ? ManagedAgentsUnknownError : ($type is Type::MODEL_OVERLOADED_ERROR|'model_overloaded_error' ? ManagedAgentsModelOverloadedError : ($type is Type::MODEL_RATE_LIMITED_ERROR|'model_rate_limited_error' ? ManagedAgentsModelRateLimitedError : ($type is Type::MODEL_REQUEST_FAILED_ERROR|'model_request_failed_error' ? ManagedAgentsModelRequestFailedError : ($type is Type::MCP_CONNECTION_FAILED_ERROR|'mcp_connection_failed_error' ? ManagedAgentsMCPConnectionFailedError : ($type is Type::MCP_AUTHENTICATION_FAILED_ERROR|'mcp_authentication_failed_error' ? ManagedAgentsMCPAuthenticationFailedError : ($type is Type::BILLING_ERROR|'billing_error' ? ManagedAgentsBillingError : ($type is Type::CREDENTIAL_HOST_UNREACHABLE_ERROR|'credential_host_unreachable_error' ? ManagedAgentsCredentialHostUnreachableError : ManagedAgentsUnknownError|ManagedAgentsModelOverloadedError|ManagedAgentsModelRateLimitedError|ManagedAgentsModelRequestFailedError|ManagedAgentsMCPConnectionFailedError|ManagedAgentsMCPAuthenticationFailedError|ManagedAgentsBillingError|ManagedAgentsCredentialHostUnreachableError))))))))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        string $message,
        ManagedAgentsRetryStatusRetrying|array|ManagedAgentsRetryStatusExhausted|ManagedAgentsRetryStatusTerminal $retryStatus,
        ?string $mcpServerName = null,
        ?string $credentialID = null,
        ?string $vaultID = null,
    ): ManagedAgentsUnknownError|ManagedAgentsModelOverloadedError|ManagedAgentsModelRateLimitedError|ManagedAgentsModelRequestFailedError|ManagedAgentsMCPConnectionFailedError|ManagedAgentsMCPAuthenticationFailedError|ManagedAgentsBillingError|ManagedAgentsCredentialHostUnreachableError {
        return match ($type) {
            Type::UNKNOWN_ERROR, 'unknown_error' => ManagedAgentsUnknownError::with(
                type: 'unknown_error',
                message: $message,
                retryStatus: $retryStatus
            ),
            Type::MODEL_OVERLOADED_ERROR, 'model_overloaded_error' => ManagedAgentsModelOverloadedError::with(
                type: 'model_overloaded_error',
                message: $message,
                // @phpstan-ignore argument.type
                retryStatus: $retryStatus,
            ),
            Type::MODEL_RATE_LIMITED_ERROR, 'model_rate_limited_error' => ManagedAgentsModelRateLimitedError::with(
                type: 'model_rate_limited_error',
                message: $message,
                // @phpstan-ignore argument.type
                retryStatus: $retryStatus,
            ),
            Type::MODEL_REQUEST_FAILED_ERROR, 'model_request_failed_error' => ManagedAgentsModelRequestFailedError::with(
                type: 'model_request_failed_error',
                message: $message,
                // @phpstan-ignore argument.type
                retryStatus: $retryStatus,
            ),
            Type::MCP_CONNECTION_FAILED_ERROR, 'mcp_connection_failed_error' => ManagedAgentsMCPConnectionFailedError::with(
                type: 'mcp_connection_failed_error',
                mcpServerName: $mcpServerName ?? throw new \ArgumentCountError('$mcpServerName is required'),
                message: $message,
                // @phpstan-ignore argument.type
                retryStatus: $retryStatus,
            ),
            Type::MCP_AUTHENTICATION_FAILED_ERROR, 'mcp_authentication_failed_error' => ManagedAgentsMCPAuthenticationFailedError::with(
                type: 'mcp_authentication_failed_error',
                mcpServerName: $mcpServerName ?? throw new \ArgumentCountError('$mcpServerName is required'),
                message: $message,
                // @phpstan-ignore argument.type
                retryStatus: $retryStatus,
            ),
            Type::BILLING_ERROR, 'billing_error' => ManagedAgentsBillingError::with(
                type: 'billing_error',
                message: $message,
                // @phpstan-ignore argument.type
                retryStatus: $retryStatus,
            ),
            Type::CREDENTIAL_HOST_UNREACHABLE_ERROR, 'credential_host_unreachable_error' => ManagedAgentsCredentialHostUnreachableError::with(
                type: 'credential_host_unreachable_error',
                credentialID: $credentialID ?? throw new \ArgumentCountError('$credentialID is required'),
                message: $message,
                // @phpstan-ignore argument.type
                retryStatus: $retryStatus,
                vaultID: $vaultID ?? throw new \ArgumentCountError('$vaultID is required'),
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
