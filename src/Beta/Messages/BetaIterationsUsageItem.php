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
 * @phpstan-import-type BetaAdvisorMessageIterationUsageShape from \Anthropic\Beta\Messages\BetaAdvisorMessageIterationUsage
 *
 * @phpstan-type BetaIterationsUsageItemVariants = BetaMessageIterationUsage|BetaCompactionIterationUsage|BetaAdvisorMessageIterationUsage
 * @phpstan-type BetaIterationsUsageItemShape = BetaIterationsUsageItemVariants|BetaMessageIterationUsageShape|BetaCompactionIterationUsageShape|BetaAdvisorMessageIterationUsageShape
 */
final class BetaIterationsUsageItem implements ConverterSource
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
            'message' => BetaMessageIterationUsage::class,
            'compaction' => BetaCompactionIterationUsage::class,
            'advisor_message' => BetaAdvisorMessageIterationUsage::class,
        ];
    }
}
