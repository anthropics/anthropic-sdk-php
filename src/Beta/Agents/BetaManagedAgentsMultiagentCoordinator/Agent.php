<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents\BetaManagedAgentsMultiagentCoordinator;

use Anthropic\Beta\Agents\BetaManagedAgentsAdvisor;
use Anthropic\Beta\Agents\BetaManagedAgentsAgentReference;
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
}
