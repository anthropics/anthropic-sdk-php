<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents;

use Anthropic\Beta\Agents\BetaManagedAgentsMultiagentAdvisorParams\Type;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Whether the session's primary thread can consult an advisor model.
 *
 * @phpstan-import-type BetaManagedAgentsMultiagentAdvisorEnabledParamsShape from \Anthropic\Beta\Agents\BetaManagedAgentsMultiagentAdvisorEnabledParams
 * @phpstan-import-type BetaManagedAgentsMultiagentAdvisorDisabledParamsShape from \Anthropic\Beta\Agents\BetaManagedAgentsMultiagentAdvisorDisabledParams
 *
 * @phpstan-type BetaManagedAgentsMultiagentAdvisorParamsVariants = BetaManagedAgentsMultiagentAdvisorEnabledParams|BetaManagedAgentsMultiagentAdvisorDisabledParams
 * @phpstan-type BetaManagedAgentsMultiagentAdvisorParamsShape = BetaManagedAgentsMultiagentAdvisorParamsVariants|BetaManagedAgentsMultiagentAdvisorEnabledParamsShape|BetaManagedAgentsMultiagentAdvisorDisabledParamsShape
 */
final class BetaManagedAgentsMultiagentAdvisorParams implements ConverterSource
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
            'enabled' => BetaManagedAgentsMultiagentAdvisorEnabledParams::class,
            'disabled' => BetaManagedAgentsMultiagentAdvisorDisabledParams::class,
        ];
    }

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @return ($type is Type::ENABLED|'enabled' ? BetaManagedAgentsMultiagentAdvisorEnabledParams : ($type is Type::DISABLED|'disabled' ? BetaManagedAgentsMultiagentAdvisorDisabledParams : BetaManagedAgentsMultiagentAdvisorEnabledParams|BetaManagedAgentsMultiagentAdvisorDisabledParams))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        ?string $model = null
    ): BetaManagedAgentsMultiagentAdvisorEnabledParams|BetaManagedAgentsMultiagentAdvisorDisabledParams {
        return match ($type) {
            Type::ENABLED, 'enabled' => BetaManagedAgentsMultiagentAdvisorEnabledParams::with(
                model: $model ?? throw new \ArgumentCountError('$model is required')
            ),
            Type::DISABLED, 'disabled' => BetaManagedAgentsMultiagentAdvisorDisabledParams::with(
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
