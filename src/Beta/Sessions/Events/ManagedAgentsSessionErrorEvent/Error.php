<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Events\ManagedAgentsSessionErrorEvent;

use Anthropic\Beta\Sessions\Events\ManagedAgentsBillingErrorObject;
use Anthropic\Beta\Sessions\Events\ManagedAgentsCompactionLimitReachedErrorObject;
use Anthropic\Beta\Sessions\Events\ManagedAgentsCredentialHostUnreachableErrorObject;
use Anthropic\Beta\Sessions\Events\ManagedAgentsMCPAuthenticationFailedErrorObject;
use Anthropic\Beta\Sessions\Events\ManagedAgentsMCPConnectionFailedErrorObject;
use Anthropic\Beta\Sessions\Events\ManagedAgentsModelOverloadedErrorObject;
use Anthropic\Beta\Sessions\Events\ManagedAgentsModelRateLimitedErrorObject;
use Anthropic\Beta\Sessions\Events\ManagedAgentsModelRequestFailedErrorObject;
use Anthropic\Beta\Sessions\Events\ManagedAgentsRepositoryAuthenticationErrorObject;
use Anthropic\Beta\Sessions\Events\ManagedAgentsRepositoryCheckoutErrorObject;
use Anthropic\Beta\Sessions\Events\ManagedAgentsRepositoryCloneErrorObject;
use Anthropic\Beta\Sessions\Events\ManagedAgentsRepositoryForbiddenErrorObject;
use Anthropic\Beta\Sessions\Events\ManagedAgentsRepositoryNotFoundErrorObject;
use Anthropic\Beta\Sessions\Events\ManagedAgentsToolUseLimitReachedErrorObject;
use Anthropic\Beta\Sessions\Events\ManagedAgentsUnknownErrorObject;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-import-type ManagedAgentsUnknownErrorObjectShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsUnknownErrorObject
 * @phpstan-import-type ManagedAgentsModelOverloadedErrorObjectShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsModelOverloadedErrorObject
 * @phpstan-import-type ManagedAgentsModelRateLimitedErrorObjectShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsModelRateLimitedErrorObject
 * @phpstan-import-type ManagedAgentsModelRequestFailedErrorObjectShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsModelRequestFailedErrorObject
 * @phpstan-import-type ManagedAgentsMCPConnectionFailedErrorObjectShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsMCPConnectionFailedErrorObject
 * @phpstan-import-type ManagedAgentsMCPAuthenticationFailedErrorObjectShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsMCPAuthenticationFailedErrorObject
 * @phpstan-import-type ManagedAgentsBillingErrorObjectShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsBillingErrorObject
 * @phpstan-import-type ManagedAgentsCredentialHostUnreachableErrorObjectShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsCredentialHostUnreachableErrorObject
 * @phpstan-import-type ManagedAgentsToolUseLimitReachedErrorObjectShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsToolUseLimitReachedErrorObject
 * @phpstan-import-type ManagedAgentsCompactionLimitReachedErrorObjectShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsCompactionLimitReachedErrorObject
 * @phpstan-import-type ManagedAgentsRepositoryAuthenticationErrorObjectShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsRepositoryAuthenticationErrorObject
 * @phpstan-import-type ManagedAgentsRepositoryForbiddenErrorObjectShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsRepositoryForbiddenErrorObject
 * @phpstan-import-type ManagedAgentsRepositoryNotFoundErrorObjectShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsRepositoryNotFoundErrorObject
 * @phpstan-import-type ManagedAgentsRepositoryCheckoutErrorObjectShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsRepositoryCheckoutErrorObject
 * @phpstan-import-type ManagedAgentsRepositoryCloneErrorObjectShape from \Anthropic\Beta\Sessions\Events\ManagedAgentsRepositoryCloneErrorObject
 *
 * @phpstan-type ErrorVariants = ManagedAgentsUnknownErrorObject|ManagedAgentsModelOverloadedErrorObject|ManagedAgentsModelRateLimitedErrorObject|ManagedAgentsModelRequestFailedErrorObject|ManagedAgentsMCPConnectionFailedErrorObject|ManagedAgentsMCPAuthenticationFailedErrorObject|ManagedAgentsBillingErrorObject|ManagedAgentsCredentialHostUnreachableErrorObject|ManagedAgentsToolUseLimitReachedErrorObject|ManagedAgentsCompactionLimitReachedErrorObject|ManagedAgentsRepositoryAuthenticationErrorObject|ManagedAgentsRepositoryForbiddenErrorObject|ManagedAgentsRepositoryNotFoundErrorObject|ManagedAgentsRepositoryCheckoutErrorObject|ManagedAgentsRepositoryCloneErrorObject
 * @phpstan-type ErrorShape = ErrorVariants|ManagedAgentsUnknownErrorObjectShape|ManagedAgentsModelOverloadedErrorObjectShape|ManagedAgentsModelRateLimitedErrorObjectShape|ManagedAgentsModelRequestFailedErrorObjectShape|ManagedAgentsMCPConnectionFailedErrorObjectShape|ManagedAgentsMCPAuthenticationFailedErrorObjectShape|ManagedAgentsBillingErrorObjectShape|ManagedAgentsCredentialHostUnreachableErrorObjectShape|ManagedAgentsToolUseLimitReachedErrorObjectShape|ManagedAgentsCompactionLimitReachedErrorObjectShape|ManagedAgentsRepositoryAuthenticationErrorObjectShape|ManagedAgentsRepositoryForbiddenErrorObjectShape|ManagedAgentsRepositoryNotFoundErrorObjectShape|ManagedAgentsRepositoryCheckoutErrorObjectShape|ManagedAgentsRepositoryCloneErrorObjectShape
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
            'unknown_error' => ManagedAgentsUnknownErrorObject::class,
            'model_overloaded_error' => ManagedAgentsModelOverloadedErrorObject::class,
            'model_rate_limited_error' => ManagedAgentsModelRateLimitedErrorObject::class,
            'model_request_failed_error' => ManagedAgentsModelRequestFailedErrorObject::class,
            'mcp_connection_failed_error' => ManagedAgentsMCPConnectionFailedErrorObject::class,
            'mcp_authentication_failed_error' => ManagedAgentsMCPAuthenticationFailedErrorObject::class,
            'billing_error' => ManagedAgentsBillingErrorObject::class,
            'credential_host_unreachable_error' => ManagedAgentsCredentialHostUnreachableErrorObject::class,
            'tool_use_limit_reached_error' => ManagedAgentsToolUseLimitReachedErrorObject::class,
            'compaction_limit_reached_error' => ManagedAgentsCompactionLimitReachedErrorObject::class,
            'repository_authentication_error' => ManagedAgentsRepositoryAuthenticationErrorObject::class,
            'repository_forbidden_error' => ManagedAgentsRepositoryForbiddenErrorObject::class,
            'repository_not_found_error' => ManagedAgentsRepositoryNotFoundErrorObject::class,
            'repository_checkout_error' => ManagedAgentsRepositoryCheckoutErrorObject::class,
            'repository_clone_error' => ManagedAgentsRepositoryCloneErrorObject::class,
        ];
    }
}
