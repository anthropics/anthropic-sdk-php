<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions;

use Anthropic\Beta\Agents\BetaManagedAgentsMultiagent20261001Params;
use Anthropic\Beta\Agents\BetaManagedAgentsMultiagentAdvisorDisabledParams;
use Anthropic\Beta\Agents\BetaManagedAgentsMultiagentAdvisorEnabledParams;
use Anthropic\Beta\Agents\BetaManagedAgentsMultiagentCoordinatorParams;
use Anthropic\Beta\Agents\BetaManagedAgentsMultiagentSubagentsDisabledParams;
use Anthropic\Beta\Agents\BetaManagedAgentsMultiagentSubagentsEnabledParams;
use Anthropic\Beta\Agents\BetaManagedAgentsMultiagentWorkflowsDisabledParams;
use Anthropic\Beta\Agents\BetaManagedAgentsMultiagentWorkflowsEnabledParams;
use Anthropic\Beta\Sessions\BetaManagedAgentsMultiagentParams\Type;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Multiagent orchestration configuration.
 *
 * @phpstan-import-type BetaManagedAgentsMultiagentCoordinatorParamsShape from \Anthropic\Beta\Agents\BetaManagedAgentsMultiagentCoordinatorParams
 * @phpstan-import-type BetaManagedAgentsMultiagent20261001ParamsShape from \Anthropic\Beta\Agents\BetaManagedAgentsMultiagent20261001Params
 * @phpstan-import-type BetaManagedAgentsMultiagentRosterEntryParamsShape from \Anthropic\Beta\Sessions\BetaManagedAgentsMultiagentRosterEntryParams
 * @phpstan-import-type BetaManagedAgentsMultiagentAdvisorParamsShape from \Anthropic\Beta\Agents\BetaManagedAgentsMultiagentAdvisorParams
 * @phpstan-import-type BetaManagedAgentsMultiagentSubagentsParamsShape from \Anthropic\Beta\Agents\BetaManagedAgentsMultiagentSubagentsParams
 * @phpstan-import-type BetaManagedAgentsMultiagentWorkflowsParamsShape from \Anthropic\Beta\Agents\BetaManagedAgentsMultiagentWorkflowsParams
 *
 * @phpstan-type BetaManagedAgentsMultiagentParamsVariants = BetaManagedAgentsMultiagentCoordinatorParams|BetaManagedAgentsMultiagent20261001Params
 * @phpstan-type BetaManagedAgentsMultiagentParamsShape = BetaManagedAgentsMultiagentParamsVariants|BetaManagedAgentsMultiagentCoordinatorParamsShape|BetaManagedAgentsMultiagent20261001ParamsShape
 */
final class BetaManagedAgentsMultiagentParams implements ConverterSource
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
            'coordinator' => BetaManagedAgentsMultiagentCoordinatorParams::class,
            'multiagent_20261001' => BetaManagedAgentsMultiagent20261001Params::class,
        ];
    }

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @param list<BetaManagedAgentsMultiagentRosterEntryParamsShape>|null $agents
     * @param BetaManagedAgentsMultiagentAdvisorParamsShape|null $advisor
     * @param BetaManagedAgentsMultiagentSubagentsParamsShape|null $subagents
     * @param BetaManagedAgentsMultiagentWorkflowsParamsShape|null $workflows
     *
     * @return ($type is Type::COORDINATOR|'coordinator' ? BetaManagedAgentsMultiagentCoordinatorParams : ($type is Type::MULTIAGENT_20261001|'multiagent_20261001' ? BetaManagedAgentsMultiagent20261001Params : BetaManagedAgentsMultiagentCoordinatorParams|BetaManagedAgentsMultiagent20261001Params))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        ?array $agents = null,
        BetaManagedAgentsMultiagentAdvisorEnabledParams|array|BetaManagedAgentsMultiagentAdvisorDisabledParams|null $advisor = null,
        BetaManagedAgentsMultiagentSubagentsEnabledParams|array|BetaManagedAgentsMultiagentSubagentsDisabledParams|null $subagents = null,
        BetaManagedAgentsMultiagentWorkflowsEnabledParams|array|BetaManagedAgentsMultiagentWorkflowsDisabledParams|null $workflows = null,
    ): BetaManagedAgentsMultiagentCoordinatorParams|BetaManagedAgentsMultiagent20261001Params {
        return match ($type) {
            Type::COORDINATOR, 'coordinator' => BetaManagedAgentsMultiagentCoordinatorParams::with(
                type: 'coordinator',
                agents: $agents ?? throw new \ArgumentCountError('$agents is required'),
            ),
            Type::MULTIAGENT_20261001, 'multiagent_20261001' => BetaManagedAgentsMultiagent20261001Params::with(
                advisor: $advisor,
                subagents: $subagents,
                workflows: $workflows
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
