<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaResponseToolRemovalBlock;

use Anthropic\Beta\Messages\BetaResponseToolChangeMCPToolReference;
use Anthropic\Beta\Messages\BetaResponseToolChangeMCPToolsetReference;
use Anthropic\Beta\Messages\BetaResponseToolChangeToolReference;
use Anthropic\Beta\Messages\BetaResponseToolRemovalBlock\Tool\Type;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * A reference to the withdrawn `tools` entry, MCP tool or MCP toolset.
 *
 * @phpstan-import-type BetaResponseToolChangeToolReferenceShape from \Anthropic\Beta\Messages\BetaResponseToolChangeToolReference
 * @phpstan-import-type BetaResponseToolChangeMCPToolReferenceShape from \Anthropic\Beta\Messages\BetaResponseToolChangeMCPToolReference
 * @phpstan-import-type BetaResponseToolChangeMCPToolsetReferenceShape from \Anthropic\Beta\Messages\BetaResponseToolChangeMCPToolsetReference
 *
 * @phpstan-type ToolVariants = BetaResponseToolChangeToolReference|BetaResponseToolChangeMCPToolReference|BetaResponseToolChangeMCPToolsetReference
 * @phpstan-type ToolShape = ToolVariants|BetaResponseToolChangeToolReferenceShape|BetaResponseToolChangeMCPToolReferenceShape|BetaResponseToolChangeMCPToolsetReferenceShape
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
            'tool_reference' => BetaResponseToolChangeToolReference::class,
            'mcp_tool_reference' => BetaResponseToolChangeMCPToolReference::class,
            'mcp_toolset_reference' => BetaResponseToolChangeMCPToolsetReference::class,
        ];
    }

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @return ($type is Type::TOOL_REFERENCE|'tool_reference' ? BetaResponseToolChangeToolReference : ($type is Type::MCP_TOOL_REFERENCE|'mcp_tool_reference' ? BetaResponseToolChangeMCPToolReference : ($type is Type::MCP_TOOLSET_REFERENCE|'mcp_toolset_reference' ? BetaResponseToolChangeMCPToolsetReference : BetaResponseToolChangeToolReference|BetaResponseToolChangeMCPToolReference|BetaResponseToolChangeMCPToolsetReference)))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        ?string $name = null,
        ?string $serverName = null
    ): BetaResponseToolChangeToolReference|BetaResponseToolChangeMCPToolReference|BetaResponseToolChangeMCPToolsetReference {
        return match ($type) {
            Type::TOOL_REFERENCE, 'tool_reference' => BetaResponseToolChangeToolReference::with(
                name: $name ?? throw new \ArgumentCountError('$name is required')
            ),
            Type::MCP_TOOL_REFERENCE, 'mcp_tool_reference' => BetaResponseToolChangeMCPToolReference::with(
                name: $name ?? throw new \ArgumentCountError('$name is required'),
                serverName: $serverName ?? throw new \ArgumentCountError('$serverName is required'),
            ),
            Type::MCP_TOOLSET_REFERENCE, 'mcp_toolset_reference' => BetaResponseToolChangeMCPToolsetReference::with(
                serverName: $serverName ?? throw new \ArgumentCountError('$serverName is required'),
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
