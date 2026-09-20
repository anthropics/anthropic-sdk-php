<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaResponseToolAdditionBlock;

use Anthropic\Beta\Messages\BetaResponseToolChangeMCPToolReference;
use Anthropic\Beta\Messages\BetaResponseToolChangeMCPToolsetReference;
use Anthropic\Beta\Messages\BetaResponseToolChangeToolReference;
use Anthropic\Beta\Messages\BetaToolChangeToolDefinition;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * The tool made available: a reference to a `tools` entry or MCP toolset, or a `tool_definition` carrying the definition by value.
 *
 * @phpstan-import-type BetaResponseToolChangeToolReferenceShape from \Anthropic\Beta\Messages\BetaResponseToolChangeToolReference
 * @phpstan-import-type BetaResponseToolChangeMCPToolReferenceShape from \Anthropic\Beta\Messages\BetaResponseToolChangeMCPToolReference
 * @phpstan-import-type BetaResponseToolChangeMCPToolsetReferenceShape from \Anthropic\Beta\Messages\BetaResponseToolChangeMCPToolsetReference
 * @phpstan-import-type BetaToolChangeToolDefinitionShape from \Anthropic\Beta\Messages\BetaToolChangeToolDefinition
 *
 * @phpstan-type ToolVariants = BetaResponseToolChangeToolReference|BetaResponseToolChangeMCPToolReference|BetaResponseToolChangeMCPToolsetReference|BetaToolChangeToolDefinition
 * @phpstan-type ToolShape = ToolVariants|BetaResponseToolChangeToolReferenceShape|BetaResponseToolChangeMCPToolReferenceShape|BetaResponseToolChangeMCPToolsetReferenceShape|BetaToolChangeToolDefinitionShape
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
            'tool_definition' => BetaToolChangeToolDefinition::class,
        ];
    }
}
