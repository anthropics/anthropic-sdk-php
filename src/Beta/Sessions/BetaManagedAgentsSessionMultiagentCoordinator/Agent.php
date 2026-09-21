<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\BetaManagedAgentsSessionMultiagentCoordinator;

use Anthropic\Beta\Agents\BetaManagedAgentsAdvisor;
use Anthropic\Beta\Agents\BetaManagedAgentsMCPServerURLDefinition;
use Anthropic\Beta\Agents\BetaManagedAgentsModelConfig;
use Anthropic\Beta\Agents\BetaManagedAgentsSessionThreadAgent;
use Anthropic\Beta\Sessions\BetaManagedAgentsSessionMultiagentCoordinator\Agent\Type;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * A session-resolved multiagent roster entry.
 *
 * @phpstan-import-type BetaManagedAgentsSessionThreadAgentShape from \Anthropic\Beta\Agents\BetaManagedAgentsSessionThreadAgent
 * @phpstan-import-type BetaManagedAgentsAdvisorShape from \Anthropic\Beta\Agents\BetaManagedAgentsAdvisor
 * @phpstan-import-type BetaManagedAgentsModelConfigShape from \Anthropic\Beta\Agents\BetaManagedAgentsModelConfig
 * @phpstan-import-type BetaManagedAgentsMCPServerURLDefinitionShape from \Anthropic\Beta\Agents\BetaManagedAgentsMCPServerURLDefinition
 * @phpstan-import-type SkillShape from \Anthropic\Beta\Agents\BetaManagedAgentsSessionThreadAgent\Skill
 * @phpstan-import-type ToolShape from \Anthropic\Beta\Agents\BetaManagedAgentsSessionThreadAgent\Tool
 *
 * @phpstan-type AgentVariants = BetaManagedAgentsSessionThreadAgent|BetaManagedAgentsAdvisor
 * @phpstan-type AgentShape = AgentVariants|BetaManagedAgentsSessionThreadAgentShape|BetaManagedAgentsAdvisorShape
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
            'agent' => BetaManagedAgentsSessionThreadAgent::class,
            'advisor' => BetaManagedAgentsAdvisor::class,
        ];
    }

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @param ($type is Type::AGENT|'agent' ? BetaManagedAgentsModelConfig|BetaManagedAgentsModelConfigShape : string) $model
     * @param list<BetaManagedAgentsMCPServerURLDefinition|BetaManagedAgentsMCPServerURLDefinitionShape>|null $mcpServers
     * @param list<SkillShape>|null $skills
     * @param list<ToolShape>|null $tools
     *
     * @return ($type is Type::AGENT|'agent' ? BetaManagedAgentsSessionThreadAgent : ($type is Type::ADVISOR|'advisor' ? BetaManagedAgentsAdvisor : BetaManagedAgentsSessionThreadAgent|BetaManagedAgentsAdvisor))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        string|BetaManagedAgentsModelConfig|array $model,
        ?string $id = null,
        ?string $description = null,
        ?array $mcpServers = null,
        ?string $name = null,
        ?array $skills = null,
        ?string $system = null,
        ?array $tools = null,
        ?int $version = null,
    ): BetaManagedAgentsSessionThreadAgent|BetaManagedAgentsAdvisor {
        return match ($type) {
            Type::AGENT, 'agent' => BetaManagedAgentsSessionThreadAgent::with(
                type: 'agent',
                id: $id ?? throw new \ArgumentCountError('$id is required'),
                description: $description,
                mcpServers: $mcpServers ?? throw new \ArgumentCountError('$mcpServers is required'),
                model: $model,
                name: $name ?? throw new \ArgumentCountError('$name is required'),
                skills: $skills ?? throw new \ArgumentCountError('$skills is required'),
                system: $system,
                tools: $tools ?? throw new \ArgumentCountError('$tools is required'),
                version: $version ?? throw new \ArgumentCountError('$version is required'),
            ),
            Type::ADVISOR, 'advisor' => BetaManagedAgentsAdvisor::with(
                type: 'advisor',
                // @phpstan-ignore argument.type
                model: $model,
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
