<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events\ManagedAgentsSessionErrorEvent;

use Anthropic\Beta\Sessions\Events\ManagedAgentsBillingError;
use Anthropic\Beta\Sessions\Events\ManagedAgentsMCPAuthenticationFailedError;
use Anthropic\Beta\Sessions\Events\ManagedAgentsMCPConnectionFailedError;
use Anthropic\Beta\Sessions\Events\ManagedAgentsModelOverloadedError;
use Anthropic\Beta\Sessions\Events\ManagedAgentsModelRateLimitedError;
use Anthropic\Beta\Sessions\Events\ManagedAgentsModelRequestFailedError;
use Anthropic\Beta\Sessions\Events\ManagedAgentsUnknownError;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * An unknown or unexpected error occurred during session execution. A fallback variant; clients that don't recognize a new error code can match on `retry_status` and `message` alone.
 *
 * @phpstan-import-type ManagedAgentsUnknownErrorShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsUnknownError
 * @phpstan-import-type ManagedAgentsModelOverloadedErrorShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsModelOverloadedError
 * @phpstan-import-type ManagedAgentsModelRateLimitedErrorShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsModelRateLimitedError
 * @phpstan-import-type ManagedAgentsModelRequestFailedErrorShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsModelRequestFailedError
 * @phpstan-import-type ManagedAgentsMCPConnectionFailedErrorShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsMCPConnectionFailedError
 * @phpstan-import-type ManagedAgentsMCPAuthenticationFailedErrorShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsMCPAuthenticationFailedError
 * @phpstan-import-type ManagedAgentsBillingErrorShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsBillingError
 *
 * @phpstan-type ErrorVariants = ManagedAgentsUnknownError|ManagedAgentsModelOverloadedError|ManagedAgentsModelRateLimitedError|ManagedAgentsModelRequestFailedError|ManagedAgentsMCPConnectionFailedError|ManagedAgentsMCPAuthenticationFailedError|ManagedAgentsBillingError
 * @phpstan-type ErrorShape = ErrorVariants|ManagedAgentsUnknownErrorShape|ManagedAgentsModelOverloadedErrorShape|ManagedAgentsModelRateLimitedErrorShape|ManagedAgentsModelRequestFailedErrorShape|ManagedAgentsMCPConnectionFailedErrorShape|ManagedAgentsMCPAuthenticationFailedErrorShape|ManagedAgentsBillingErrorShape
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
        ];
    }
}
