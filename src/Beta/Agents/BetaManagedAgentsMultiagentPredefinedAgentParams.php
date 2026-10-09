<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents;

use Anthropic\Beta\Sessions\BetaManagedAgentsAgentParams;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * One agent in a `predefined_agents` list. It is an agent ID string, an `agent` reference with an optional `version`, or `self` for the agent that owns this configuration.
 *
 * @phpstan-import-type BetaManagedAgentsAgentParamsShape from \Anthropic\Beta\Sessions\BetaManagedAgentsAgentParams
 * @phpstan-import-type BetaManagedAgentsMultiagentSelfParamsShape from \Anthropic\Beta\Agents\BetaManagedAgentsMultiagentSelfParams
 *
 * @phpstan-type BetaManagedAgentsMultiagentPredefinedAgentParamsVariants = string|BetaManagedAgentsAgentParams|BetaManagedAgentsMultiagentSelfParams
 * @phpstan-type BetaManagedAgentsMultiagentPredefinedAgentParamsShape = BetaManagedAgentsMultiagentPredefinedAgentParamsVariants|BetaManagedAgentsAgentParamsShape|BetaManagedAgentsMultiagentSelfParamsShape
 */
final class BetaManagedAgentsMultiagentPredefinedAgentParams implements ConverterSource
{
    use SdkUnion;

    /**
     * @return list<string|Converter|ConverterSource>|array<string,string|Converter|ConverterSource>
     */
    public static function variants(): array
    {
        return [
            BetaManagedAgentsAgentParams::class,
            BetaManagedAgentsMultiagentSelfParams::class,
            'string',
        ];
    }
}
