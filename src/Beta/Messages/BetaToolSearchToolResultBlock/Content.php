<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages\BetaToolSearchToolResultBlock;

use Anthropic\Beta\Messages\BetaToolSearchToolResultError;
use Anthropic\Beta\Messages\BetaToolSearchToolSearchResultBlock;
use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;

/**
 * @phpstan-import-type BetaToolSearchToolResultErrorShape from \Anthropic\Beta\Messages\BetaToolSearchToolResultError
 * @phpstan-import-type BetaToolSearchToolSearchResultBlockShape from \Anthropic\Beta\Messages\BetaToolSearchToolSearchResultBlock
 *
 * @phpstan-type ContentShape = BetaToolSearchToolResultErrorShape|BetaToolSearchToolSearchResultBlockShape
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
            BetaToolSearchToolResultError::class,
            BetaToolSearchToolSearchResultBlock::class,
        ];
    }
}
