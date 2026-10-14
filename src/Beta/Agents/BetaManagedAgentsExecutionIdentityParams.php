<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents;

use Anthropic\Beta\Agents\BetaManagedAgentsExecutionIdentityParams\Type;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Execution principal for runs of this agent: `service_account` (the default) or `aws_role`.
 *
 * @phpstan-import-type BetaManagedAgentsAWSRoleExecutionIdentityParamsShape from \Anthropic\Beta\Agents\BetaManagedAgentsAWSRoleExecutionIdentityParams
 * @phpstan-import-type BetaManagedAgentsServiceAccountExecutionIdentityParamsShape from \Anthropic\Beta\Agents\BetaManagedAgentsServiceAccountExecutionIdentityParams
 *
 * @phpstan-type BetaManagedAgentsExecutionIdentityParamsVariants = BetaManagedAgentsAWSRoleExecutionIdentityParams|BetaManagedAgentsServiceAccountExecutionIdentityParams
 * @phpstan-type BetaManagedAgentsExecutionIdentityParamsShape = BetaManagedAgentsExecutionIdentityParamsVariants|BetaManagedAgentsAWSRoleExecutionIdentityParamsShape|BetaManagedAgentsServiceAccountExecutionIdentityParamsShape
 */
final class BetaManagedAgentsExecutionIdentityParams implements ConverterSource
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
            'aws_role' => BetaManagedAgentsAWSRoleExecutionIdentityParams::class,
            'service_account' => BetaManagedAgentsServiceAccountExecutionIdentityParams::class,
        ];
    }

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @return ($type is Type::AWS_ROLE|'aws_role' ? BetaManagedAgentsAWSRoleExecutionIdentityParams : ($type is Type::SERVICE_ACCOUNT|'service_account' ? BetaManagedAgentsServiceAccountExecutionIdentityParams : BetaManagedAgentsAWSRoleExecutionIdentityParams|BetaManagedAgentsServiceAccountExecutionIdentityParams))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        ?string $roleARN = null
    ): BetaManagedAgentsAWSRoleExecutionIdentityParams|BetaManagedAgentsServiceAccountExecutionIdentityParams {
        return match ($type) {
            Type::AWS_ROLE, 'aws_role' => BetaManagedAgentsAWSRoleExecutionIdentityParams::with(
                roleARN: $roleARN ?? throw new \ArgumentCountError('$roleARN is required'),
            ),
            Type::SERVICE_ACCOUNT, 'service_account' => BetaManagedAgentsServiceAccountExecutionIdentityParams::with(
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
