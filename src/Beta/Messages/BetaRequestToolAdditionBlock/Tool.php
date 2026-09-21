<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaRequestToolAdditionBlock;

use Anthropic\Beta\Messages\BetaAdvisorTool20260301;
use Anthropic\Beta\Messages\BetaBrowserToolset20260801;
use Anthropic\Beta\Messages\BetaCodeExecutionTool20250522;
use Anthropic\Beta\Messages\BetaCodeExecutionTool20250825;
use Anthropic\Beta\Messages\BetaCodeExecutionTool20260120;
use Anthropic\Beta\Messages\BetaCodeExecutionTool20260521;
use Anthropic\Beta\Messages\BetaComputerToolset20260801;
use Anthropic\Beta\Messages\BetaMCPToolset;
use Anthropic\Beta\Messages\BetaMemoryTool20250818;
use Anthropic\Beta\Messages\BetaRequestToolAdditionBlock\Tool\Type;
use Anthropic\Beta\Messages\BetaTool;
use Anthropic\Beta\Messages\BetaToolBash20241022;
use Anthropic\Beta\Messages\BetaToolBash20250124;
use Anthropic\Beta\Messages\BetaToolChangeMCPToolReference;
use Anthropic\Beta\Messages\BetaToolChangeMCPToolsetReference;
use Anthropic\Beta\Messages\BetaToolChangeToolDefinitionParam;
use Anthropic\Beta\Messages\BetaToolChangeToolReference;
use Anthropic\Beta\Messages\BetaToolComputerUse20241022;
use Anthropic\Beta\Messages\BetaToolComputerUse20250124;
use Anthropic\Beta\Messages\BetaToolComputerUse20251124;
use Anthropic\Beta\Messages\BetaToolSearchToolBm25_20251119;
use Anthropic\Beta\Messages\BetaToolSearchToolRegex20251119;
use Anthropic\Beta\Messages\BetaToolTextEditor20241022;
use Anthropic\Beta\Messages\BetaToolTextEditor20250124;
use Anthropic\Beta\Messages\BetaToolTextEditor20250429;
use Anthropic\Beta\Messages\BetaToolTextEditor20250728;
use Anthropic\Beta\Messages\BetaWebFetchTool20250910;
use Anthropic\Beta\Messages\BetaWebFetchTool20260209;
use Anthropic\Beta\Messages\BetaWebFetchTool20260309;
use Anthropic\Beta\Messages\BetaWebFetchTool20260318;
use Anthropic\Beta\Messages\BetaWebSearchTool20250305;
use Anthropic\Beta\Messages\BetaWebSearchTool20260209;
use Anthropic\Beta\Messages\BetaWebSearchTool20260318;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-import-type BetaToolChangeToolReferenceShape from \Anthropic\Beta\Messages\BetaToolChangeToolReference
 * @phpstan-import-type BetaToolChangeMCPToolReferenceShape from \Anthropic\Beta\Messages\BetaToolChangeMCPToolReference
 * @phpstan-import-type BetaToolChangeMCPToolsetReferenceShape from \Anthropic\Beta\Messages\BetaToolChangeMCPToolsetReference
 * @phpstan-import-type BetaToolChangeToolDefinitionParamShape from \Anthropic\Beta\Messages\BetaToolChangeToolDefinitionParam
 * @phpstan-import-type BetaToolUnionShape from \Anthropic\Beta\Messages\BetaToolUnion
 *
 * @phpstan-type ToolVariants = BetaToolChangeToolReference|BetaToolChangeMCPToolReference|BetaToolChangeMCPToolsetReference|BetaToolChangeToolDefinitionParam
 * @phpstan-type ToolShape = ToolVariants|BetaToolChangeToolReferenceShape|BetaToolChangeMCPToolReferenceShape|BetaToolChangeMCPToolsetReferenceShape|BetaToolChangeToolDefinitionParamShape
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
            'tool_reference' => BetaToolChangeToolReference::class,
            'mcp_tool_reference' => BetaToolChangeMCPToolReference::class,
            'mcp_toolset_reference' => BetaToolChangeMCPToolsetReference::class,
            'tool_definition' => BetaToolChangeToolDefinitionParam::class,
        ];
    }

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @param BetaToolUnionShape|null $definition
     *
     * @return ($type is Type::TOOL_REFERENCE|'tool_reference' ? BetaToolChangeToolReference : ($type is Type::MCP_TOOL_REFERENCE|'mcp_tool_reference' ? BetaToolChangeMCPToolReference : ($type is Type::MCP_TOOLSET_REFERENCE|'mcp_toolset_reference' ? BetaToolChangeMCPToolsetReference : ($type is Type::TOOL_DEFINITION|'tool_definition' ? BetaToolChangeToolDefinitionParam : BetaToolChangeToolReference|BetaToolChangeMCPToolReference|BetaToolChangeMCPToolsetReference|BetaToolChangeToolDefinitionParam))))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        ?string $name = null,
        ?string $serverName = null,
        BetaTool|array|BetaToolBash20241022|BetaToolBash20250124|BetaCodeExecutionTool20250522|BetaCodeExecutionTool20250825|BetaCodeExecutionTool20260120|BetaCodeExecutionTool20260521|BetaBrowserToolset20260801|BetaToolComputerUse20241022|BetaMemoryTool20250818|BetaToolComputerUse20250124|BetaToolTextEditor20241022|BetaToolComputerUse20251124|BetaComputerToolset20260801|BetaToolTextEditor20250124|BetaToolTextEditor20250429|BetaToolTextEditor20250728|BetaWebSearchTool20250305|BetaWebFetchTool20250910|BetaWebSearchTool20260209|BetaWebFetchTool20260209|BetaWebFetchTool20260309|BetaWebSearchTool20260318|BetaWebFetchTool20260318|BetaAdvisorTool20260301|BetaToolSearchToolBm25_20251119|BetaToolSearchToolRegex20251119|BetaMCPToolset|null $definition = null,
    ): BetaToolChangeToolReference|BetaToolChangeMCPToolReference|BetaToolChangeMCPToolsetReference|BetaToolChangeToolDefinitionParam {
        return match ($type) {
            Type::TOOL_REFERENCE, 'tool_reference' => BetaToolChangeToolReference::with(
                name: $name ?? throw new \ArgumentCountError('$name is required')
            ),
            Type::MCP_TOOL_REFERENCE, 'mcp_tool_reference' => BetaToolChangeMCPToolReference::with(
                name: $name ?? throw new \ArgumentCountError('$name is required'),
                serverName: $serverName ?? throw new \ArgumentCountError('$serverName is required'),
            ),
            Type::MCP_TOOLSET_REFERENCE, 'mcp_toolset_reference' => BetaToolChangeMCPToolsetReference::with(
                serverName: $serverName ?? throw new \ArgumentCountError('$serverName is required'),
            ),
            Type::TOOL_DEFINITION, 'tool_definition' => BetaToolChangeToolDefinitionParam::with(
                definition: $definition ?? throw new \ArgumentCountError('$definition is required'),
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
