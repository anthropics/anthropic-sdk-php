<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * Token usage for a sampling iteration.
 *
 * @phpstan-import-type BetaMessageIterationUsageShape from \Anthropic\Beta\Messages\BetaMessageIterationUsage
 * @phpstan-import-type BetaCompactionIterationUsageShape from \Anthropic\Beta\Messages\BetaCompactionIterationUsage
 *
 * @phpstan-type BetaIterationsUsageItemVariants = BetaMessageIterationUsage|BetaCompactionIterationUsage
 * @phpstan-type BetaIterationsUsageItemShape = BetaIterationsUsageItemVariants|BetaMessageIterationUsageShape|BetaCompactionIterationUsageShape
 */
final class BetaIterationsUsageItem implements ConverterSource
{
    use SdkUnion;

    /**
     * @return list<string|Converter|ConverterSource>|array<string,string|Converter|ConverterSource>
     */
    public static function variants(): array
    {
        return [
            BetaMessageIterationUsage::class, BetaCompactionIterationUsage::class,
        ];
    }
}
