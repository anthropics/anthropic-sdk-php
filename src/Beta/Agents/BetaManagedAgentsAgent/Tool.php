<?php

declare(strict_types=1);

namespace Anthropic\Beta\Agents\BetaManagedAgentsAgent;

use Anthropic\Beta\Agents\BetaManagedAgentsAgent\Tool\Type;
use Anthropic\Beta\Agents\BetaManagedAgentsAgentToolset20260401;
use Anthropic\Beta\Agents\BetaManagedAgentsAgentToolsetDefaultConfig;
use Anthropic\Beta\Agents\BetaManagedAgentsCustomTool;
use Anthropic\Beta\Agents\BetaManagedAgentsCustomToolInputSchema;
use Anthropic\Beta\Agents\BetaManagedAgentsMCPToolConfig;
use Anthropic\Beta\Agents\BetaManagedAgentsMCPToolset;
use Anthropic\Beta\Agents\BetaManagedAgentsMCPToolsetDefaultConfig;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Union type for tool configurations returned in API responses.
 *
 * @phpstan-import-type BetaManagedAgentsAgentToolset20260401Shape from \Anthropic\Beta\Agents\BetaManagedAgentsAgentToolset20260401
 * @phpstan-import-type BetaManagedAgentsMCPToolsetShape from \Anthropic\Beta\Agents\BetaManagedAgentsMCPToolset
 * @phpstan-import-type BetaManagedAgentsCustomToolShape from \Anthropic\Beta\Agents\BetaManagedAgentsCustomTool
 * @phpstan-import-type BetaManagedAgentsAgentToolConfigShape from \Anthropic\Beta\Agents\BetaManagedAgentsAgentToolConfig
 * @phpstan-import-type BetaManagedAgentsMCPToolConfigShape from \Anthropic\Beta\Agents\BetaManagedAgentsMCPToolConfig
 * @phpstan-import-type BetaManagedAgentsAgentToolsetDefaultConfigShape from \Anthropic\Beta\Agents\BetaManagedAgentsAgentToolsetDefaultConfig
 * @phpstan-import-type BetaManagedAgentsMCPToolsetDefaultConfigShape from \Anthropic\Beta\Agents\BetaManagedAgentsMCPToolsetDefaultConfig
 * @phpstan-import-type BetaManagedAgentsCustomToolInputSchemaShape from \Anthropic\Beta\Agents\BetaManagedAgentsCustomToolInputSchema
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

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @param ($type is Type::AGENT_TOOLSET_20260401|'agent_toolset_20260401' ? list<BetaManagedAgentsAgentToolConfigShape>|null : list<BetaManagedAgentsMCPToolConfig|BetaManagedAgentsMCPToolConfigShape>|null) $configs
     * @param ($type is Type::AGENT_TOOLSET_20260401|'agent_toolset_20260401' ? BetaManagedAgentsAgentToolsetDefaultConfig|BetaManagedAgentsAgentToolsetDefaultConfigShape|null : BetaManagedAgentsMCPToolsetDefaultConfig|BetaManagedAgentsMCPToolsetDefaultConfigShape|null) $defaultConfig
     * @param BetaManagedAgentsCustomToolInputSchema|BetaManagedAgentsCustomToolInputSchemaShape|null $inputSchema
     *
     * @return ($type is Type::AGENT_TOOLSET_20260401|'agent_toolset_20260401' ? BetaManagedAgentsAgentToolset20260401 : ($type is Type::MCP_TOOLSET|'mcp_toolset' ? BetaManagedAgentsMCPToolset : ($type is Type::CUSTOM|'custom' ? BetaManagedAgentsCustomTool : BetaManagedAgentsAgentToolset20260401|BetaManagedAgentsMCPToolset|BetaManagedAgentsCustomTool)))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        ?array $configs = null,
        BetaManagedAgentsAgentToolsetDefaultConfig|array|BetaManagedAgentsMCPToolsetDefaultConfig|null $defaultConfig = null,
        ?string $mcpServerName = null,
        ?string $description = null,
        BetaManagedAgentsCustomToolInputSchema|array|null $inputSchema = null,
        ?string $name = null,
    ): BetaManagedAgentsAgentToolset20260401|BetaManagedAgentsMCPToolset|BetaManagedAgentsCustomTool {
        return match ($type) {
            Type::AGENT_TOOLSET_20260401, 'agent_toolset_20260401' => BetaManagedAgentsAgentToolset20260401::with(
                type: 'agent_toolset_20260401',
                configs: $configs ?? throw new \ArgumentCountError('$configs is required'),
                defaultConfig: $defaultConfig ?? throw new \ArgumentCountError('$defaultConfig is required'),
            ),
            Type::MCP_TOOLSET, 'mcp_toolset' => BetaManagedAgentsMCPToolset::with(
                type: 'mcp_toolset',
                // @phpstan-ignore argument.type
                configs: $configs ?? throw new \ArgumentCountError('$configs is required'),
                // @phpstan-ignore argument.type
                defaultConfig: $defaultConfig ?? throw new \ArgumentCountError('$defaultConfig is required'),
                mcpServerName: $mcpServerName ?? throw new \ArgumentCountError('$mcpServerName is required'),
            ),
            Type::CUSTOM, 'custom' => BetaManagedAgentsCustomTool::with(
                type: 'custom',
                description: $description ?? throw new \ArgumentCountError('$description is required'),
                inputSchema: $inputSchema ?? throw new \ArgumentCountError('$inputSchema is required'),
                name: $name ?? throw new \ArgumentCountError('$name is required'),
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
