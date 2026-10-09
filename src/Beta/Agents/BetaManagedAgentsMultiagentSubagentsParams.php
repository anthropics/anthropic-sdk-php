<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents;

use Anthropic\Beta\Agents\BetaManagedAgentsMultiagentSubagentsParams\Type;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Whether the agent can spawn session threads.
 *
 * @phpstan-import-type BetaManagedAgentsMultiagentSubagentsEnabledParamsShape from \Anthropic\Beta\Agents\BetaManagedAgentsMultiagentSubagentsEnabledParams
 * @phpstan-import-type BetaManagedAgentsMultiagentSubagentsDisabledParamsShape from \Anthropic\Beta\Agents\BetaManagedAgentsMultiagentSubagentsDisabledParams
 * @phpstan-import-type BetaManagedAgentsMultiagentInlineAgentsParamsShape from \Anthropic\Beta\Agents\BetaManagedAgentsMultiagentInlineAgentsParams
 * @phpstan-import-type BetaManagedAgentsMultiagentPredefinedAgentParamsShape from \Anthropic\Beta\Agents\BetaManagedAgentsMultiagentPredefinedAgentParams
 *
 * @phpstan-type BetaManagedAgentsMultiagentSubagentsParamsVariants = BetaManagedAgentsMultiagentSubagentsEnabledParams|BetaManagedAgentsMultiagentSubagentsDisabledParams
 * @phpstan-type BetaManagedAgentsMultiagentSubagentsParamsShape = BetaManagedAgentsMultiagentSubagentsParamsVariants|BetaManagedAgentsMultiagentSubagentsEnabledParamsShape|BetaManagedAgentsMultiagentSubagentsDisabledParamsShape
 */
final class BetaManagedAgentsMultiagentSubagentsParams implements ConverterSource
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
            'enabled' => BetaManagedAgentsMultiagentSubagentsEnabledParams::class,
            'disabled' => BetaManagedAgentsMultiagentSubagentsDisabledParams::class,
        ];
    }

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @param BetaManagedAgentsMultiagentInlineAgentsParamsShape|null $inlineAgents
     * @param list<BetaManagedAgentsMultiagentPredefinedAgentParamsShape>|null $predefinedAgents
     *
     * @return ($type is Type::ENABLED|'enabled' ? BetaManagedAgentsMultiagentSubagentsEnabledParams : ($type is Type::DISABLED|'disabled' ? BetaManagedAgentsMultiagentSubagentsDisabledParams : BetaManagedAgentsMultiagentSubagentsEnabledParams|BetaManagedAgentsMultiagentSubagentsDisabledParams))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        BetaManagedAgentsMultiagentInlineAgentsEnabledParams|array|BetaManagedAgentsMultiagentInlineAgentsDisabledParams|null $inlineAgents = null,
        ?array $predefinedAgents = null,
    ): BetaManagedAgentsMultiagentSubagentsEnabledParams|BetaManagedAgentsMultiagentSubagentsDisabledParams {
        return match ($type) {
            Type::ENABLED, 'enabled' => BetaManagedAgentsMultiagentSubagentsEnabledParams::with(
                inlineAgents: $inlineAgents,
                predefinedAgents: $predefinedAgents
            ),
            Type::DISABLED, 'disabled' => BetaManagedAgentsMultiagentSubagentsDisabledParams::with(
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
