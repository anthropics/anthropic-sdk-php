<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents;

use Anthropic\Beta\Agents\BetaManagedAgentsMultiagentInlineAgentsParams\Type;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Whether the agent can define inline agents. The agent defines an inline agent itself, in a workflow run's plan or when it spawns a session thread, and the inline agent is not saved.
 *
 * @phpstan-import-type BetaManagedAgentsMultiagentInlineAgentsEnabledParamsShape from \Anthropic\Beta\Agents\BetaManagedAgentsMultiagentInlineAgentsEnabledParams
 * @phpstan-import-type BetaManagedAgentsMultiagentInlineAgentsDisabledParamsShape from \Anthropic\Beta\Agents\BetaManagedAgentsMultiagentInlineAgentsDisabledParams
 *
 * @phpstan-type BetaManagedAgentsMultiagentInlineAgentsParamsVariants = BetaManagedAgentsMultiagentInlineAgentsEnabledParams|BetaManagedAgentsMultiagentInlineAgentsDisabledParams
 * @phpstan-type BetaManagedAgentsMultiagentInlineAgentsParamsShape = BetaManagedAgentsMultiagentInlineAgentsParamsVariants|BetaManagedAgentsMultiagentInlineAgentsEnabledParamsShape|BetaManagedAgentsMultiagentInlineAgentsDisabledParamsShape
 */
final class BetaManagedAgentsMultiagentInlineAgentsParams implements ConverterSource
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
            'enabled' => BetaManagedAgentsMultiagentInlineAgentsEnabledParams::class,
            'disabled' => BetaManagedAgentsMultiagentInlineAgentsDisabledParams::class,
        ];
    }

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @return ($type is Type::ENABLED|'enabled' ? BetaManagedAgentsMultiagentInlineAgentsEnabledParams : ($type is Type::DISABLED|'disabled' ? BetaManagedAgentsMultiagentInlineAgentsDisabledParams : BetaManagedAgentsMultiagentInlineAgentsEnabledParams|BetaManagedAgentsMultiagentInlineAgentsDisabledParams))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type
    ): BetaManagedAgentsMultiagentInlineAgentsEnabledParams|BetaManagedAgentsMultiagentInlineAgentsDisabledParams {
        return match ($type) {
            Type::ENABLED, 'enabled' => BetaManagedAgentsMultiagentInlineAgentsEnabledParams::with(
            ),
            Type::DISABLED, 'disabled' => BetaManagedAgentsMultiagentInlineAgentsDisabledParams::with(
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
