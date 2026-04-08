<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents\AgentUpdateParams;

use Anthropic\Beta\Agents\BetaManagedAgentsAgentToolset20260401Params;
use Anthropic\Beta\Agents\BetaManagedAgentsCustomToolParams;
use Anthropic\Beta\Agents\BetaManagedAgentsMCPToolsetParams;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Union type for tool configurations in the tools array.
 *
 * @phpstan-import-type BetaManagedAgentsAgentToolset20260401ParamsShape from \Anthropic\Beta\Agents\BetaManagedAgentsAgentToolset20260401Params
 * @phpstan-import-type BetaManagedAgentsMCPToolsetParamsShape from \Anthropic\Beta\Agents\BetaManagedAgentsMCPToolsetParams
 * @phpstan-import-type BetaManagedAgentsCustomToolParamsShape from \Anthropic\Beta\Agents\BetaManagedAgentsCustomToolParams
 *
 * @phpstan-type ToolVariants = BetaManagedAgentsAgentToolset20260401Params|BetaManagedAgentsMCPToolsetParams|BetaManagedAgentsCustomToolParams
 * @phpstan-type ToolShape = ToolVariants|BetaManagedAgentsAgentToolset20260401ParamsShape|BetaManagedAgentsMCPToolsetParamsShape|BetaManagedAgentsCustomToolParamsShape
 */
final class Tool implements ConverterSource
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
            'agent_toolset_20260401' => BetaManagedAgentsAgentToolset20260401Params::class,
            'mcp_toolset' => BetaManagedAgentsMCPToolsetParams::class,
            'custom' => BetaManagedAgentsCustomToolParams::class,
        ];
    }
}
