<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents\BetaManagedAgentsAgent;

use Anthropic\Beta\Agents\BetaManagedAgentsAgentToolset20260401;
use Anthropic\Beta\Agents\BetaManagedAgentsCustomTool;
use Anthropic\Beta\Agents\BetaManagedAgentsMCPToolset;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Union type for tool configurations returned in API responses.
 *
 * @phpstan-import-type BetaManagedAgentsAgentToolset20260401Shape from \Anthropic\Beta\Agents\BetaManagedAgentsAgentToolset20260401
 * @phpstan-import-type BetaManagedAgentsMCPToolsetShape from \Anthropic\Beta\Agents\BetaManagedAgentsMCPToolset
 * @phpstan-import-type BetaManagedAgentsCustomToolShape from \Anthropic\Beta\Agents\BetaManagedAgentsCustomTool
 *
 * @phpstan-type ToolVariants = BetaManagedAgentsAgentToolset20260401|BetaManagedAgentsMCPToolset|BetaManagedAgentsCustomTool
 * @phpstan-type ToolShape = ToolVariants|BetaManagedAgentsAgentToolset20260401Shape|BetaManagedAgentsMCPToolsetShape|BetaManagedAgentsCustomToolShape
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
            'agent_toolset_20260401' => BetaManagedAgentsAgentToolset20260401::class,
            'mcp_toolset' => BetaManagedAgentsMCPToolset::class,
            'custom' => BetaManagedAgentsCustomTool::class,
        ];
    }
}
