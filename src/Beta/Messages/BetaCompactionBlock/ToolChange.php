<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaCompactionBlock;

use Anthropic\Beta\Messages\BetaCompactionBlock\ToolChange\Type;
use Anthropic\Beta\Messages\BetaResponseToolAdditionBlock;
use Anthropic\Beta\Messages\BetaResponseToolChangeMCPToolReference;
use Anthropic\Beta\Messages\BetaResponseToolChangeMCPToolsetReference;
use Anthropic\Beta\Messages\BetaResponseToolChangeToolReference;
use Anthropic\Beta\Messages\BetaResponseToolRemovalBlock;
use Anthropic\Beta\Messages\BetaToolChangeToolDefinition;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-import-type BetaResponseToolAdditionBlockShape from \Anthropic\Beta\Messages\BetaResponseToolAdditionBlock
 * @phpstan-import-type BetaResponseToolRemovalBlockShape from \Anthropic\Beta\Messages\BetaResponseToolRemovalBlock
 * @phpstan-import-type ToolShape from \Anthropic\Beta\Messages\BetaResponseToolAdditionBlock\Tool
 * @phpstan-import-type ToolShape from \Anthropic\Beta\Messages\BetaResponseToolRemovalBlock\Tool as ToolShape1
 *
 * @phpstan-type ToolChangeVariants = BetaResponseToolAdditionBlock|BetaResponseToolRemovalBlock
 * @phpstan-type ToolChangeShape = ToolChangeVariants|BetaResponseToolAdditionBlockShape|BetaResponseToolRemovalBlockShape
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
            'tool_addition' => BetaResponseToolAdditionBlock::class,
            'tool_removal' => BetaResponseToolRemovalBlock::class,
        ];
    }

    /**
     * Constructs the variant whose `type` matches the given value, forwarding the remaining arguments to its own `with()`.
     *
     * @param ($type is Type::TOOL_ADDITION|'tool_addition' ? ToolShape : ToolShape1) $tool
     *
     * @return ($type is Type::TOOL_ADDITION|'tool_addition' ? BetaResponseToolAdditionBlock : ($type is Type::TOOL_REMOVAL|'tool_removal' ? BetaResponseToolRemovalBlock : BetaResponseToolAdditionBlock|BetaResponseToolRemovalBlock))
     *
     * @throws \UnhandledMatchError
     */
    public static function with(
        Type|string $type,
        BetaResponseToolChangeToolReference|array|BetaResponseToolChangeMCPToolReference|BetaResponseToolChangeMCPToolsetReference|BetaToolChangeToolDefinition $tool,
    ): BetaResponseToolAdditionBlock|BetaResponseToolRemovalBlock {
        return match ($type) {
            Type::TOOL_ADDITION, 'tool_addition' => BetaResponseToolAdditionBlock::with(
                tool: $tool
            ),
            Type::TOOL_REMOVAL, 'tool_removal' => BetaResponseToolRemovalBlock::with(
                // @phpstan-ignore argument.type
                tool: $tool,
            ),
            default => throw new \UnhandledMatchError(sprintf('Unhandled match case %s', var_export($type, true)))
        };
    }
}
