<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaRequestToolRemovalBlock;

use Anthropic\Beta\Messages\BetaToolChangeMCPToolReference;
use Anthropic\Beta\Messages\BetaToolChangeMCPToolsetReference;
use Anthropic\Beta\Messages\BetaToolChangeToolReference;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Reference to a single tool the caller declared directly in
 * ``tools[]``. Does not accept the composed ``{server}_{name}`` form the
 * server assigns to MCP-resolved tools — use ``mcp_tool_reference`` or
 * ``mcp_toolset_reference`` for those.
 *
 * @phpstan-import-type BetaToolChangeToolReferenceShape from \Anthropic\Beta\Messages\BetaToolChangeToolReference
 * @phpstan-import-type BetaToolChangeMCPToolReferenceShape from \Anthropic\Beta\Messages\BetaToolChangeMCPToolReference
 * @phpstan-import-type BetaToolChangeMCPToolsetReferenceShape from \Anthropic\Beta\Messages\BetaToolChangeMCPToolsetReference
 *
 * @phpstan-type ToolVariants = BetaToolChangeToolReference|BetaToolChangeMCPToolReference|BetaToolChangeMCPToolsetReference
 * @phpstan-type ToolShape = ToolVariants|BetaToolChangeToolReferenceShape|BetaToolChangeMCPToolReferenceShape|BetaToolChangeMCPToolsetReferenceShape
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
        ];
    }
}
