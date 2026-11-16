<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaAdvisorToolResultBlock;

use Anthropic\Beta\Messages\BetaAdvisorRedactedResultBlock;
use Anthropic\Beta\Messages\BetaAdvisorResultBlock;
use Anthropic\Beta\Messages\BetaAdvisorToolResultErrorObject;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-import-type BetaAdvisorToolResultErrorObjectShape from \Anthropic\Beta\Messages\BetaAdvisorToolResultErrorObject
 * @phpstan-import-type BetaAdvisorResultBlockShape from \Anthropic\Beta\Messages\BetaAdvisorResultBlock
 * @phpstan-import-type BetaAdvisorRedactedResultBlockShape from \Anthropic\Beta\Messages\BetaAdvisorRedactedResultBlock
 *
 * @phpstan-type ContentVariants = BetaAdvisorToolResultErrorObject|BetaAdvisorResultBlock|BetaAdvisorRedactedResultBlock
 * @phpstan-type ContentShape = ContentVariants|BetaAdvisorToolResultErrorObjectShape|BetaAdvisorResultBlockShape|BetaAdvisorRedactedResultBlockShape
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
            BetaAdvisorToolResultErrorObject::class,
            BetaAdvisorResultBlock::class,
            BetaAdvisorRedactedResultBlock::class,
        ];
    }
}
