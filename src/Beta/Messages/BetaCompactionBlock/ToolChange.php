<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaCompactionBlock;

use Anthropic\Beta\Messages\BetaResponseToolAdditionBlock;
use Anthropic\Beta\Messages\BetaResponseToolRemovalBlock;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-import-type BetaResponseToolAdditionBlockShape from \Anthropic\Beta\Messages\BetaResponseToolAdditionBlock
 * @phpstan-import-type BetaResponseToolRemovalBlockShape from \Anthropic\Beta\Messages\BetaResponseToolRemovalBlock
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
}
