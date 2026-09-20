<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaRequestToolAdditionBlock;

use Anthropic\Beta\Messages\BetaToolChangeMCPToolReference;
use Anthropic\Beta\Messages\BetaToolChangeMCPToolsetReference;
use Anthropic\Beta\Messages\BetaToolChangeToolDefinitionParam;
use Anthropic\Beta\Messages\BetaToolChangeToolReference;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-import-type BetaToolChangeToolReferenceShape from \Anthropic\Beta\Messages\BetaToolChangeToolReference
 * @phpstan-import-type BetaToolChangeMCPToolReferenceShape from \Anthropic\Beta\Messages\BetaToolChangeMCPToolReference
 * @phpstan-import-type BetaToolChangeMCPToolsetReferenceShape from \Anthropic\Beta\Messages\BetaToolChangeMCPToolsetReference
 * @phpstan-import-type BetaToolChangeToolDefinitionParamShape from \Anthropic\Beta\Messages\BetaToolChangeToolDefinitionParam
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
}
