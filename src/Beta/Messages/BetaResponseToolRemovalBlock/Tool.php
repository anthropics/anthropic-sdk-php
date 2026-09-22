<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaResponseToolRemovalBlock;

use Anthropic\Beta\Messages\BetaResponseToolChangeMCPToolReference;
use Anthropic\Beta\Messages\BetaResponseToolChangeMCPToolsetReference;
use Anthropic\Beta\Messages\BetaResponseToolChangeToolReference;
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
}
