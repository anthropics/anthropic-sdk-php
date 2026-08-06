<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\Threads\ManagedAgentsSessionThread;

use Anthropic\Beta\Agents\BetaManagedAgentsAdvisor;
use Anthropic\Beta\Agents\BetaManagedAgentsSessionThreadAgent;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * A session-resolved multiagent roster entry.
 *
 * @phpstan-import-type BetaManagedAgentsSessionThreadAgentShape from \Anthropic\Beta\Agents\BetaManagedAgentsSessionThreadAgent
 * @phpstan-import-type BetaManagedAgentsAdvisorShape from \Anthropic\Beta\Agents\BetaManagedAgentsAdvisor
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
}
