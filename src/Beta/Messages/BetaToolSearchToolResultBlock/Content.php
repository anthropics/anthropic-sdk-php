<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaToolSearchToolResultBlock;

use Anthropic\Beta\Messages\BetaToolSearchToolResultErrorObject;
use Anthropic\Beta\Messages\BetaToolSearchToolSearchResultBlock;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-import-type BetaToolSearchToolResultErrorObjectShape from \Anthropic\Beta\Messages\BetaToolSearchToolResultErrorObject
 * @phpstan-import-type BetaToolSearchToolSearchResultBlockShape from \Anthropic\Beta\Messages\BetaToolSearchToolSearchResultBlock
 *
 * @phpstan-type ContentVariants = BetaToolSearchToolResultErrorObject|BetaToolSearchToolSearchResultBlock
 * @phpstan-type ContentShape = ContentVariants|BetaToolSearchToolResultErrorObjectShape|BetaToolSearchToolSearchResultBlockShape
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
            BetaToolSearchToolResultErrorObject::class,
            BetaToolSearchToolSearchResultBlock::class,
        ];
    }
}
