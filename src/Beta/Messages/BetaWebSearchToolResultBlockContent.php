<?php

declare(strict_types=1);

namespace Anthropic\Beta\Messages;

use Anthropic\Core\Concerns\SdkUnion;
use Anthropic\Core\Conversion\Contracts\Converter;
use Anthropic\Core\Conversion\Contracts\ConverterSource;
use Anthropic\Core\Conversion\ListOf;

/**
 * @phpstan-import-type BetaWebSearchToolResultErrorObjectShape from \Anthropic\Beta\Messages\BetaWebSearchToolResultErrorObject
 * @phpstan-import-type BetaWebSearchResultBlockShape from \Anthropic\Beta\Messages\BetaWebSearchResultBlock
 *
 * @phpstan-type BetaWebSearchToolResultBlockContentVariants = BetaWebSearchToolResultErrorObject|list<BetaWebSearchResultBlock>
 * @phpstan-type BetaWebSearchToolResultBlockContentShape = BetaWebSearchToolResultBlockContentVariants|BetaWebSearchToolResultErrorObjectShape|list<BetaWebSearchResultBlockShape>
 */
final class BetaWebSearchToolResultBlockContent implements ConverterSource
{
    use SdkUnion;

    /**
     * @return list<string|Converter|ConverterSource>|array<string,string|Converter|ConverterSource>
     */
    public static function variants(): array
    {
        return [
            BetaWebSearchToolResultErrorObject::class,
            new ListOf(BetaWebSearchResultBlock::class),
        ];
    }
}
