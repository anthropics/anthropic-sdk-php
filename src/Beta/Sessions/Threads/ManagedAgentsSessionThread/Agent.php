<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Threads\ManagedAgentsSessionThread;

use Anthropic\Beta\Agents\BetaManagedAgentsAdvisor;
use Anthropic\Beta\Agents\BetaManagedAgentsSessionThreadAgent;
use Anthropic\Beta\Sessions\Threads\ManagedAgentsInlineAgent;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Resolved agent definition for this thread. Snapshot of the agent at thread creation time.
 *
 * @phpstan-import-type BetaManagedAgentsSessionThreadAgentShape from \Anthropic\Beta\Agents\BetaManagedAgentsSessionThreadAgent
 * @phpstan-import-type BetaManagedAgentsAdvisorShape from \Anthropic\Beta\Agents\BetaManagedAgentsAdvisor
 * @phpstan-import-type ManagedAgentsInlineAgentShape from \Anthropic\Beta\Sessions\Threads\ManagedAgentsInlineAgent
 *
 * @phpstan-type AgentVariants = BetaManagedAgentsSessionThreadAgent|BetaManagedAgentsAdvisor|ManagedAgentsInlineAgent
 * @phpstan-type AgentShape = AgentVariants|BetaManagedAgentsSessionThreadAgentShape|BetaManagedAgentsAdvisorShape|ManagedAgentsInlineAgentShape
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
            'inline' => ManagedAgentsInlineAgent::class,
        ];
    }
}
