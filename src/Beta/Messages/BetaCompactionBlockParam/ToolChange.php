<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaCompactionBlockParam;

use Anthropic\Beta\Messages\BetaCacheControlEphemeral;
use Anthropic\Beta\Messages\BetaCompactionBlockParam\ToolChange\Type;
use Anthropic\Beta\Messages\BetaRequestToolAdditionBlock;
use Anthropic\Beta\Messages\BetaRequestToolRemovalBlock;
use Anthropic\Beta\Messages\BetaToolChangeMCPToolReference;
use Anthropic\Beta\Messages\BetaToolChangeMCPToolsetReference;
use Anthropic\Beta\Messages\BetaToolChangeToolDefinitionParam;
use Anthropic\Beta\Messages\BetaToolChangeToolReference;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-import-type BetaRequestToolAdditionBlockShape from \Anthropic\Beta\Messages\BetaRequestToolAdditionBlock
 * @phpstan-import-type BetaRequestToolRemovalBlockShape from \Anthropic\Beta\Messages\BetaRequestToolRemovalBlock
 * @phpstan-import-type ToolShape from \Anthropic\Beta\Messages\BetaRequestToolAdditionBlock\Tool
 * @phpstan-import-type ToolShape from \Anthropic\Beta\Messages\BetaRequestToolRemovalBlock\Tool as ToolShape1
 * @phpstan-import-type BetaCacheControlEphemeralShape from \Anthropic\Beta\Messages\BetaCacheControlEphemeral
 *
 * @phpstan-type ToolChangeVariants = BetaRequestToolAdditionBlock|BetaRequestToolRemovalBlock
 * @phpstan-type ToolChangeShape = ToolChangeVariants|BetaRequestToolAdditionBlockShape|BetaRequestToolRemovalBlockShape
 */
final class ToolChange implements ConverterSource
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
            'tool_addition' => BetaRequestToolAdditionBlock::class,
            'tool_removal' => BetaRequestToolRemovalBlock::class,
        ];
    }

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @param ($type is Type::TOOL_ADDITION|'tool_addition' ? ToolShape : ToolShape1) $tool
     * @param BetaCacheControlEphemeral|BetaCacheControlEphemeralShape|null $cacheControl
     *
     * @return ($type is Type::TOOL_ADDITION|'tool_addition' ? BetaRequestToolAdditionBlock : ($type is Type::TOOL_REMOVAL|'tool_removal' ? BetaRequestToolRemovalBlock : BetaRequestToolAdditionBlock|BetaRequestToolRemovalBlock))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        BetaToolChangeToolReference|array|BetaToolChangeMCPToolReference|BetaToolChangeMCPToolsetReference|BetaToolChangeToolDefinitionParam $tool,
        BetaCacheControlEphemeral|array|null $cacheControl = null,
    ): BetaRequestToolAdditionBlock|BetaRequestToolRemovalBlock {
        return match ($type) {
            Type::TOOL_ADDITION, 'tool_addition' => BetaRequestToolAdditionBlock::with(
                tool: $tool,
                cacheControl: $cacheControl
            ),
            Type::TOOL_REMOVAL, 'tool_removal' => BetaRequestToolRemovalBlock::with(
                // @phpstan-ignore argument.type
                tool: $tool,
                cacheControl: $cacheControl,
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
