<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaCompactionBlockParam;

use Anthropic\Beta\Messages\BetaRequestToolAdditionBlock;
use Anthropic\Beta\Messages\BetaRequestToolRemovalBlock;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-import-type BetaRequestToolAdditionBlockShape from \Anthropic\Beta\Messages\BetaRequestToolAdditionBlock
 * @phpstan-import-type BetaRequestToolRemovalBlockShape from \Anthropic\Beta\Messages\BetaRequestToolRemovalBlock
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
}
