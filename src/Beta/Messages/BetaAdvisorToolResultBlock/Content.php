<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaAdvisorToolResultBlock;

use Anthropic\Beta\Messages\BetaAdvisorRedactedResultBlock;
use Anthropic\Beta\Messages\BetaAdvisorResultBlock;
use Anthropic\Beta\Messages\BetaAdvisorToolResultError;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-import-type BetaAdvisorToolResultErrorShape from \Anthropic\Beta\Messages\BetaAdvisorToolResultError
 * @phpstan-import-type BetaAdvisorResultBlockShape from \Anthropic\Beta\Messages\BetaAdvisorResultBlock
 * @phpstan-import-type BetaAdvisorRedactedResultBlockShape from \Anthropic\Beta\Messages\BetaAdvisorRedactedResultBlock
 *
 * @phpstan-type ContentVariants = BetaAdvisorToolResultError|BetaAdvisorResultBlock|BetaAdvisorRedactedResultBlock
 * @phpstan-type ContentShape = ContentVariants|BetaAdvisorToolResultErrorShape|BetaAdvisorResultBlockShape|BetaAdvisorRedactedResultBlockShape
 */
final class Content implements ConverterSource
{
    use SdkUnion;

    /**
     * @return list<string|Converter|ConverterSource>|array<string,string|Converter|ConverterSource>
     */
    public static function variants(): array
    {
        return [
            BetaAdvisorToolResultError::class,
            BetaAdvisorResultBlock::class,
            BetaAdvisorRedactedResultBlock::class,
        ];
    }
}
