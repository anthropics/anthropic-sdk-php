<?php

declare(strict_types=1);

namespace Anthropic\Beta\Sessions\BetaManagedAgentsSessionAgentUpdate;

use Anthropic\Beta\Agents\BetaManagedAgentsAgentToolset20260401Params;
use Anthropic\Beta\Agents\BetaManagedAgentsAgentToolsetDefaultConfigParams;
use Anthropic\Beta\Agents\BetaManagedAgentsCustomToolInputSchema;
use Anthropic\Beta\Agents\BetaManagedAgentsCustomToolParams;
use Anthropic\Beta\Agents\BetaManagedAgentsMCPToolConfigParams;
use Anthropic\Beta\Agents\BetaManagedAgentsMCPToolsetDefaultConfigParams;
use Anthropic\Beta\Agents\BetaManagedAgentsMCPToolsetParams;
use Anthropic\Beta\Sessions\BetaManagedAgentsSessionAgentUpdate\Tool\Type;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Union type for tool configurations in the tools array.
 *
 * @phpstan-import-type BetaManagedAgentsAgentToolset20260401ParamsShape from \Anthropic\Beta\Agents\BetaManagedAgentsAgentToolset20260401Params
 * @phpstan-import-type BetaManagedAgentsMCPToolsetParamsShape from \Anthropic\Beta\Agents\BetaManagedAgentsMCPToolsetParams
 * @phpstan-import-type BetaManagedAgentsCustomToolParamsShape from \Anthropic\Beta\Agents\BetaManagedAgentsCustomToolParams
 * @phpstan-import-type BetaManagedAgentsAgentToolConfigParamsShape from \Anthropic\Beta\Agents\BetaManagedAgentsAgentToolConfigParams
 * @phpstan-import-type BetaManagedAgentsMCPToolConfigParamsShape from \Anthropic\Beta\Agents\BetaManagedAgentsMCPToolConfigParams
 * @phpstan-import-type BetaManagedAgentsAgentToolsetDefaultConfigParamsShape from \Anthropic\Beta\Agents\BetaManagedAgentsAgentToolsetDefaultConfigParams
 * @phpstan-import-type BetaManagedAgentsMCPToolsetDefaultConfigParamsShape from \Anthropic\Beta\Agents\BetaManagedAgentsMCPToolsetDefaultConfigParams
 * @phpstan-import-type BetaManagedAgentsCustomToolInputSchemaShape from \Anthropic\Beta\Agents\BetaManagedAgentsCustomToolInputSchema
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

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @param ($type is Type::AGENT_TOOLSET_20260401|'agent_toolset_20260401' ? list<BetaManagedAgentsAgentToolConfigParamsShape>|null : list<BetaManagedAgentsMCPToolConfigParams|BetaManagedAgentsMCPToolConfigParamsShape>|null) $configs
     * @param ($type is Type::AGENT_TOOLSET_20260401|'agent_toolset_20260401' ? BetaManagedAgentsAgentToolsetDefaultConfigParams|BetaManagedAgentsAgentToolsetDefaultConfigParamsShape|null : BetaManagedAgentsMCPToolsetDefaultConfigParams|BetaManagedAgentsMCPToolsetDefaultConfigParamsShape|null) $defaultConfig
     * @param BetaManagedAgentsCustomToolInputSchema|BetaManagedAgentsCustomToolInputSchemaShape|null $inputSchema
     *
     * @return ($type is Type::AGENT_TOOLSET_20260401|'agent_toolset_20260401' ? BetaManagedAgentsAgentToolset20260401Params : ($type is Type::MCP_TOOLSET|'mcp_toolset' ? BetaManagedAgentsMCPToolsetParams : ($type is Type::CUSTOM|'custom' ? BetaManagedAgentsCustomToolParams : BetaManagedAgentsAgentToolset20260401Params|BetaManagedAgentsMCPToolsetParams|BetaManagedAgentsCustomToolParams)))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        ?array $configs = null,
        BetaManagedAgentsAgentToolsetDefaultConfigParams|array|BetaManagedAgentsMCPToolsetDefaultConfigParams|null $defaultConfig = null,
        ?string $mcpServerName = null,
        ?string $description = null,
        BetaManagedAgentsCustomToolInputSchema|array|null $inputSchema = null,
        ?string $name = null,
    ): BetaManagedAgentsAgentToolset20260401Params|BetaManagedAgentsMCPToolsetParams|BetaManagedAgentsCustomToolParams {
        return match ($type) {
            Type::AGENT_TOOLSET_20260401, 'agent_toolset_20260401' => BetaManagedAgentsAgentToolset20260401Params::with(
                type: 'agent_toolset_20260401',
                configs: $configs,
                defaultConfig: $defaultConfig,
            ),
            Type::MCP_TOOLSET, 'mcp_toolset' => BetaManagedAgentsMCPToolsetParams::with(
                type: 'mcp_toolset',
                mcpServerName: $mcpServerName ?? throw new \ArgumentCountError('$mcpServerName is required'),
                // @phpstan-ignore argument.type
                configs: $configs,
                // @phpstan-ignore argument.type
                defaultConfig: $defaultConfig,
            ),
            Type::CUSTOM, 'custom' => BetaManagedAgentsCustomToolParams::with(
                type: 'custom',
                description: $description ?? throw new \ArgumentCountError('$description is required'),
                inputSchema: $inputSchema ?? throw new \ArgumentCountError('$inputSchema is required'),
                name: $name ?? throw new \ArgumentCountError('$name is required'),
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
