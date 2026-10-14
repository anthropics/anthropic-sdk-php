<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Execution principal for runs of this agent as returned in API responses.
 *
 * @phpstan-import-type BetaManagedAgentsAWSRoleExecutionIdentityShape from \Anthropic\Beta\Agents\BetaManagedAgentsAWSRoleExecutionIdentity
 * @phpstan-import-type BetaManagedAgentsServiceAccountExecutionIdentityShape from \Anthropic\Beta\Agents\BetaManagedAgentsServiceAccountExecutionIdentity
 *
 * @phpstan-type BetaManagedAgentsExecutionIdentityVariants = BetaManagedAgentsAWSRoleExecutionIdentity|BetaManagedAgentsServiceAccountExecutionIdentity
 * @phpstan-type BetaManagedAgentsExecutionIdentityShape = BetaManagedAgentsExecutionIdentityVariants|BetaManagedAgentsAWSRoleExecutionIdentityShape|BetaManagedAgentsServiceAccountExecutionIdentityShape
 */
final class BetaManagedAgentsExecutionIdentity implements ConverterSource
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
            'aws_role' => BetaManagedAgentsAWSRoleExecutionIdentity::class,
            'service_account' => BetaManagedAgentsServiceAccountExecutionIdentity::class,
        ];
    }
}
