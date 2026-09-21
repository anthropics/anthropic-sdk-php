<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents\BetaManagedAgentsMultiagentCoordinator;

use Anthropic\Beta\Agents\BetaManagedAgentsAdvisor;
use Anthropic\Beta\Agents\BetaManagedAgentsAgentReference;
use Anthropic\Beta\Agents\BetaManagedAgentsMultiagentCoordinator\Agent\Type;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * A resolved multiagent roster entry.
 *
 * @phpstan-import-type BetaManagedAgentsAgentReferenceShape from \Anthropic\Beta\Agents\BetaManagedAgentsAgentReference
 * @phpstan-import-type BetaManagedAgentsAdvisorShape from \Anthropic\Beta\Agents\BetaManagedAgentsAdvisor
 *
 * @phpstan-type AgentVariants = BetaManagedAgentsAgentReference|BetaManagedAgentsAdvisor
 * @phpstan-type AgentShape = AgentVariants|BetaManagedAgentsAgentReferenceShape|BetaManagedAgentsAdvisorShape
 */
final class Agent implements ConverterSource
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
            'agent' => BetaManagedAgentsAgentReference::class,
            'advisor' => BetaManagedAgentsAdvisor::class,
        ];
    }

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @return ($type is Type::AGENT|'agent' ? BetaManagedAgentsAgentReference : ($type is Type::ADVISOR|'advisor' ? BetaManagedAgentsAdvisor : BetaManagedAgentsAgentReference|BetaManagedAgentsAdvisor))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        ?string $id = null,
        ?int $version = null,
        ?string $model = null,
    ): BetaManagedAgentsAgentReference|BetaManagedAgentsAdvisor {
        return match ($type) {
            Type::AGENT, 'agent' => BetaManagedAgentsAgentReference::with(
                type: 'agent',
                id: $id ?? throw new \ArgumentCountError('$id is required'),
                version: $version ?? throw new \ArgumentCountError('$version is required'),
            ),
            Type::ADVISOR, 'advisor' => BetaManagedAgentsAdvisor::with(
                type: 'advisor',
                model: $model ?? throw new \ArgumentCountError('$model is required'),
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
