<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents;

use Anthropic\Beta\Agents\BetaManagedAgentsMultiagentWorkflowsParams\Type;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Whether the agent can start workflow runs.
 *
 * @phpstan-import-type BetaManagedAgentsMultiagentWorkflowsEnabledParamsShape from \Anthropic\Beta\Agents\BetaManagedAgentsMultiagentWorkflowsEnabledParams
 * @phpstan-import-type BetaManagedAgentsMultiagentWorkflowsDisabledParamsShape from \Anthropic\Beta\Agents\BetaManagedAgentsMultiagentWorkflowsDisabledParams
 * @phpstan-import-type BetaManagedAgentsMultiagentInlineAgentsParamsShape from \Anthropic\Beta\Agents\BetaManagedAgentsMultiagentInlineAgentsParams
 * @phpstan-import-type BetaManagedAgentsMultiagentPredefinedAgentParamsShape from \Anthropic\Beta\Agents\BetaManagedAgentsMultiagentPredefinedAgentParams
 *
 * @phpstan-type BetaManagedAgentsMultiagentWorkflowsParamsVariants = BetaManagedAgentsMultiagentWorkflowsEnabledParams|BetaManagedAgentsMultiagentWorkflowsDisabledParams
 * @phpstan-type BetaManagedAgentsMultiagentWorkflowsParamsShape = BetaManagedAgentsMultiagentWorkflowsParamsVariants|BetaManagedAgentsMultiagentWorkflowsEnabledParamsShape|BetaManagedAgentsMultiagentWorkflowsDisabledParamsShape
 */
final class BetaManagedAgentsMultiagentWorkflowsParams implements ConverterSource
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
            'enabled' => BetaManagedAgentsMultiagentWorkflowsEnabledParams::class,
            'disabled' => BetaManagedAgentsMultiagentWorkflowsDisabledParams::class,
        ];
    }

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @param BetaManagedAgentsMultiagentInlineAgentsParamsShape|null $inlineAgents
     * @param list<BetaManagedAgentsMultiagentPredefinedAgentParamsShape>|null $predefinedAgents
     *
     * @return ($type is Type::ENABLED|'enabled' ? BetaManagedAgentsMultiagentWorkflowsEnabledParams : ($type is Type::DISABLED|'disabled' ? BetaManagedAgentsMultiagentWorkflowsDisabledParams : BetaManagedAgentsMultiagentWorkflowsEnabledParams|BetaManagedAgentsMultiagentWorkflowsDisabledParams))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        BetaManagedAgentsMultiagentInlineAgentsEnabledParams|array|BetaManagedAgentsMultiagentInlineAgentsDisabledParams|null $inlineAgents = null,
        ?array $predefinedAgents = null,
    ): BetaManagedAgentsMultiagentWorkflowsEnabledParams|BetaManagedAgentsMultiagentWorkflowsDisabledParams {
        return match ($type) {
            Type::ENABLED, 'enabled' => BetaManagedAgentsMultiagentWorkflowsEnabledParams::with(
                inlineAgents: $inlineAgents,
                predefinedAgents: $predefinedAgents
            ),
            Type::DISABLED, 'disabled' => BetaManagedAgentsMultiagentWorkflowsDisabledParams::with(
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
