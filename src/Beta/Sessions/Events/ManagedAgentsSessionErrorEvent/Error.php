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
use Anthropic\Beta\Sessions\Events\ManagedAgentsRepositoryAuthenticationError;
use Anthropic\Beta\Sessions\Events\ManagedAgentsRepositoryCheckoutError;
use Anthropic\Beta\Sessions\Events\ManagedAgentsRepositoryCloneError;
use Anthropic\Beta\Sessions\Events\ManagedAgentsRepositoryForbiddenError;
use Anthropic\Beta\Sessions\Events\ManagedAgentsRepositoryNotFoundError;
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
 * @phpstan-import-type ManagedAgentsRepositoryAuthenticationErrorShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsRepositoryAuthenticationError
 * @phpstan-import-type ManagedAgentsRepositoryForbiddenErrorShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsRepositoryForbiddenError
 * @phpstan-import-type ManagedAgentsRepositoryNotFoundErrorShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsRepositoryNotFoundError
 * @phpstan-import-type ManagedAgentsRepositoryCheckoutErrorShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsRepositoryCheckoutError
 * @phpstan-import-type ManagedAgentsRepositoryCloneErrorShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsRepositoryCloneError
 *
 * @phpstan-type ErrorVariants = ManagedAgentsUnknownError|ManagedAgentsModelOverloadedError|ManagedAgentsModelRateLimitedError|ManagedAgentsModelRequestFailedError|ManagedAgentsMCPConnectionFailedError|ManagedAgentsMCPAuthenticationFailedError|ManagedAgentsBillingError|ManagedAgentsCredentialHostUnreachableError|ManagedAgentsRepositoryAuthenticationError|ManagedAgentsRepositoryForbiddenError|ManagedAgentsRepositoryNotFoundError|ManagedAgentsRepositoryCheckoutError|ManagedAgentsRepositoryCloneError
 * @phpstan-type ErrorShape = ErrorVariants|ManagedAgentsUnknownErrorShape|ManagedAgentsModelOverloadedErrorShape|ManagedAgentsModelRateLimitedErrorShape|ManagedAgentsModelRequestFailedErrorShape|ManagedAgentsMCPConnectionFailedErrorShape|ManagedAgentsMCPAuthenticationFailedErrorShape|ManagedAgentsBillingErrorShape|ManagedAgentsCredentialHostUnreachableErrorShape|ManagedAgentsRepositoryAuthenticationErrorShape|ManagedAgentsRepositoryForbiddenErrorShape|ManagedAgentsRepositoryNotFoundErrorShape|ManagedAgentsRepositoryCheckoutErrorShape|ManagedAgentsRepositoryCloneErrorShape
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
            'repository_authentication_error' => ManagedAgentsRepositoryAuthenticationError::class,
            'repository_forbidden_error' => ManagedAgentsRepositoryForbiddenError::class,
            'repository_not_found_error' => ManagedAgentsRepositoryNotFoundError::class,
            'repository_checkout_error' => ManagedAgentsRepositoryCheckoutError::class,
            'repository_clone_error' => ManagedAgentsRepositoryCloneError::class,
        ];
    }
}
